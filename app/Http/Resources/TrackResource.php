<?php

namespace App\Http\Resources;

use App\Barang;
use App\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->map(function($item){
            return [
                'barang' => $item->nama_barang,
                'tanggal_masuk' => Carbon::parse($item->created_at)->translatedFormat('l, d F Y'),
                'layanan' => Layanan::find($item->layanan_id)->nama_layanan,
                'kerusakan' => new KerusakanResource(Barang::find($item->id)->kerusakans),
                'status' => new StatusResource(Barang::find($item->id)->status_barangs),
                'active_status' => $item->active_status
            ];
        });
    }
}
