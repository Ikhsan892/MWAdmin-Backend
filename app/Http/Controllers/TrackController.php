<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Http\Resources\TrackResource;
use App\Resi;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index(Request $request){
        $resi_id = Resi::where('no_resi',$request->get('no_resi'))->get('id');
        if($resi_id->count() < 1){
            return response()->json([
                'data' => 'empty'
            ],404);
        }else{
        $resi = Resi::find($resi_id[0]->id);
        $barang = Barang::whereIn('id',$resi->barangs->pluck('id'))->get();
            return response()->json([
                'no_resi' => $resi->no_resi,
                'customer' => $resi->customer->nama_depan.' '.$resi->customer->nama_belakang,
                'status_kerjaan' => $resi->status_kerjaan->id,
                'jumlah_barang' => $resi->barangs->count(),
                'barang' => new TrackResource($barang),
            ],200);
        }
    }
}
