<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['image','alt'];
    public function image_category(){
        return $this->belongsTo(ImageCategory::class);
    }
}
