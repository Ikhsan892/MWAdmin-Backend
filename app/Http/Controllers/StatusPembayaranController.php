<?php

namespace App\Http\Controllers;

use App\StatusPembayaran;
use Exception;
use Illuminate\Http\Request;

class StatusPembayaranController extends Controller
{
    public function index()
    {
        try {
            $data = StatusPembayaran::all();
            return response()->json($data, 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
