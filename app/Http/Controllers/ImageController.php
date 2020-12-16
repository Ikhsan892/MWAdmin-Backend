<?php

namespace App\Http\Controllers;

use App\Image;
use App\ImageCategory;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index(){
        $image = Image::get();
        return response()->json($image,200);
    }
    public function insertImageWithJsonRequest(Request $request){
        $array = array(
            'image' => base64_encode(file_get_contents($request->image)),
            'alt' => $request->label,
        );
        $category = ImageCategory::find(2);
        $imageForSave = new Image($array);
        $category->images()->save($imageForSave);
        return response()->json($category->images,200);
    }
    public function updateImage(Image $image){
        $attr = request()->validate([
            'id' => 'required',
            'image' => 'required',
            'alt' => 'required'
        ]);
        $image->where('id',$attr['id'])->update([
            'alt' => $attr['alt'],
            'image' => base64_encode(file_get_contents($attr['image']))
        ]);
        return response('updated',404);
    }
}