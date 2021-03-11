<?php

namespace App\Http\Controllers;

use App\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        $metode = MetodePembayaran::all();

        return response()->json($metode, 201);
    }
}
