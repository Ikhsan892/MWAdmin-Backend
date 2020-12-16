<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'navbar' => $this->navbar,
            'carousel' => $this->carousel,
            'MCarousel' => $this->MCarousel,
            'footer' => $this->footer,
            'footer_bottom' => $this->footer_bottom
        ];
    }
}
