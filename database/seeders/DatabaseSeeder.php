<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        Category::factory(5)->create();
        Tag::factory(5)->create();
        Ingredient::factory(5)->create();
        Meal::factory(5)->create();
        
        // Populate the pivot table
        $tags = Tag::all();
        $ingredients = Ingredient::all();

        Meal::all()->each(function ($meal) use ($tags) { 
            $meal->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            ); 
        });

        Meal::all()->each(function ($meal) use ($ingredients) { 
            $meal->ingredients()->attach(
                $ingredients->random(rand(1, 5))->pluck('id')->toArray()
            ); 
        });
    }
}
