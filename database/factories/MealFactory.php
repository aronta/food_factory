<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   

        $categories_numb = Category::count();
        $optional_category = $this->faker->boolean(50) ? $this->faker->numberBetween(1, $categories_numb) : null;
        $locales = Language::pluck('locale');
        $data = array('category_id' => $optional_category);

        static $cnt = 1;

        foreach($locales as $locale) {
            $data[$locale] = [
                'title' => 'Title for meal-'.$cnt.' on language '.\strtoupper($locale),
                'description' => 'Description for meal-'.$cnt.' on language '.\strtoupper($locale),
            ];
        }

        $cnt++;

        return $data;
    }
}
