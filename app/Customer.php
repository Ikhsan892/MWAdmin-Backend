<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function resis(){
        return $this->hasMany('App\Resi');
    }
}
