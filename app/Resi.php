<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    public function status_pembayaran()
    {
        return $this->belongsTo('App\StatusPembayaran');
    }
    public function metode_pembayaran()
    {
        return $this->belongsTo('App\MetodePembayaran');
    }
    public function kurir()
    {
        return $this->belongsTo('App\Kurir', 'pengiriman_id');
    }
    public function status_kerjaan()
    {
        return $this->belongsTo('App\StatusKerjaan');
    }
    public function barangs()
    {
        return $this->hasMany('App\Barang');
    }
    public function subtotal_resis()
    {
        return $this->hasMany('App\SubtotalResi');
    }
    public function spareparts()
    {
        return $this->hasMany('App\Sparepart');
    }
}
