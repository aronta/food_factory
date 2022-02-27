<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{   
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $slug_numb = $this->faker->unique()->numberBetween(0,1000);
        $locales = Language::pluck('locale');
        $data = array('slug' => 'ingredient-'.$slug_numb);

        foreach($locales as $locale) {
            $data[$locale] = [
                'title' => 'Title for ingredient-'.$slug_numb.' on language '.\strtoupper($locale)
            ];
        }

        return $data;
    }
}
