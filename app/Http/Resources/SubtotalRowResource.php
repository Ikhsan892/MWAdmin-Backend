<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubtotalRowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $display =  $this->subtotal_resis->map(function($item){
            return [
                'judul' => $item->nama_subtotal,
                'biaya' => $item->nominal
            ];
        });
        return $display;
    }
}
