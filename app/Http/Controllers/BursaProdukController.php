<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\BursaKategori;
use Illuminate\Http\Request;
use App\Models\BursaProduk;
use App\Models\BursaSatuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BursaProdukController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'Bursa';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Produk',
            'label' => 'data Produk',
            'produk' => BursaProduk::all()
        ];
        return view('bursa.bursa_produk.data')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan = BursaSatuan::all();
        $kategori = BursaKategori::all();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Produk',
            'label' => 'tambah Produk',
            'satuan' => $satuan,
            'kategori' => $kategori
        ];
        return view('bursa.bursa_produk.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('59', $session_menu)) {

            DB::beginTransaction();
            try {

                for ($i = 0; $i < count($request->databarang); $i++) {
                    $produk = new BursaProduk();

                    $produk->nama =  $request->databarang[$i]['hasilnama'];
                    $produk->id_satuan = $request->databarang[$i]['hasilsatuan'];
                    $produk->id_kategori =  $request->databarang[$i]['hasilkategori'];
                    $produk->barcode =  $request->databarang[$i]['hasilbarcode'];
                    $produk->deskripsi =  $request->databarang[$i]['hasildesc'];
                    $produk->stok_minimal =  $request->databarang[$i]['hasilstok_minimal'];
                    $produk->stok =  0;
                    $produk->harga_beli =  0;
                    $produk->harga_jual = 0;
                    $produk->status =  1;
                    $produk->user_created = Auth::user()->id;
                    $produk->save();
                }

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil Input Data',
                ]);
            } catch (\Throwable $err) {
                DB::rollBack();
                throw $err;
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal Input Data',
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Sorry, page not found',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Produk',
            'label' => 'ubah Produk',
            'produk' => BursaProduk::findORFail($id_decrypted)
        ];
        return view('bursa.bursa_produk.ubah')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('60', $session_menu)) {
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'nama_kontak' => 'required',
                'tlp' => 'required',
                'status' => 'required',
            ]);

            $id = Crypt::decryptString($id);

            DB::beginTransaction();
            try {
                BursaProduk::where('id', $id)
                    ->update([
                        'nama' => strtoupper($request['nama']),
                        'alamat' => strtoupper($request['alamat']),
                        'nama_kontak' => strtoupper($request['nama_kontak']),
                        'tlp' => $request->tlp,
                        'status' => $request->status,
                        'user_updated' => Auth::user()->id,
                    ]);

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/supplier');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::updateAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('51', $session_menu)) {
            DB::beginTransaction();
            try {
                $delete = BursaProduk::findOrFail(Crypt::decryptString($id));
                $delete->user_deleted = Auth::user()->id;
                $delete->deleted_at = Carbon::now();
                $delete->save();

                DB::commit();
                AlertHelper::deleteAlert(true);
                return back();
            } catch (\Throwable $err) {
                DB::rollBack();
                AlertHelper::deleteAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }
}
