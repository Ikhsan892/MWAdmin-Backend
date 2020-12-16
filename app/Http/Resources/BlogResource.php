<?php

namespace App\Http\Resources;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->map(function ($collection) {
            return [
                'id' => $collection->id,
                'title' => $collection->title,
                'slug' => $collection->slug,
                'category' => Category::find($collection->category_id)->name,
                'preview' => \Str::limit($collection->body, 100),
                'image_heading' => $collection->image_heading,
                'created_at' => Carbon::parse($collection->created_at)->translatedFormat('l, d F Y'),
            ];
        });
    }
}
