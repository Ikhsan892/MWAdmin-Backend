<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public static $title;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function listAll()
    {
        return self::get();
    }
    public function search($param)
    {
        return self::where('title', 'LIKE', '%' . $param . '%')->get();
    }
    public function details($slug)
    {
        $get_id = self::where('slug', $slug)->get();
        if ($get_id->count() < 1) {
            return null;
        } else {
            $id = $get_id->pluck('id')[0];
            return self::find($id);
        }
    }
    public static function get_blog_by_category($category, $judul)
    {
        static::$title = $judul;
        $max = 5;
        $c = Category::where('name', $category)->get();
        $id = $c->pluck('id')[0];
        $article = self::where('category_id', $id)->where(function ($query) {
            return $query->where('title', '!=', static::$title)->limit(5);
        })->get();
        if ($article->count() < $max) {
            $appendix = self::where('category_id', '!=', $id)->limit($max - $article->count())->get();
            return $article->concat($appendix);
        } else {
            return $article;
        }
    }
}
