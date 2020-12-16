<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function blog()
    {
        return   $this->hasMany(Blog::class);
    }
    public function category($param)
    {
        $result = self::where('name', $param)->get();
        if ($result->count() < 1) {
            return 'tutorial empty';
        } else {
            $id = $result->pluck('id')[0];
            $search_by_category = self::find($id)->blog;
            if ($search_by_category->count() < 1) {
                return 'blog empty';
            } else {
                return $search_by_category;
            }
        }
    }
}
