<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{   
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {   
        #Factory for Category and CategoryTranslations (easier than having 2 Factories)
        $slug_numb = $this->faker->unique()->numberBetween(0,1000);
        $locales = Language::pluck('locale');
        $data = array('slug' => 'category-'.$slug_numb);

        foreach($locales as $locale) {
            $data[$locale] = [
                'title' => 'Title for category-'.$slug_numb.' on language '.\strtoupper($locale)
            ];
        }

        return $data;
    }
}
