<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kurir;

class KurirController extends Controller
{
    public function index(Request $request) {
        return Kurir::all();
    }
}
