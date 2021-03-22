<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    public function barang()
    {
        return $this->belongsTo('App\Barang');
    }

    public function spareparts()
    {
        return $this->hasMany('App\Sparepart');
    }
}
