<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('87', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Pinjaman Inventaris',
                'label' => 'data pinjaman',
                'list' => Inv_pinjaman::groupBy('kode_transaksi')->get(),

            ];
            return view('inv_pinjaman.data')->with($data);
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
        if (in_array('88', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Pinjaman Inventaris',
                'label' => 'Tambah Pinjaman',
                'inventaris' => Inventaris::where('ketersediaan', 'DAPAT DIPINJAM')->get(),
            ];
            return view('inv_pinjaman.add')->with($data);
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

            DB::beginTransaction();
            try {
                for ($i = 0; $i < count($request->datapinjam); $i++) {
                    $invpinjaman = new Inv_pinjaman;
                    $invpinjaman->kode_transaksi = $kode_transaksi;
                    $invpinjaman->status_transaksi = 'Proses';
                    $invpinjaman->nama_peminjam = $request->datapinjam[$i]['kode_peminjam'];
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
        if (in_array('91', $session_menu)) {

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

    public function edit_barang(Request $request)
    {

        $data = [
            'id' => $request->id,
            'item' => Inv_Pinjaman::findorfail(Crypt::decryptString($request->id)),
        ];

        return view('inv_pinjaman.approve_barang')->with($data);
    }

    public function approveProses(Request $request, $id)
    {

        $id = Crypt::decryptString($id);
        $request->validate([
            'tgl_diberikan' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $inv_pinjaman = Inv_pinjaman::findOrFail($id);
            $inv_pinjaman->tgl_diberikan = $request['tgl_diberikan'];
            $inv_pinjaman->diberikan_oleh = Auth::user()->id;
            $inv_pinjaman->status_Transaksi = 'Penyerahan';
            $inv_pinjaman->save();

            $update = Inventaris::findorfail($inv_pinjaman->id_barang);
            Inventaris::where('id', $update->id)->update(['ketersediaan' => 'TERPAKAI']);


            DB::commit();
            AlertHelper::updateAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            return back();
        }
    }

    public function update_inv(Request $request)
    {

        DB::beginTransaction();
        try {
            for ($i = 0; $i < count(array($request->data_post)); $i++) {

                $pinjaman = new Inv_pinjaman();

                $pinjaman->kode_transaksi = $request->kode_transaksi;
                $pinjaman->status_transaksi = 'Penyerahan';
                $pinjaman->nama_peminjam = $request->id_peminjam;
                $pinjaman->tgl_pemakaian = $request->tgl_pemakaian;
                $pinjaman->tgl_permintaan = $request->tgl_permintaan;
                $pinjaman->estimasi_kembali = $request->estimasi_kembali;
                $pinjaman->id_barang = $request->data_post[$i]['nama_barang'];
                $pinjaman->jumlah = 1;
                $pinjaman->user_created =  Auth::user()->id;
                $pinjaman->save();
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Peminjaman Buku',
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Peminjaman Inventaris',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) //dipakai
    {
        $id = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Pinjaman Inventaris',
            'label' => 'Edit Data Pinjaman',
            'inventaris' => Inventaris::all(),
            'data_pinjaman' => Inv_pinjaman::where('kode_transaksi', $id)->get(),
        ];
        return view('inv_pinjaman.edit')->with($data);
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
    }

    public function pengembalian($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('91', $session_menu)) {

            $id_decrypted = Crypt::decryptString($id);

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => 'Pengembalian Pinjaman',
                'karyawan' => Employee::all(),
                'User' => User::all(),
                'kondisi' => Inventaris::all(),
                'data_pinjaman' => inv_pinjaman::where('kode_transaksi', $id_decrypted)->get(),

            ];
            return view('inv_pinjaman.pengembalian')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function kembaliBarang(Request $request)
    {
        $data = [
            'id' => $request->id,
            'item' => Inv_Pinjaman::findorfail(Crypt::decryptString($request->id)),
        ];

        return view('inv_pinjaman.kembali_barang')->with($data);
    }

    public function kembaliProses(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $request->validate([
            'tgl_kembali' => 'required',
            'kondisi_barang' => 'required',
            'deskripsi_kembali' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $inv_pinjaman = Inv_pinjaman::findOrFail($id);
            $inv_pinjaman->tgl_kembali = $request['tgl_kembali'];
            $inv_pinjaman->barang_kembali = $request['kondisi_barang'];
            $inv_pinjaman->deskripsi = $request['kondisi_barang'];
            $inv_pinjaman->user_updated = Auth::user()->id;
            $inv_pinjaman->status_Transaksi = 'Selesai';
            $inv_pinjaman->save();

            $update = Inventaris::findorfail($inv_pinjaman->id_barang);
            Inventaris::where('id', $update->id)->update(['ketersediaan' => 'DAPAT DIPINJAM']);

            DB::commit();
            AlertHelper::updateAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_invid(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('90', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $pinjaman = inv_pinjaman::findorfail($id_decrypted);

                $pinjaman->user_deleted = Auth::user()->id;
                $pinjaman->deleted_at = Carbon::now();
                $pinjaman->save();

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
    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('90', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {

                $datetime = Carbon::now();
                Inv_pinjaman::where('kode_transaksi', $id_decrypted)->update(['user_deleted' => Auth::user()->id, 'deleted_at' => $datetime]);

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
