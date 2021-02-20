<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceDoubleRowResource;
use App\Http\Resources\SubtotalRowResource;
use App\Resi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $resi_from_search = Resi::where('no_resi', $request->get('no_resi'))->get('id');
        if ($resi_from_search->count() < 1) {
            return response()->json([
                'data' => 'empty'
            ], 404);
        } else {
            $id_resi = $resi_from_search[0]->id;
            $resi = Resi::find($id_resi);
            $tanggal = Carbon::parse($resi->created_at)->translatedFormat('l, d F Y');
            return response()->json([
                'tanggal' => $tanggal,
                'pengiriman' => $resi->kurir->nama_kurir,
                'logo_pengiriman' => $resi->kurir->logo_kurir,
                'jenis_logo_pengiriman' => $resi->kurir->tipe_logo_kurir,
                'pembayaran' => $resi->metode_pembayaran->nama_metode_pembayaran,
                'logo_pembayaran' => $resi->metode_pembayaran->logo_metode,
                'jenis_logo_pembayaran' => $resi->metode_pembayaran->logo_type,
                'invoiceId' => $resi->no_resi,
                'dp' => $resi->dp,
                'tagihan' => array(
                    'untuk' => $resi->customer->nama_depan . " " . $resi->customer->nama_belakang,
                    'alamat' => $resi->customer->alamat,
                    'kota_kab' => $resi->customer->kota_kabupaten,
                    'provinsi' => $resi->customer->provinsi,
                    'kode_pos' => $resi->customer->kode_pos,
                    'no_telp' => $resi->customer->no_telepon,
                ),
                'garansi' => array(
                    'durasi' => $resi->garansi,
                ),
                'inv' => array(
                    'row' => new InvoiceDoubleRowResource($resi),
                    'subtotal' => $resi->spareparts->pluck('harga')->sum(),
                    'additional' => new SubtotalRowResource($resi),
                    'total' => $resi->spareparts->pluck('harga')->sum() + $resi->subtotal_resis->pluck('nominal')->sum(),
                    'note' => $resi->notes
                ),
            ], 200);
        }
    }
}
