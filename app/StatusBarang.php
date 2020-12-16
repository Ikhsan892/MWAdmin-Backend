<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusBarang extends Model
{
    public function barang(){
        return $this->belongsTo('App\Barang');
    }
}
