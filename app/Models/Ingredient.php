<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = false;
    protected $hidden = ['translations', 'pivot'];

    public function meals(){
        return $this->belongsToMany(Meals::class, 'meal_ingredient');
    }
}
