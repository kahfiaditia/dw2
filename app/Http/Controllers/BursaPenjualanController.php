<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\BursaDetilPenjualan;
use App\Models\BursaPenjualan;
use App\Models\BursaProduk;
use App\Models\Employee;
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
        // var_dump($request->datapenjualan);

        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('144', $session_menu)) {

            DB::beginTransaction();
            try {
                $registration_number = BursaPenjualan::limit(1)->groupBy('kode_penjualan')->orderBy('id', 'desc')->get();
                if (count($registration_number) > 0) {
                    $thn = substr($registration_number[0]->kode_penjualan, 0, 2);
                    if ($thn == Carbon::now()->format('y')) {
                        $date = $thn . Carbon::now()->format('md');
                        $nomor = (int) substr($registration_number[0]->kode_penjualan, 6, 4) + 1;

                        $Nol = "";
                        $nilai = 4 - strlen($nomor);
                        for ($i = 1; $i <= $nilai; $i++) {
                            $Nol = $Nol . "0";
                        }
                        $kode_penjualan   = $date . $Nol .  $nomor;
                    } else {
                        $kode_penjualan   = Carbon::now()->format('ymd') . "0001";
                    }
                } else {
                    $kode_penjualan   = Carbon::now()->format('ymd') . "0001";
                }


                $penjualan = new BursaPenjualan();
                $penjualan->kode_penjualan =  $kode_penjualan;
                $penjualan->status_pembayaran =  1;
                $penjualan->jenis_pembayaran =  $request->datapenjualan[0]['jenis_pembayaran'];
                $penjualan->id_siswa = $request->datapenjualan[0]['siswa'];
                $penjualan->keterangan =  $request->datapenjualan[0]['keterangan1'];
                $penjualan->user_created = Auth::user()->id;
                $penjualan->save();


                $produk_grouping = array();
                foreach ($request->datapenjualan as $item) {
                    $idProduk = $item['produk'];
                    $qty = $item['qty'];
                    $total = $item['total'];
                    $margin = $item['margin'];
                    $total_modal = $item['total_modal'];

                    if (!isset($produk_grouping[$idProduk])) {
                        $produk_grouping[$idProduk] = array(
                            'produk' => $idProduk,
                            'qty' => $qty,
                            'total' => $total,
                            'margin' => $margin,
                            'total_modal' => $total_modal
                        );
                    } else {
                        $produk_grouping[$idProduk]['qty'] += $qty;
                        $produk_grouping[$idProduk]['total'] += $total;
                        $produk_grouping[$idProduk]['margin'] += $margin;
                        $produk_grouping[$idProduk]['total_modal'] += $total_modal;
                    }
                }

                // Simpan hasil penjualan yang sudah dikelompokkan
                foreach ($produk_grouping as $item) {
                    $detilpenjualan = new BursaDetilPenjualan();
                    $detilpenjualan->id_penjualan = $penjualan->id;
                    $detilpenjualan->id_produk = $item['produk'];
                    $detilpenjualan->kuantiti = $item['qty'];
                    $detilpenjualan->harga_jual = $request->datapenjualan[0]['nilai_jual'];
                    $detilpenjualan->sub_total = $item['total'];
                    $detilpenjualan->harga_modal = $request->datapenjualan[0]['modal'];
                    $detilpenjualan->sub_modal = $item['total_modal'];
                    $detilpenjualan->sub_margin = $item['margin'];
                    $detilpenjualan->user_created = Auth::user()->id;
                    $detilpenjualan->save();

                    $produk = BursaProduk::findorfail($item['produk']);
                    BursaProduk::where('id', $item['produk'])->update([
                        'stok' => $produk->stok - $item['qty'],
                        'user_updated' => Auth::user()->id
                    ]);

                    $data = BursaDetilPenjualan::select('id_produk')
                        ->where('id_penjualan', $penjualan->id)
                        ->groupBy('id_produk')
                        ->get();
                    $jumlah_total = $data->count();
                    $update_total_produk = BursaPenjualan::where('id',  $penjualan->id)->update(['total_produk' => $jumlah_total]);

                    $penjualan_update = BursaPenjualan::findOrFail($penjualan->id);
                    $penjualan_update->total = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('sub_total');
                    $penjualan_update->total_margin = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('sub_margin');
                    $penjualan_update->total_modal = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('sub_modal');
                    $penjualan_update->total_kuantiti = BursaDetilPenjualan::where('id_penjualan', $penjualan->id)->sum('kuantiti');
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
        $harga_beli = null;
        $harga_jual = null;
        if ($request->pembeli == 'Siswa') {
            $data = Siswa::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->class_id;
                $type = $request->pembeli;
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($request->pembeli == 'Guru' or $request->pembeli == 'Karyawan') {
            $data = Employee::where('niks', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = null;
                $type = $request->pembeli;
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($request->pembeli == '') {
            $data = BursaProduk::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->nama;
                $harga_beli = $data->harga_beli;
                $harga_jual = $data->harga_jual;
                $type = 'produk';
                $code = 200;
                $val = $val + 1;
            }
        } else if ($request->pembeli != '' and $val == 0) {
            $data = BursaProduk::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->nama;
                $harga_beli = $data->harga_beli;
                $harga_jual = $data->harga_jual;
                $type = 'produk';
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($val == 0) {
            $id = null;
            $class_id = null;
            $harga_beli = null;
            $harga_jual = null;
            $type = null;
            $code = 400;
        }
        return response()->json([
            'code' => $code,
            'id' => $id,
            'jenjang' => $class_id,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'type' => $type,
            'val' => $val,
        ]);
    }

    public function get_siswa(Request $request)
    {
        $siswa = DB::table('siswa')
            ->select('siswa.id', 'siswa.nama_lengkap')
            ->join('classes', 'classes.id', '=', 'siswa.class_id')
            ->where('classes.id', '=', $request->class_jenjang)
            ->whereNull('siswa.deleted_at')
            ->get();
        if (count($siswa) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $siswa,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }
}
