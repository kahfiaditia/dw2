<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inv_pinjaman;
use App\Models\Inventaris;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvPinjamanController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'Inventaris';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Pinjaman Inventaris',
            'label' => 'data pinjaman',
            'list' => Inv_pinjaman::all()
        ];
        return view('inv_pinjaman.data')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventaris = Inventaris::where('ketersediaan', 'DAPAT DIPINJAM')->get();
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Pinjaman Inventaris',
            'label' => 'Tambah Pinjaman',

        ];
        return view('inv_pinjaman.add', compact('inventaris'))->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo json_encode('datapinjaman');

        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('80', $session_menu)) {

            $registration_number = Inv_pinjaman::limit(1)->groupBy('kode_transaksi')->orderBy('id', 'desc')->get();
            if (count($registration_number) > 0) {
                $thn = substr($registration_number[0]->kode_transaksi, 0, 2);
                if ($thn == Carbon::now()->format('y')) {
                    $date = $thn . Carbon::now()->format('md');
                    $nomor = (int) substr($registration_number[0]->kode_transaksi, 6, 4) + 1;

                    $Nol = "";
                    $nilai = 4 - strlen($nomor);
                    for ($i = 1; $i <= $nilai; $i++) {
                        $Nol = $Nol . "0";
                    }
                    $kode_transaksi   = $date . $Nol .  $nomor;
                } else {
                    $kode_transaksi   = Carbon::now()->format('ymd') . "0001";
                }
            } else {
                $kode_transaksi   = Carbon::now()->format('ymd') . "0001";
            }
            // echo ($kode_transaksi);

            DB::beginTransaction();
            try {

                for ($i = 0; $i < count($request->datapinjaman); $i++) {
                    $invpinjaman = new Inv_pinjaman;
                    $invpinjaman->kode_transaksi = $kode_transaksi;
                    $invpinjaman->status_transaksi = 'Proses';
                    $invpinjaman->id_karyawan = Auth::user()->id;
                    $invpinjaman->tgl_pemakaian = $request->datapinjaman[$i]['tgl_pemakaian'];
                    $invpinjaman->tgl_permintaan = $request->datapinjaman[$i]['tgl_permintaan'];
                    $invpinjaman->estimasi_kembali = $request->datapinjaman[$i]['tgl_renc_pengembalian'];
                    $invpinjaman->id_barang = $request->datapinjaman[$i]['nama_barang'];
                    $invpinjaman->qty = 1;
                    $invpinjaman->deskripsi = $request->datapinjaman[$i]['desc'];
                    $invpinjaman->user_created =  Auth::user()->id;
                    $invpinjaman->save();
                }



                DB::commit();
                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil Input Data',
                ]);
                // return redirect('inventaris');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
