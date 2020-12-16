<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\map;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->count() < 1){
            $none =  array(
                'nama_status' => '',
                'deskripsi_status' => '',
                'created_diff' => ' ? - ?'
            );
            return [$none];
        }else{
            return $this->sortBy('created_at')->map(function($status){
                return [
                    'nama_status' => $status->langkah_langkah,
                    'deskripsi_status' => $status->deskripsi_langkah,
                    'created_diff' => $status->created_at->diffForHumans()
                ];
            });
        }
    }
}
