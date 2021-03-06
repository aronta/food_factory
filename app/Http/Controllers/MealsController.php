<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealCollection;
use App\Models\Category;
use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MealsController extends Controller
{
    public function filter_meals(Request $request){

        #I could make specific request with rules but for now it is easier to validate in controller
        #If this request repeated in multiple controler function than it would be nicer

        #This would be mock prepareForValidation, if i am expecting always string with delimiter ,
        if(isset($request->with)){
            $request['with'] = explode(',', $request['with']);
        }
        if(isset($request->tags)){
            $request['tags'] = explode(',', $request['tags']);
        }
        if (isset($request->category)){
            $categories_valid_array = Category::pluck('id')->toArray();
            array_push($categories_valid_array, "NULL", "!NULL");
        } else {
            $categories_valid_array = [];
        }

        $validator = Validator::make($request->all(), [
            'per_page' => 'sometimes|numeric',
            'page' => 'sometimes|numeric',
            'category' => ['sometimes', Rule::in($categories_valid_array)],
            'with.*' => ['sometimes', Rule::in(['ingredients', 'category', 'tags'])],
            'diff_time' =>  'sometimes|numeric|min:1',
            'lang' => 'required|exists:languages,locale',
            'tags.*' => 'sometimes|exists:tags,id'
        ]);

        if ($validator->fails()) {
            # It is not stated in the task what should i return if validation fails; commonly validation errors are returned
            # And if we want we can write what every validation error should return
            return $validator->errors();
            #return 'Wrong parameters';
        }

        $validated = $validator->validated();

        #I could keep original request too but no time
        #need this for ->withQueryString(); to be correct
        if(isset($request->with)){
            $request['with'] = implode(',', $request['with']);
        }
        if(isset($request->tags)){
            $request['tags'] = implode(',', $request['tags']);
        }

        $lang = $validated['lang'];

        $meals = Meal::when($request->category, function ($query) use ($request) {
                return $query->mealCategoryFilter($request->category);
        })->when($request->tags, function ($query) use ($request) {
                return $query->mealTagFilter($request->tags);
        })->when($request->diff_time, function ($query) use ($request) {
                return $query->mealAfterTimeStampFilter(Carbon::createFromTimestamp($request->diff_time)->toDateTimeString());
        });

        if($request->per_page){
             $meals = $meals->paginate($validated['per_page'])->withQueryString();
        } else {
            #$meals = $meals->get();
            $meals = $meals->paginate()->withQueryString();
        }

        $meals->each(function ($meal) use ($lang){
            $meal->title = $meal->{'title:'.$lang};
            $meal->description = $meal->{'description:'.$lang};
        });

        # Lazy eager loading relations connected to Meal if needed - WITH
        if (isset($validated['with'])){
            foreach($validated['with'] as $value){
                if ($value == 'category'){
                    $meals->load('category');
                    $meals->each(function ($meal) use ($lang){
                        if($meal->category){
                            $meal->category->title = $meal->category->{'title:'.$lang};
                        };
                    });
                }
                if ($value == 'tags'){
                    $meals->load('tags');
                    $meals->each(function ($meal) use ($lang){
                        $meal->tags->each(function ($tag) use ($lang){
                            $tag->title = $tag->{'title:'.$lang};
                        });
                    });
                }
                if ($value == 'ingredients'){
                    $meals->load('ingredients');
                    $meals->each(function ($meal) use ($lang){
                        $meal->ingredients->each(function ($ingredient) use ($lang){
                            $ingredient->title = $ingredient->{'title:'.$lang};
                        });
                    });
                }
            }
        };

        return new MealCollection($meals);
    }
}
