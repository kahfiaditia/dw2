<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\BursaDetilPenjualan;
use App\Models\BursaPenjualan;
use App\Models\BursaProduk;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BursaPenjualanController extends Controller
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
                'submenu' => 'Penjualan',
                'label' => 'data Penjualan',
                'penjualan' => BursaPenjualan::all(),
                'produk' => BursaProduk::all(),
                'siswa' => Siswa::all()
            ];
            return view('bursa.bursa_penjualan.pos')->with($data);
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
        if (in_array('139', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Penjualan',
                'label' => 'data Penjualan',
                'penjualan' => BursaPenjualan::all(),
                'produk' => BursaProduk::all(),
                'siswa' => Siswa::all()
            ];
            return view('bursa.bursa_penjualan.pos1')->with($data);
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

                $registration_number = BursaPenjualan::pluck('kode_penjualan')->last();
                $no_date = Carbon::now()->format('ymd');
                if (!$registration_number) {
                    $no_stok = "INV/PJ/" . $no_date . sprintf('%04d', 1);
                } else {
                    $last_number = (int)substr($registration_number, 9);
                    $moon = (int)substr($registration_number, 5, 2);
                    $moon_now = Carbon::now()->format('m');
                    if ($moon != $moon_now) {
                        $no_stok = "INV/PJ/" . $no_date . sprintf('%04d', 1);
                    } else {
                        $no_stok = "INV/PJ/" . $no_date . sprintf('%04d', $last_number + 1);
                    }
                }

                $penjualan = new BursaPenjualan();
                $penjualan->kode_penjualan =  $no_stok;
                $penjualan->status_pembayaran =  1;
                $penjualan->jenis_pembayaran =  $request->payment1;
                $penjualan->id_siswa = $request->siswa;
                $penjualan->user_created = Auth::user()->id;
                $penjualan->save();

                for ($i = 0; $i < count($request->datapenjualan); $i++) {
                    $detilpenjualan = new BursaDetilPenjualan();
                    $detilpenjualan->id_penjualan =  $penjualan->id;
                    $detilpenjualan->id_produk =  $request->datapenjualan[$i]['produk'];
                    $detilpenjualan->kuantiti =  $request->datapenjualan[$i]['qty'];
                    $detilpenjualan->harga_jual = $request->datapenjualan[$i]['nilai_jual'];
                    $detilpenjualan->sub_total =  $request->datapenjualan[$i]['total'];
                    $detilpenjualan->harga_modal = $request->datapenjualan[$i]['modal'];
                    $detilpenjualan->sub_modal = $request->datapenjualan[$i]['total_modal'];
                    // $detilpenjualan->margin_produk = $request->datapenjualan[$i]['nilai_jual'];
                    $detilpenjualan->sub_margin = $request->datapenjualan[$i]['margin'];
                    $detilpenjualan->user_created = Auth::user()->id;
                    $detilpenjualan->save();

                    $produk = BursaProduk::findorfail($request->datapenjualan[$i]['produk']);
                    BursaProduk::where('id', $request->datapenjualan[$i]['produk'])->update([
                        'stok' => $produk->stok - $request->datapenjualan[$i]['qty'],
                        'user_updated' => Auth::user()->id
                    ]);

                    $total_produk = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->count();
                    $penjualan_1 = BursaPenjualan::where('id',  $penjualan->id)->update([
                        'total_produk' => $total_produk
                    ]);

                    $penjualan_update = BursaPenjualan::findOrFail($penjualan->id);
                    $penjualan_update->total = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('sub_total');
                    $penjualan_update->total_margin = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('sub_margin');
                    $penjualan_update->total_modal = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('sub_modal');
                    $penjualan_update->save();
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

            $pembelian = BursaPenjualan::where('id', array($id_decrypted))->get();
            $detilpenjualan = BursaDetilPenjualan::where('id_pembelian', $id_decrypted)->get();

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Penjualan',
                'label' => 'data Penjualan',
                'pembelian' => $pembelian,
                'detilpenjualan' => $detilpenjualan
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
                'kategori' => BursaPenjualan::findORFail(
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
                $kategori = BursaPenjualan::findORfail($id);
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
                $delete = BursaPenjualan::findorfail($id_decrypted);
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

    public function get_produk(Request $request)
    {
        $produk = DB::table('bursa_produks')
            ->select('bursa_produks.*')
            ->where('stok', '>', 0)
            ->whereNull('bursa_produks.deleted_at')
            ->get();

        if (count($produk) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $produk,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function get_kadaluarsa(Request $request)
    {
        $kadalauarsa = DB::table('bursa_detil_pembelian')
            ->select('bursa_detil_pembelian.*')
            ->join('bursa_produks', 'bursa_produks.id', '=', 'bursa_detil_pembelian.id_produk')
            ->where('bursa_produks.id', '=', $request->class_produk)
            ->whereNull('bursa_detil_pembelian.deleted_at')
            ->get();
        if (count($kadalauarsa) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $kadalauarsa,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function get_stok(Request $request)
    {
        $kadalauarsa = DB::table('bursa_detil_pembelian')
            ->select('bursa_detil_pembelian.*')
            ->join('bursa_produks', 'bursa_produks.id', '=', 'bursa_detil_pembelian.id_produk')
            ->where('bursa_produks.id', '=', $request->class_produk)
            ->whereNull('bursa_detil_pembelian.deleted_at')
            ->get();
        if (count($kadalauarsa) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $kadalauarsa,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function scanBarcode(Request $request)
    {
        $val = 0;
        if ($request->peminjam == 'Siswa') {
            $data = Siswa::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->class_id;
                $type = $request->peminjam;
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($request->peminjam == '') {
            $data = BursaPenjualan::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->kategori->kode_kategori . '-' . $data->judul;
                $type = 'buku';
                $code = 200;
                $val = $val + 1;
            }
        } elseif ($request->peminjam != '' and $val == 0) {
            $data = BursaPenjualan::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->kategori->kode_kategori . '-' . $data->judul;
                $type = 'buku';
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($val == 0) {
            $id = null;
            $class_id = null;
            $type = null;
            $code = 400;
        }
        return response()->json([
            'code' => $code,
            'id' => $id,
            'jenjang' => $class_id,
            'type' => $type,
            'val' => $val,
        ]);
    }
}
