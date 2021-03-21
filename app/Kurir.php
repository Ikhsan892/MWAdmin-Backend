<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    public function resis()
    {
        return $this->hasMany('App\Resi', 'pengiriman_id');
    }
}
