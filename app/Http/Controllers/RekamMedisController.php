<?php

namespace App\Http\Controllers;

use App\Exports\RekamMedisExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RekamMedisController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = ' medis';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('115', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'rekam ' . $this->submenu,
                'label' => 'rekam ' . $this->submenu,
            ];
            return view('uks.rekam_medis.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function rekam_medis_list(Request $request)
    {
        // querynya
        $list = DB::table('uks_perawatan')
            ->select(
                'uks_perawatan.kode_perawatan',
                'uks_perawatan.tgl',
                'uks_perawatan.gejala',
                'uks_perawatan.masuk',
                'uks_perawatan.keluar',
                'siswa.nama_lengkap',
                'kategori',
                'uks_obat.obat',
                'jenis_obat',
                'uks_perawatan.qty',
            )
            ->Join('siswa', 'siswa.id', 'uks_perawatan.id_siswa')
            ->Join('uks_obat', 'uks_obat.id', 'uks_perawatan.id_obat')
            ->Join('uks_jenis_obat', 'uks_jenis_obat.id', 'uks_obat.id_jenis_obat')
            ->Join('uks_kategori', 'uks_kategori.id', 'uks_obat.id_kategori')
            ->whereNull('uks_perawatan.deleted_at')
            ->orderBy('kode_perawatan');

        if ($request->get('search_manual') != null) {
            $search = $request->get('search_manual');
            $replaced = str_replace(' ', '', $search);
            $list->where(function ($where) use ($search, $replaced) {
                $where
                    ->orWhere('uks_perawatan.kode_perawatan', 'like', '%' . $search . '%')
                    ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('gejala', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('obat', 'like', '%' . $search . '%')
                    ->orWhere('qty', 'like', '%' . $search . '%')
                    ->orWhere('uks_perawatan.tgl', 'like', '%' . $search . '%');
            });
        } else {
            if ($request->get('kode') != null) {
                $kode = $request->get('kode');
                $list->where('uks_perawatan.kode_perawatan', '=', $kode);
            }
            if ($request->get('siswa') != null) {
                $siswa = $request->get('siswa');
                $list->where('siswa.nama_lengkap', 'LIKE', '%' . $siswa . '%');
            }
            if ($request->get('gejala') != null) {
                $gejala = $request->get('gejala');
                $list->where('uks_perawatan.gejala', 'LIKE', '%' . $gejala . '%');
            }
            if ($request->get('kategori') != null) {
                $kategori = $request->get('kategori');
                $list->where('kategori', '=', $kategori);
            }
            if ($request->get('obat') != null) {
                $obat = $request->get('obat');
                $list->where('uks_obat.obat', '=', $obat);
            }
            if ($request->get('qty') != null) {
                $qty = $request->get('qty');
                $list->where('uks_perawatan.qty', '=', $qty);
            }
            if ($request->get('tgl_end') != null) {
                $start = $request->get('tgl_start');
                $end = $request->get('tgl_end');
                $list->whereBetween('uks_perawatan.tgl', [$start, $end]);
            }
        }

        return DataTables::of($list)
            ->addColumn('obat', function ($list) {
                return $list->obat . ' - ' . $list->jenis_obat;
            })
            ->make(true);
    }

    public function export_rekam_medis(Request $request)
    {
        $data = [
            'kode' => $request->kode,
            'siswa' => $request->siswa,
            'gejala' => $request->gejala,
            'kategori' => $request->kategori,
            'obat' => $request->obat,
            'qty' => $request->qty,
            'tgl_start' => $request->tgl_start,
            'tgl_end' => $request->tgl_end,
            'search_manual' => $request->search_manual,
            'like' => $request->like,
        ];
        return Excel::download(new RekamMedisExport($data), 'rekam_medis_' . date('YmdH') . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
