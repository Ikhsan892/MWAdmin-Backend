<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubtotalResi extends Model
{
    public function resi(){
        return $this->belongsTo('App\Resi');
    }
}
