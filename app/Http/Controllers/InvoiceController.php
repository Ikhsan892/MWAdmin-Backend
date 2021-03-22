<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Customer;
use App\Http\Resources\InvoiceDoubleRowResource;
use App\Http\Resources\SubtotalRowResource;
use App\Kerusakan;
use App\Kurir;
use App\MetodePembayaran;
use App\Resi;
use App\Sparepart;
use App\StatusPembayaran;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public $invoice_id;
    public $barang_id;
    public $kerusakan_id;
    public function index(Request $request)
    {
        $resi_from_search = Resi::where('no_resi', $request->get('no_resi'))->get('id');
        if ($resi_from_search->count() < 1) {
            return response()->json([
                'message' => 'Data Not Found'
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

    public function insertInvoice(Request $request)
    {
        $search_resi = Resi::where('no_resi', $request->get('no_invoice'))->get('id');
        $id_cust = 0;
        if ($search_resi->count() < 1) {
            $cust = new Customer();
            $find_customer = $cust->where('email', $request->email)->first();
            if ($find_customer) {
                $id_cust = $find_customer->id;
            } else {
                $cust->nama_depan = $request->nama_depan;
                $cust->nama_belakang = $request->nama_belakang;
                $cust->email = $request->email;
                $cust->umur = $request->umur;
                $cust->no_telepon = $request->no_telepon;
                $cust->negara = $request->negara;
                $cust->kota_kabupaten = $request->kota_kabupaten;
                $cust->provinsi = $request->provinsi;
                $cust->kecamatan = $request->kecamatan;
                $cust->kode_pos = '1111';
                $cust->alamat = $request->alamat;

                // Save
                $cust->save();
                $id_cust = $cust->where('nama_depan', $request->nama_depan)->first()->id;
            }
            $status_pembayaran = StatusPembayaran::where('nama_status_pembayaran', $request->status_pembayaran)->first();
            $metode_pembayaran = MetodePembayaran::where('nama_metode_pembayaran', $request->metode_pembayaran)->first();
            $kurir = Kurir::where('nama_kurir', $request->pengiriman)->first();

            // Inserting Data
            $resi = new Resi();
            $resi->customer_id = $id_cust;
            $resi->status_pembayaran_id = $status_pembayaran->id;
            $resi->metode_pembayaran_id = $metode_pembayaran->id;
            $resi->pengiriman_id = $kurir->id;
            $resi->status_kerjaan_id = 0;
            $resi->no_resi = $request->no_invoice;
            $resi->garansi = $request->garansi;
            $resi->notes = $request->note;
            $resi->dp = $request->dp ? $request->dp : 0;
            $resi->save();

            // Filling
            $this->invoice_id = $request->no_invoice;
            $collect = collect($request->barang);
            $collect->map(function ($item, $key) {
                $barang = new Barang();
                $search = Resi::where('no_resi', $this->invoice_id)->get();
                $barang->kategori_barang = "elektronik";
                $barang->resi_id = $search[0]->id;
                $barang->nama_barang = $item['nama_barang'];
                $barang->save();
                $this->barang_id = $item['nama_barang'];
                $kerusakan_ = collect($item['kerusakan']);
                $kerusakan_->map(function ($i, $k) {
                    $kerusakan = new Kerusakan();
                    $kerusakan->nama_kerusakan = $i['nama_kerusakan'];
                    $this->kerusakan_id = $i['nama_kerusakan'];
                    $search = Barang::where('nama_barang', $this->barang_id)->get();
                    $kerusakan->barang_id = $search[0]->id;
                    $kerusakan->save();
                    $sparepart_ = collect($i['sparepart']);
                    $sparepart_->map(function ($j, $u) {
                        $sparepart = new Sparepart();
                        $sparepart->nama_sparepart = $j['nama_sparepart'];
                        $sparepart->harga = $j['harga'];
                        $search = Kerusakan::where('nama_kerusakan', $this->kerusakan_id)->get();
                        $sparepart->kerusakan_id = $search[0]->id;
                        $sparepart->save();
                    });
                });
            });

            $message = array('message' => 'Resi has been created');
            return response()->json($message, 201);
        } else {
            $message = array('message' => 'Data Duplicate');
            return response()->json($message, 203);
        }
    }
}
