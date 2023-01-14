<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\ObatModel;
use App\Models\PerawatanModel;
use App\Models\StokObatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PerawatanController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = 'perawatan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('100', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data perawatan',
                'perawatan' => PerawatanModel::groupBy('kode_perawatan')->orderBy('kode_perawatan', 'desc')->get(),
            ];
            return view('uks/perawatan.index')->with($data);
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
        if (in_array('101', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Tambah Perawatan',
            ];
            return view('uks/perawatan.add')->with($data);
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
        if (in_array('101', $session_menu)) {
            $registration_number = PerawatanModel::limit(1)->groupBy('kode_perawatan')->orderBy('id', 'desc')->get();
            if (count($registration_number) > 0) {
                $thn = substr($registration_number[0]->kode_perawatan, 0, 2);
                if ($thn == Carbon::now()->format('y')) {
                    $date = $thn . Carbon::now()->format('md');
                    $nomor = (int) substr($registration_number[0]->kode_perawatan, 6, 4) + 1;

                    $Nol = "";
                    $nilai = 4 - strlen($nomor);
                    for ($i = 1; $i <= $nilai; $i++) {
                        $Nol = $Nol . "0";
                    }
                    $kode_perawatan   = $date . $Nol .  $nomor;
                } else {
                    $kode_perawatan   = Carbon::now()->format('ymd') . "0001";
                }
            } else {
                $kode_perawatan   = Carbon::now()->format('ymd') . "0001";
            }

            DB::beginTransaction();
            try {
                for ($i = 0; $i < count($request->dataperawatan); $i++) {
                    $uksperawatan = new PerawatanModel();
                    $uksperawatan->kode_perawatan = $kode_perawatan;
                    $uksperawatan->id_siswa = $request->dataperawatan[$i]['id_siswa'];
                    $uksperawatan->tgl = $request->dataperawatan[$i]['tgl'];
                    $uksperawatan->masuk = $request->dataperawatan[$i]['jam_masuk'];
                    $uksperawatan->gejala = $request->dataperawatan[$i]['gejala'];
                    $uksperawatan->deskripsi = $request->dataperawatan[$i]['desc'];
                    $uksperawatan->id_obat = $request->dataperawatan[$i]['id_obat'];
                    $uksperawatan->id_stok_obat = $request->dataperawatan[$i]['id_stok_obat'];
                    $uksperawatan->qty = $request->dataperawatan[$i]['qty'];
                    $uksperawatan->user_created =  Auth::user()->id;
                    $uksperawatan->save();
                }

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil disimpan',
                ]);
            } catch (\Throwable $err) {
                DB::rollBack();
                throw $err;
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal disimpan',
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
     * @param  \App\Models\PerawatanModel  $perawatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data perawatan',
            'perawatan' => PerawatanModel::where('kode_perawatan', $id_decrypted)->get(),
        ];
        return view('uks/perawatan.detil')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerawatanModel  $perawatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('102', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Edit Perawatan',
                'stok_obat' => StokObatModel::all(),
                'perawatan' => PerawatanModel::where('kode_perawatan', $id_decrypted)->get(),
            ];
            return view('uks.perawatan.edit')->with($data);
        } else {
            return view('not_found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PerawatanModel  $perawatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            PerawatanModel::where('kode_perawatan', $request->kode_perawatan)->update([
                'gejala' => $request->gejala, 'deskripsi' => $request->desc, 'tgl' => $request->tgl, 'masuk' => $request->jam_masuk, 'user_updated' => Auth::user()->id
            ]);

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil disimpan',
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerawatanModel  $perawatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('103', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $datetime = Carbon::now();
                PerawatanModel::where('kode_perawatan', $id_decrypted)->update(['user_deleted' => Auth::user()->id, 'deleted_at' => $datetime]);

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

    public function destroy_obat(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('103', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $hapus_edit_obat = PerawatanModel::findorfail($id_decrypted);
                $hapus_edit_obat->user_deleted = Auth::user()->id;
                $hapus_edit_obat->deleted_at = Carbon::now();
                $hapus_edit_obat->save();

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

    public function update_obat(Request $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count(array($request->data_post)); $i++) {
                $perawatan = new PerawatanModel();
                $perawatan->kode_perawatan = $request->kode_perawatan;
                $perawatan->id_siswa = $request->id_siswa;
                $perawatan->tgl = $request->tgl;
                $perawatan->gejala = $request->gejala;
                $perawatan->masuk = $request->jam_masuk;
                $perawatan->qty = $request->qty;
                $perawatan->deskripsi = $request->desc;
                $perawatan->id_obat = $request->obat;
                $perawatan->id_stok_obat = $request->exp;
                $perawatan->user_updated =  Auth::user()->id;
                $perawatan->save();
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil disimpan',
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal disimpan',
            ]);
        }
    }

    public function kembali_keluar(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('102', $session_menu)) {
            $id = Crypt::decryptString($id);
            $obat_keluar = DB::table('uks_perawatan')
                ->select('obat', 'qty', 'uks_stok_obat.id', 'tgl_ed', DB::raw('SUM(qty) AS total'))
                ->join('uks_stok_obat', 'uks_stok_obat.id', '=', 'uks_perawatan.id_stok_obat')
                ->join('uks_obat', 'uks_obat.id', '=', 'uks_stok_obat.id_obat')
                ->where('kode_perawatan', '=', $id)
                ->groupBy('id_stok_obat')->get();

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Keluar Perawatan',
                'perawatan' => PerawatanModel::where('kode_perawatan', $id)->get(),
                'obat_keluar' => $obat_keluar,
            ];
            return view('uks/perawatan.keluar')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function uksProses(Request $request, $kode_perawatan)
    {
        DB::beginTransaction();
        try {
            $push = DB::table('uks_perawatan')
                ->select('uks_obat.id', 'obat', 'jml_keluar', 'stok', 'qty', 'uks_stok_obat.id as id_stok', 'tgl_ed', DB::raw('SUM(qty) AS total'))
                ->join('uks_stok_obat', 'uks_stok_obat.id', '=', 'uks_perawatan.id_stok_obat')
                ->join('uks_obat', 'uks_obat.id', '=', 'uks_stok_obat.id_obat')
                ->where('kode_perawatan', '=', $kode_perawatan)
                ->whereNull('uks_perawatan.deleted_at')
                ->groupBy('id_stok_obat')
                ->get();

            foreach ($push as $value) {
                if ($value->stok - $value->total < 0) {
                    AlertHelper::alertDinamis(false, 'Stok ' . $value->obat . ' kurang!');
                    return back();
                } else {
                    $jml_keluar = StokObatModel::findorfail($value->id_stok);
                    StokObatModel::where('id', $value->id)->update(['jml_keluar' => $value->jml_keluar + $value->total]);

                    $kurangin = ObatModel::findorfail($value->id);
                    ObatModel::where('id', $value->id)->update(['stok' => $value->stok - $value->total]);
                }
            }

            PerawatanModel::where('kode_perawatan', $kode_perawatan)->update([
                'user_updated' => Auth::user()->id,
                'keluar' => $request['keluar'],
            ]);

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('uks/perawatan');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function get_obat(Request $request)
    {
        $obat = DB::table('uks_obat')
            ->select('uks_obat.id', 'stok', 'obat')
            ->where('stok', '>', 0)
            ->whereNull('uks_obat.deleted_at')
            ->get();

        if (count($obat) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $obat,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function get_exp(Request $request)
    {
        $tgl_ed = DB::table('uks_stok_obat')
            ->select('uks_stok_obat.id', 'uks_stok_obat.tgl_ed', 'uks_stok_obat.jml')
            ->join('uks_obat', 'uks_obat.id', '=', 'uks_stok_obat.id_obat')
            ->where('uks_obat.id', '=', $request->class_obat)
            ->whereNull('uks_stok_obat.deleted_at')
            ->get();
        if (count($tgl_ed) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $tgl_ed,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }
}
