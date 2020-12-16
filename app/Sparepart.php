<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    public function barang(){
        return $this->belongsTo('App\Barang');
    }
    public function resi(){
        return $this->belongsTo('App\Resi');
    }
}
