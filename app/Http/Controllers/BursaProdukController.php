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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('143', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Produk',
                'label' => 'data Produk',
                'produk' => BursaProduk::all()
            ];
            return view('bursa.bursa_produk.data')->with($data);
        } else {
            return view('not_found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('144', $session_menu)) {

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
        } else {
            return view('not_found');
        }
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
        if (in_array('144', $session_menu)) {

            DB::beginTransaction();
            try {

                for ($i = 0; $i < count($request->databarang); $i++) {
                    $produk = new BursaProduk();

                    $produk->nama =  $request->databarang[$i]['hasilnama'];
                    $produk->barcode =  $request->databarang[$i]['hasilbarcode'];
                    $produk->deskripsi =  $request->databarang[$i]['hasildesc'];
                    $produk->id_satuan = $request->databarang[$i]['satuan'];
                    $produk->id_kategori =  $request->databarang[$i]['kategori'];
                    $produk->stok_minimal =  10;
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('145', $session_menu)) {

            $id_decrypted = Crypt::decryptString($id);
            $kategori = BursaKategori::all();
            $satuan = BursaSatuan::all();
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Produk',
                'label' => 'ubah Produk',
                'satuan' => $satuan,
                'kategori' => $kategori,
                'produk' => BursaProduk::findORFail($id_decrypted)
            ];
            return view('bursa.bursa_produk.edit')->with($data);
        } else {
            return view('not_found');
        }
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

        // echo $request->nama;
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('145', $session_menu)) {
            $request->validate([
                'nama' => 'required',
                'id_kategori' => 'required',
                'id_satuan' => 'required',
                // 'harga_beli' => 'required|numeric',
                // 'harga_jual' => 'required|numeric|gt:harga_beli',
            ]);

            $id = Crypt::decryptString($id);

            DB::beginTransaction();
            try {
                BursaProduk::where('id', $id)
                    ->update([
                        'nama' => strtoupper($request['nama']),
                        'id_satuan' => $request['id_satuan'],
                        'id_kategori' => $request['id_kategori'],
                        'barcode' => $request['barcode'],
                        'deskripsi' => strtoupper($request['desc']),
                        'stok_minimal' => $request['stok_minimal'],
                        'stok' => $request['stok'],
                        'harga_beli' => $request['harga_beli'],
                        'harga_jual' => $request['harga_jual'],
                        'status' => $request['status1'],
                        'kadaluarsa' => Carbon::now(),
                        'user_updated' => Auth::user()->id,
                    ]);

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/bursa_produk');
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
        if (in_array('146', $session_menu)) {
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
