<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\ObatModel;
use App\Models\Perawatan;
use App\Models\PerawatanModel;
use App\Models\Siswa;
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
    public function __construct()
    {
        $this->PerawatanModel = new PerawatanModel();
    }

    public function index()
    {
        $data = [

            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data perawatan',
            'perawatan' => PerawatanModel::groupBy('kode_perawatan')->orderBy('kode_perawatan', 'desc')->get(),
        ];
        return view('uks/perawatan.index')->with($data);
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
            'submenu' => $this->submenu,
            'label' => 'Tambah Perawatan',
            'obat' => ObatModel::all(),
            'siswa' => Siswa::all(),
            'stok_obat' => StokObatModel::all(),

        ];
        return view('uks/perawatan.add')->with($data);
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
                    $uksperawatan->id_siswa = $request->dataperawatan[$i]['siswa'];
                    $uksperawatan->tgl = $request->dataperawatan[$i]['tgl'];
                    $uksperawatan->masuk = $request->dataperawatan[$i]['jam_masuk'];
                    $uksperawatan->gejala = $request->dataperawatan[$i]['gejala'];
                    $uksperawatan->deksripsi = $request->dataperawatan[$i]['desc'];
                    $uksperawatan->id_obat = $request->dataperawatan[$i]['obat'];
                    $uksperawatan->id_stok_obat = $request->dataperawatan[$i]['exp'];
                    $uksperawatan->qty = $request->dataperawatan[$i]['qty'];
                    $uksperawatan->user_created =  Auth::user()->id;
                    $uksperawatan->save();
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
     * @param  \App\Models\PerawatanModel  $perawatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $obat_expired = PerawatanModel::with('obat', 'jenis_obat', 'stok_obat')->findOrFail($id);

        $id_decrypted = $id;
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data perawatan',
            'obat_expired' => StokObatModel::where('id_obat', $id)->get(),
            'perawatan' => PerawatanModel::where('kode_perawatan', $id_decrypted)->get(),
            // 'obat' => $this->PerawatanModel->data_obat::where('kode_perawatan', $id_decrypted)->get(),
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
        $id_decrypted = $id;
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'Edit Perawatan',
            'stok_obat' => StokObatModel::all(),
            'perawatan' => PerawatanModel::where('kode_perawatan', $id_decrypted)->get(),
        ];
        return view('uks.perawatan.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PerawatanModel  $perawatan
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
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
            $id_decrypted = $id;
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
            $id_decrypted = $id;
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
                $perawatan->deksripsi = $request->desc;
                $perawatan->id_obat = $request->obat;
                $perawatan->id_stok_obat = $request->exp;
                $perawatan->user_updated =  Auth::user()->id;
                $perawatan->save();
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

    public function kembali_keluar(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('100', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Keluar Perawatan',
                'perawatan' => PerawatanModel::where('kode_perawatan', $id)->get(),

                // 'data' => PerawatanModel::   (`kode_perawatan`,`id_stok_obat`, `id_obat`, SUM(`qty`) AS total FROM (`uks_perawatan` GROUP BY `kode_perawatan`, `id_obat`,`id_stok_obat`)

            ];
            return view('uks/perawatan.keluar')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function uksProses(Request $request, $id)
    {
        // echo $request['keluar'];
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->data_keluar); $i++) {
                $cek_qty = ObatModel::findorfail('id', $request['id_obat']);
                if ($request['stok'] > $cek_qty->qty) {
                    return response()->json([
                        'code' => 404,
                        'message' => 'Stock Obat <strong> </strong> hanya <strong>' . $cek_qty->qty . '</strong>',
                    ]);
                }
            }

            for ($i = 0; $i < count(array($request->data_keluar)); $i++) {

                PerawatanModel::where('kode_perawatan', $id)->update([
                    'user_updated' => Auth::user()->id,
                    'keluar' => $request['keluar'],
                ]);


                // $stock = Buku::findorfail($request->data_post[$i]['buku_id']);
                // Buku::where('id', $request->data_post[$i]['buku_id'])->update(['jml_buku' => $stock->jml_buku - $request->data_post[$i]['jml_buku']]);
                // $stock = ObatModel::findorfail($request->data_post[$i]['buku_id']);
                // ObatModel::where('id', $request->data_post[$i]['buku_id'])->update(['jml_buku' => $stock->jml_buku - $request->data_post[$i]['jml_buku']]);

                $stock = ObatModel::findorfail($request->id_obat);
                // echo $tock;
                ObatModel::where('id', $request->id_obat)->update(['stok' => $stock->qty - $request->stok]);
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Input Data Keluar UKS',
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Input Keluar UKS',
            ]);
        }
    }

    public function get_obat(Request $request)
    {

        $obat = DB::table('uks_obat')
            ->select('uks_obat.id', 'uks_stok_obat.id_obat', 'obat')
            ->leftjoin('uks_stok_obat', 'uks_stok_obat.id', '=', 'uks_obat.id')
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
            ->select('uks_stok_obat.id', 'uks_stok_obat.tgl_ed')
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
