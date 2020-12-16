<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public function resi(){
        return $this->belongsTo('App\Resi');
    }
    public function layanan(){
        return $this->belongsTo('App\Layanan');
    }
    public function kerusakans(){
        return $this->hasMany('App\Kerusakan');
    }
    public function spareparts(){
        return $this->hasMany('App\Sparepart');
    }
    public function status_barangs(){
        return $this->hasMany('App\StatusBarang');
    }
}
