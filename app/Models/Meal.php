<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    public $guarded = [];
    public $translatedAttributes = ['title', 'description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'category_id', 'translations'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients(){
        #forgot to name migration in alphabetical order
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }

    public function scopeMealCategoryFilter($query, $category){
        if ($category == 'NULL'){
            $query->where('category_id', '=', null);
        } else if ($category == '!NULL') {
            $query->where('category_id', '!=', null);
        } else {
            $category = (int) $category;
            $query->where('category_id', '=', $category);
        }
        return $query;
    }

    public function scopeMealTagFilter($query, $tags){

        $tags = array_map('intval', explode(',', $tags));
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tag_id', $tags);
        }, '=', count($tags));
    }

    public function scopeMealAfterTimeStampFilter($query, $diff_time){
        return $query->withTrashed()->where('created_at', '>', $diff_time)
                                    ->orWhere('updated_at', '>', $diff_time)
                                    ->orWhere('deleted_at', '>', $diff_time);
    }
}
