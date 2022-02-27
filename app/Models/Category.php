<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $guarded = [];
    public $translatedAttributes = ['title'];
    public $timestamps = false;
    protected $hidden = ['translations'];

    public function meals(){
        return $this->hasMany(Meal::class);
    }


}
