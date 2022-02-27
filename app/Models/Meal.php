<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $guarded = [];
    public $translatedAttributes = ['title', 'description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'category_id', 'translations'];

    public function category(){
        #TODO: maybe make ->withDefault() in case of empty;
        #example : return $this->belongsTo(User::class)->withDefault([
        #    'name' => 'Guest Author',
        #    ]);
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients(){
        #forgot to name migration in alphabetical order
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }
}
