<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{   
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $slug_numb = $this->faker->unique()->numberBetween(0,1000);
        $locales = Language::pluck('locale');
        $data = array('slug' => 'tag-'.$slug_numb);

        foreach($locales as $locale) {
            $data[$locale] = [
                'title' => 'Title for tag-'.$slug_numb.' on language '.\strtoupper($locale)
            ];
        }

        return $data;
    }
}
