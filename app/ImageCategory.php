<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageCategory extends Model
{
    protected $table = 'image_category';

    public function images(){
        return $this->hasMany(Image::class);
    }
}
