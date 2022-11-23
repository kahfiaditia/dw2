<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Inv_pinjaman;
use App\Models\Inventaris;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
            'list' => Inv_pinjaman::groupBy('kode_transaksi')->get(),

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

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Pinjaman Inventaris',
            'label' => 'Tambah Pinjaman',
            'inventaris' => Inventaris::where('ketersediaan', 'DAPAT DIPINJAM')->get(),

        ];
        return view('inv_pinjaman.add')->with($data);
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
        if (in_array('88', $session_menu)) {

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
                for ($i = 0; $i < count($request->datapinjam); $i++) {
                    $invpinjaman = new Inv_pinjaman;
                    $invpinjaman->kode_transaksi = $kode_transaksi;
                    $invpinjaman->status_transaksi = 'Proses';
                    $invpinjaman->nama_peminjam = $request->datapinjam[$i]['nama_peminjam'];
                    $invpinjaman->tgl_pemakaian = $request->datapinjam[$i]['tgl_pemakaian'];
                    $invpinjaman->tgl_permintaan = $request->datapinjam[$i]['tgl_permintaan'];
                    $invpinjaman->estimasi_kembali = $request->datapinjam[$i]['tgl_renc_pengembalian'];
                    $invpinjaman->id_barang = $request->datapinjam[$i]['nama_barang'];
                    $invpinjaman->deskripsi = $request->datapinjam[$i]['desc'];
                    $invpinjaman->jumlah = 1;
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('87', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => 'Data Pinjaman',
                'karyawan' => Employee::all(),
                'User' => User::all(),
                'data_pinjaman' => inv_pinjaman::where('kode_transaksi', $id_decrypted)->get(),

            ];
            return view('inv_pinjaman.show')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function approve($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('87', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => 'Penyerahan Pinjaman',
                'karyawan' => Employee::all(),
                'User' => User::all(),
                'kondisi' => Inventaris::all(),
                'data_pinjaman' => inv_pinjaman::where('kode_transaksi', $id_decrypted)->get(),

            ];
            return view('inv_pinjaman.approve')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function approveProses($id)
    {
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
