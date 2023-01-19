<?php

namespace App\Http\Controllers;

use App\Exports\RekapPerpusExport;
use App\Exports\RekapPerpusSiswaExport;
use App\Models\Employee;
use App\Models\Pinjaman;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RekapPerpusController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = ' perpus';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('116', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'rekam ' . $this->submenu,
                'label' => 'rekam ' . $this->submenu,
            ];
            return view('perpus.rekap.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function rekap_perpus_list(Request $request)
    {
        // querynya
        $list = DB::table('perpus_pinjaman')
            ->select(
                'kode_transaksi',
                'peminjam',
                'jml',
                'tgl_pinjam',
                'tgl_perkiraan_kembali',
                'tgl_kembali',
                'siswa.nama_lengkap as nama_siswa',
                'karyawan.nama_lengkap as nama_karyawan',
                'judul',
                'kode_kategori',
            )
            ->Join('perpus_buku', 'perpus_buku.id', 'perpus_pinjaman.buku_id')
            ->Join('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->leftJoin('siswa', 'siswa.id', 'perpus_pinjaman.siswa_id')
            ->leftJoin('karyawan', 'karyawan.id', 'perpus_pinjaman.karyawan_id')
            ->whereNull('perpus_pinjaman.deleted_at')
            ->orderBy('kode_transaksi');

        if ($request->get('search_manual') != null) {
            $search = $request->get('search_manual');
            $list->where(function ($where) use ($search) {
                $where
                    ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('karyawan.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('buku', 'like', '%' . $search . '%')
                    ->orWhere('jml', 'like', '%' . $search . '%')
                    ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('tgl_perkiraan_kembali', 'like', '%' . $search . '%')
                    ->orWhere('tgl_kembali', 'like', '%' . $search . '%');
            });
        } else {
            if ($request->get('kode') != null) {
                $kode = $request->get('kode');
                $list->where('kode_transaksi', '=', $kode);
            }
            if ($request->get('nama') != null) {
                $nama = $request->get('nama');
                $list->where(function ($query) use ($nama) {
                    $query->where('siswa.nama_lengkap', 'LIKE', '%' . $nama . '%')
                        ->orwhere('karyawan.nama_lengkap', 'LIKE', '%' . $nama . '%');
                });
            }
            if ($request->get('buku') != null) {
                $buku = $request->get('buku');
                $list->where('judul', 'LIKE', '%' . $buku . '%');
            }
            if ($request->get('jml') != null) {
                $jml = $request->get('jml');
                $list->where('jml', '=', $jml);
            }
            if ($request->get('tgl_end_pinjam') != null) {
                $start = $request->get('tgl_start_pinjam');
                $end = $request->get('tgl_end_pinjam');
                $list->whereBetween('tgl_pinjam', [$start, $end]);
            }
            if ($request->get('tgl_end_kembali') != null) {
                $start = $request->get('tgl_start_kembali');
                $end = $request->get('tgl_end_kembali');
                $list->whereBetween('tgl_kembali', [$start, $end]);
            }
        }

        return DataTables::of($list)
            ->addColumn('nama', function ($list) {
                if ($list->nama_siswa) {
                    $nama = $list->nama_siswa;
                } else {
                    $nama = $list->nama_karyawan;
                }
                return $nama;
            })
            ->addColumn('buku', function ($list) {
                return $list->kode_kategori . '-' . $list->judul;
            })
            ->make(true);
    }

    public function export_rekap_perpus(Request $request)
    {
        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'buku' => $request->buku,
            'jml' => $request->jml,
            'tgl_start_pinjam' => $request->tgl_start_pinjam,
            'tgl_end_pinjam' => $request->tgl_end_pinjam,
            'tgl_start_kembali' => $request->tgl_start_kembali,
            'tgl_end_kembali' => $request->tgl_end_kembali,
            'search_manual' => $request->search_manual,
            'like' => $request->like,
        ];
        return Excel::download(new RekapPerpusExport($data), 'rekap_perpus' . date('YmdH') . '.xlsx');
    }

    public function rekap_perpus_siswa(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('116', $session_menu)) {
            if ($request->peminjam == 'Siswa') {
                $siswa = Siswa::where('barcode', Crypt::decryptString($request->kode))->first();
                $barcode = $siswa->barcode;
                $nama = $siswa->nama_lengkap;
                $nis = $siswa->nis;
                if ($siswa->classes_student->school_class) {
                    $class = ' ' . $siswa->classes_student->school_class->classes . ' ';
                } else {
                    $class = ' ';
                }
                $kelas = $siswa->classes_student->school_level->level . $class . $siswa->classes_student->jurusan . '.' . $siswa->classes_student->type;
                $perpus = Pinjaman::where('siswa_id', $siswa->id)->get();
            } elseif ($request->peminjam == 'Karyawan' or $request->peminjam == 'Guru') {
                $karyawan = Employee::where('niks', Crypt::decryptString($request->kode))->first();
                $barcode = $karyawan->niks;
                $nama = $karyawan->nama_lengkap;
                $nis = $karyawan->niks;
                $kelas = null;
                $perpus = Pinjaman::where('karyawan_id', $karyawan->id)->get();
            } else {
                $barcode = null;
                $nama = null;
                $nis = null;
                $kelas = null;
                $perpus = null;
            }
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'rekam ' . $this->submenu,
                'label' => 'rekam ' . $this->submenu,
                'peminjam' => $request->peminjam,
                'barcode' => $barcode,
                'nama' => $nama,
                'nis' => $nis,
                'kelas' => $kelas,
                'perpus' => $perpus,
            ];
            return view('perpus.rekap.rekap_perpus_siswa')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function getBarcodePerpus(Request $request)
    {
        $val = 0;
        if ($request->value_peminjam == 'Siswa') {
            $data = Siswa::where('barcode', $request->scanner_barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->class_id;
                $type = $request->value_peminjam;
                $barcode = $data->barcode;
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($request->value_peminjam == 'Guru' or $request->value_peminjam == 'Karyawan') {
            $data = Employee::where('niks', $request->scanner_barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = null;
                $type = $request->value_peminjam;
                $barcode = $data->niks;
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($val == 0) {
            $id = null;
            $class_id = null;
            $type = null;
            $barcode = null;
            $code = 400;
        }
        return response()->json([
            'code' => $code,
            'id' => $id,
            'jenjang' => $class_id,
            'barcode' => Crypt::encryptString($barcode),
            'type' => $type,
            'val' => $val,
        ]);
    }

    public function export_rekap_perpus_siswa(Request $request)
    {
        $data = [
            'kode' => $request->kode,
            'peminjam' => $request->peminjam,
        ];
        return Excel::download(new RekapPerpusSiswaExport($data), 'rekap_perpus_siswa_' . date('YmdH') . '.xlsx');
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
