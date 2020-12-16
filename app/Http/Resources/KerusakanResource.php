<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KerusakanResource extends JsonResource
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
            return $item->nama_kerusakan;
        });
    }
}
