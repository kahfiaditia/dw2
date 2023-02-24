<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\BursaDetilPembelian;
use Illuminate\Http\Request;
use App\Models\BursaPembelian;
use App\Models\BursaProduk;
use App\Models\BursaSupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BursaPembelianController extends Controller
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
        if (in_array('139', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Pembelian',
                'label' => 'data Pembelian',
                'kategori' => BursaPembelian::all()
            ];
            return view('bursa.bursa_pembelian.list')->with($data);
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
        if (in_array('140', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Pembelian',
                'label' => 'data Pembelian',
                'supplier' => BursaSupplier::all(),
                'produk' => BursaProduk::all()
            ];
            return view('bursa.bursa_pembelian.tambah')->with($data);
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
        // dd($request->datapembelian);
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('144', $session_menu)) {

            // retrieve data from form input
            for ($i = 0; $i < count(array($request->datapembelian)); $i++) {
                $vendor_id = $request->datapembelian[$i]['supplier'];
                $purchase_date = date('Ymd');
            }


            DB::beginTransaction();
            try {

                $registration_number = BursaPembelian::pluck('kode_transaksi')->last();
                $no_date = Carbon::now()->format('ymd');
                if (!$registration_number) {
                    $no_stok = "PBDW" . $no_date . sprintf('%04d', 1);
                } else {
                    $last_number = (int)substr($registration_number, 9);
                    $moon = (int)substr($registration_number, 5, 2);
                    $moon_now = Carbon::now()->format('m');
                    if ($moon != $moon_now) {
                        $no_stok = "PBDW" . $no_date . sprintf('%04d', 1);
                    } else {
                        $no_stok = "PBDW" . $no_date . sprintf('%04d', $last_number + 1);
                    }
                }

                $pembelian = new BursaPembelian();
                $pembelian->kode_transaksi =  $no_stok;
                $pembelian->tgl_permintaan =  $request->datapembelian[$i]['tgl_permintaan'];
                $pembelian->tgl_kedatangan =  $request->datapembelian[$i]['tgl_kedatangan'];
                $pembelian->nomor_do =  $request->datapembelian[$i]['nomor_do'];
                $pembelian->id_supplier = $request->datapembelian[$i]['supplier'];
                $pembelian->ongkir = $request->datapembelian[$i]['ongkir'];
                $pembelian->potongan = $request->datapembelian[$i]['potongan'];
                $pembelian->total_nilai = $request->datapembelian[$i]['total_nilai'];
                $pembelian->status_pembayaran = $request->datapembelian[$i]['status_pembayaran'];
                $pembelian->jenis_pembayaran =  1;
                $pembelian->user_created = Auth::user()->id;
                $pembelian->save();

                for ($i = 0; $i < count($request->datapembelian); $i++) {
                    $detilpembelian = new BursaDetilPembelian();
                    $detilpembelian->id_pembelian =  $pembelian->id;
                    $detilpembelian->kadaluarsa =  $request->datapembelian[$i]['tgl_kadaluarsa'];
                    $detilpembelian->id_produk =  $request->datapembelian[$i]['produk'];
                    $detilpembelian->harga_total_produk =  $request->datapembelian[$i]['harga_total_produk'];
                    $detilpembelian->total_kuantiti = $request->datapembelian[$i]['total_kuantiti'];
                    $detilpembelian->nilai_per_pcs =  $request->datapembelian[$i]['harga_per_pcs'];
                    $detilpembelian->nilai_jual = $request->datapembelian[$i]['nilai_jual'];
                    $detilpembelian->user_created = Auth::user()->id;
                    $detilpembelian->save();

                    $produk = BursaProduk::findorfail($request->datapembelian[$i]['produk']);
                    BursaProduk::where('id', $request->datapembelian[$i]['produk'])->update([
                        'stok' => $produk->stok + $request->datapembelian[$i]['total_kuantiti'],
                        'harga_jual' => $request->datapembelian[$i]['nilai_jual'],
                        'harga_beli' => $request->datapembelian[$i]['harga_per_pcs'],
                        'user_updated' => Auth::user()->id
                    ]);

                    $total_produk = BursaDetilPembelian::where('id_pembelian', $pembelian->id)->count();
                    $pembelian_1 = BursaPembelian::where('id',  $pembelian->id)->update([
                        'total_produk' => $total_produk
                    ]);
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('139', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);

            $pembelian = BursaPembelian::where('id', array($id_decrypted))->get();
            $detilpembelian = BursaDetilPembelian::where('id_pembelian', $id_decrypted)->get();

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Pembelian',
                'label' => 'data Pembelian',
                'pembelian' => $pembelian,
                'detilpembelian' => $detilpembelian
            ];
            return view('bursa.bursa_pembelian.show')->with($data);
        } else {
            return view('not_found');
        }
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
        if (in_array('141', $session_menu)) {

            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Kategori',
                'label' => 'data Kategori',
                'kategori' => BursaPembelian::findORFail(
                    $id_decrypted
                )
            ];
            return view('bursa.bursa_pembelian.edit')->with($data);
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('141', $session_menu)) {
            $request->validate([
                'nama' => 'required',
                'status' => 'required',
            ]);

            $id = Crypt::decryptString($id);
            DB::beginTransaction();

            try {
                $kategori = BursaPembelian::findORfail($id);
                $kategori->nama = strtoupper($request['nama']);
                $kategori->status = strtoupper($request['status']);
                $kategori->user_updated = Auth::user()->id;
                $kategori->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/bursa_pembelian');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::addAlert(false);
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
        if (in_array('142', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $delete = BursaPembelian::findorfail($id_decrypted);
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
