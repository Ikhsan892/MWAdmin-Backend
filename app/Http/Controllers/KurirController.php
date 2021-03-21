<?php

namespace App\Http\Controllers;

use App\Kurir;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function index()
    {
        $kurir = Kurir::all();
        return response()->json($kurir, 201);
    }
}
