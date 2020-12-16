<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Blog;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailsResource extends JsonResource
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
            'title' => $this->title,
            'tanggal' => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'category' => $this->category->name,
            'image_heading' => $this->image_heading,
            'body' => $this->body,
            'recommended' => new BlogResource(Blog::get_blog_by_category($this->category->name, $this->title))
        ];
    }
}
