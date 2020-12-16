<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Http\Resources\BlogDetailsResource;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $req, Blog $blog, Category $category)
    {
        if ($req->get('search') == 'null' && $req->get('category') == 'null') {
            return response()->json(new BlogResource($blog->listAll()), 200);
        } elseif ($req->get('search') == 'null' && $req->get('category') !== 'null') {
            $category_search = $category->category($req->get('category'));
            if ($category_search == 'tutorial empty') {
                return response('Category tidak ditemukan', 404);
            } else {
                if ($category_search == 'blog empty') {
                    return response('blog tidak ditemukan', 404);
                } else {
                    return response()->json(new BlogResource($category_search), 200);
                }
            }
        } elseif ($req->get('search') !== 'null' && $req->get('category') == 'null') {
            if ($blog->search($req->get('search'))->count() < 1) {
                return response('Hasil tidak ditemukan', 404);
            } else {
                return response(new BlogResource($blog->search($req->get('search'))), 200);
            }
        }
    }
    public function category_list()
    {
        return Category::all()->pluck('name');
    }
    public function blogDetails(Request $req, Blog $blog)
    {
        $result = $blog->details($req->get('slug'));
        if ($result == null) {
            return response('Blog tidak ditemukan, harap periksa link url', 404);
        } else {
            return response()->json(new BlogDetailsResource($result), 200);
        }
    }
}
