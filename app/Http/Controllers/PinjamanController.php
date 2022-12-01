<?php

namespace App\Http\Controllers;

use App\Exports\PinjamanBuku;
use App\Helper\AlertHelper;
use App\Models\Buku;
use App\Models\Employee;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Pinjaman;
use App\Models\Setting;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PinjamanController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'perpustakaan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('74', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => 'data pinjaman',
            ];
            return view('pinjaman.list_pinjaman')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function pinjaman_ajax(Request $request)
    {
        // querynya
        $pin = DB::table('perpus_pinjaman')
            ->select(
                'perpus_pinjaman.id',
                'kode_transaksi',
                'peminjam',
                'siswa.nama_lengkap as siswa',
                'karyawan.nama_lengkap as karyawan',
                'tgl_pinjam',
                'tgl_perkiraan_kembali',
                'tgl_kembali',
                'all_date_return',
                'judul',
            )
            ->selectRaw('SUM(jml) as jml')
            ->selectRaw("CONCAT(IFNULL(school_level.level,''),' ',IFNULL(school_class.classes,''),' ',IFNULL(classes.jurusan,''),' ',IFNULL(classes.type,'')) as kelas")
            ->leftJoin('siswa', 'siswa.id', 'perpus_pinjaman.siswa_id')
            ->leftJoin('karyawan', 'karyawan.id', 'perpus_pinjaman.karyawan_id')
            ->leftJoin('classes', 'classes.id', 'siswa.class_id')
            ->leftJoin('school_level', 'school_level.id', 'classes.id_school_level')
            ->leftJoin('school_class', 'school_class.id', 'classes.class_id')
            ->leftJoin('perpus_buku', 'perpus_buku.id', 'perpus_pinjaman.buku_id')
            ->whereNull('perpus_pinjaman.deleted_at')
            ->orderBy('perpus_pinjaman.id', 'DESC');

        if ($request->get('search_manual') != null) {
            $search = $request->get('search_manual');
            $replaced = str_replace(' ', '', $search);
            $pin->where(function ($where) use ($search, $replaced) {
                $where
                    ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
                    ->orWhere('peminjam', 'like', '%' . $search . '%')
                    ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('karyawan.nama_lengkap', 'like', '%' . $search . '%')
                    ->orwhereRaw(
                        "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                        '%' . $replaced . '%'
                    )
                    ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('tgl_perkiraan_kembali', 'like', '%' . $search . '%')
                    ->orWhere('tgl_kembali', 'like', '%' . $search . '%');
            });

            $search = $request->get('search');
            if ($search != null) {
                $replaced = str_replace(' ', '', $search);
                $pin->where(function ($where) use ($search, $replaced) {
                    $where
                        ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
                        ->orWhere('peminjam', 'like', '%' . $search . '%')
                        ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('karyawan.nama_lengkap', 'like', '%' . $search . '%')
                        ->orwhereRaw(
                            "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                            '%' . $replaced . '%'
                        )
                        ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                        ->orWhere('tgl_perkiraan_kembali', 'like', '%' . $search . '%')
                        ->orWhere('tgl_kembali', 'like', '%' . $search . '%');
                });
            }
            $pin->groupBy('kode_transaksi');
        } else {
            if ($request->get('kode') != null) {
                $kode = $request->get('kode');
                $pin->where('kode_transaksi', '=', $kode);
            }
            if ($request->get('peminjam') != null) {
                $peminjam = $request->get('peminjam');
                $pin->where('siswa.nama_lengkap', '=', $peminjam)
                    ->orwhere('karyawan.nama_lengkap', '=', $peminjam);
            }
            if ($request->get('kelas') != null) {
                $kelas = $request->get('kelas');
                if ($request->get('type') == 'Detail') {
                    $pin->Where('judul', 'like', '%' . $kelas . '%');
                } else {
                    $kelas = str_replace(' ', '', $kelas);
                    $pin->whereRaw(
                        "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                        '%' . $kelas . '%'
                    );
                }
            }
            if ($request->get('tgl_end') != null) {
                $start = $request->get('tgl_start');
                $end = $request->get('tgl_end');
                $pin->whereBetween('tgl_pinjam', [$start, $end]);
            }
            if ($request->get('jml_end') != null) {
                $jml_start = $request->get('jml_start');
                $jml_end = $request->get('jml_end');
                $pin->havingRaw("SUM(jml) >= '$jml_start' and SUM(jml) <= '$jml_end'");
            }
            if ($request->get('type') != null) {
                if ($request->get('type') == 'Summary') {
                    $pin->groupBy('kode_transaksi');
                }
                if ($request->get('type') == 'Detail') {
                    $pin->groupBy('perpus_pinjaman.id');
                }
            } else {
                $pin->groupBy('kode_transaksi');
            }
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $replaced = str_replace(' ', '', $search);
                $pin->where(function ($where) use ($search, $replaced) {
                    $where
                        ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
                        ->orWhere('peminjam', 'like', '%' . $search . '%')
                        ->orWhere('siswa.nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('karyawan.nama_lengkap', 'like', '%' . $search . '%')
                        ->orwhereRaw(
                            "CONCAT(IFNULL(school_level.level,''),'',IFNULL(school_class.classes,''),'',IFNULL(classes.jurusan,''),'',IFNULL(classes.type,'')) like ?",
                            '%' . $replaced . '%'
                        )
                        ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                        ->orWhere('tgl_perkiraan_kembali', 'like', '%' . $search . '%')
                        ->orWhere('tgl_kembali', 'like', '%' . $search . '%');
                });
            }
        }

        if ($request->get('type') != null and $request->get('type') == 'Detail') {
            return DataTables::of($pin)
                ->addIndexColumn()
                ->addColumn('peminjam', function ($pin) {
                    if ($pin->peminjam == 'Siswa') {
                        $nama = $pin->siswa;
                    } else {
                        $nama = $pin->karyawan;
                    }
                    return $nama;
                })
                ->addColumn('kelas', function ($pin) {
                    if (strlen($pin->judul) > 50) {
                        $titik = '...';
                    } else {
                        $titik = null;
                    }

                    return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $pin->judul . '">' . substr($pin->judul, 0, 50) . $titik . '</label>';
                })
                ->addColumn('action', 'pinjaman.button')
                ->rawColumns(['action', 'peminjam', 'kelas'])
                ->make(true);
        } else {
            return DataTables::of($pin)
                ->addIndexColumn()
                ->addColumn('peminjam', function ($pin) {
                    if ($pin->peminjam == 'Siswa') {
                        $nama = $pin->siswa;
                    } else {
                        $nama = $pin->karyawan;
                    }
                    return $nama;
                })
                ->addColumn('action', 'pinjaman.button')
                ->rawColumns(['action', 'peminjam'])
                ->make(true);
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
        if (in_array('75', $session_menu)) {
            function timeAndMilliseconds()
            {
                $m = explode(' ', microtime());
                return [$m[1], (int) round($m[0] * 1000, 3)];
            }
            [$totalSeconds, $extraMilliseconds] = timeAndMilliseconds();
            $milisecond = date('YmdHis', $totalSeconds) . "$extraMilliseconds";

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => 'tambah pinjaman',
                'milisecond' => $milisecond,
            ];
            return view('pinjaman.add_pinjaman')->with($data);
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
        if (in_array('75', $session_menu)) {
            $registration_number = Pinjaman::limit(1)->groupBy('kode_transaksi')->orderBy('id', 'desc')->get();
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
                for ($i = 0; $i < count($request->data_post); $i++) {
                    $cek_qty = Buku::findorfail($request->data_post[$i]['buku_id']);
                    if ($request->data_post[$i]['jml_buku'] > $cek_qty->jml_buku) {
                        return response()->json([
                            'code' => 404,
                            'message' => 'Stock Buku <strong>' . $cek_qty->judul . '</strong> hanya <strong>' . $cek_qty->jml_buku . '</strong>',
                        ]);
                    }
                }

                // cek setting peminjaman jumlah buku berapa hari
                $setting = Setting::first();
                for ($i = 0; $i < count($request->data_post); $i++) {

                    // cek denda
                    if ($request->peminjam == 'Siswa') {
                        $cek_denda = DB::table('perpus_pinjaman')
                            ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                            ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                            ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                            ->whereNull('deleted_at')
                            ->whereNull('tgl_kembali')
                            ->where('siswa_id', '=', $request->siswa)
                            ->get();
                    } else {
                        $cek_denda = DB::table('perpus_pinjaman')
                            ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                            ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                            ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                            ->whereNull('deleted_at')
                            ->whereNull('tgl_kembali')
                            ->where('karyawan_id', '=', $request->karyawan)
                            ->get();
                    }

                    if ($cek_denda) {
                        $jml = $cek_denda[0]->jml;
                        $jml_pinjam = $cek_denda[0]->jml_pinjam;
                        $denda = $cek_denda[0]->jml_denda * 2;
                        $sisa_limit = $jml + $jml_pinjam + $denda;
                    } else {
                        $sisa_limit = 0;
                    }

                    // cek limit dengan denda
                    if ($sisa_limit >= $setting->library_loan_validation) {
                        return response()->json([
                            'code' => 404,
                            'message' => 'Gagal karena melebihi limit peminjaman',
                        ]);
                    }

                    $pinjaman = new Pinjaman;
                    $pinjaman->kode_transaksi = $kode_transaksi;
                    $pinjaman->milisecond = $request->milisecond;
                    $pinjaman->peminjam = $request->peminjam;
                    $pinjaman->siswa_id = $request->siswa;
                    $pinjaman->karyawan_id = $request->karyawan;
                    $pinjaman->class_id = $request->jenjang;
                    $pinjaman->buku_id = $request->data_post[$i]['buku_id'];
                    $pinjaman->jml = $request->data_post[$i]['jml_buku'];
                    $pinjaman->tgl_pinjam = $request->tgl_pinjam;
                    $pinjaman->tgl_perkiraan_kembali = Carbon::parse($request->tgl_pinjam)->addDay($setting->library_loan_day);
                    $pinjaman->user_created =  Auth::user()->id;
                    $pinjaman->save();

                    $stock = Buku::findorfail($request->data_post[$i]['buku_id']);
                    Buku::where('id', $request->data_post[$i]['buku_id'])->update(['jml_buku' => $stock->jml_buku - $request->data_post[$i]['jml_buku']]);
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
                    'message' => 'Gagal Peminjaman Buku',
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
        if (in_array('74', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => ' pinjaman',
                'buku' => Buku::all(),
                'kategori' => Kategori::all(),
                'penerbit' => Penerbit::all(),
                'pinjaman' => Pinjaman::where('kode_transaksi', $id_decrypted)->get(),
            ];
            return view('pinjaman.show')->with($data);
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
        if (in_array('76', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'pinjaman',
                'label' => 'ubah pinjaman',
                'pinjaman' => Pinjaman::where('kode_transaksi', $id_decrypted)->get(),
            ];
            return view('pinjaman.edit_pinjaman')->with($data);
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
        if (in_array('76', $session_menu)) {
            $id = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                Pinjaman::where('id', $id)->update(['tgl_kembali' => Carbon::now()]);

                DB::commit();
                AlertHelper::updateAlert(true);
                return back();
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function post_update(Request $request)
    {
        DB::beginTransaction();
        try {
            Pinjaman::where('kode_transaksi', $request->kode_transaksi)->update(['tgl_pinjam' => $request->tgl_pinjam, 'tgl_perkiraan_kembali' => Carbon::parse($request->tgl_pinjam)->addDay('7')]);

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Berhasil diubah',
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal diubah',
            ]);
        }
    }

    public function store_edit(Request $request)
    {
        DB::beginTransaction();
        try {
            // cek setting peminjaman jumlah buku berapa hari
            $setting = Setting::first();

            for ($i = 0; $i < count($request->data_post); $i++) {

                $cek_qty = Buku::findorfail($request->data_post[$i]['buku_id']);
                if ($request->data_post[$i]['jml_buku'] > $cek_qty->jml_buku) {
                    return response()->json([
                        'code' => 404,
                        'message' => 'Stock Buku <strong>' . $cek_qty->judul . '</strong> hanya <strong>' . $cek_qty->jml_buku . '</strong>',
                    ]);
                }

                // cek denda
                if ($request->peminjam == 'Siswa') {
                    $cek_denda = DB::table('perpus_pinjaman')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                        ->whereNull('deleted_at')
                        ->whereNull('tgl_kembali')
                        ->where('siswa_id', '=', $request->siswa)
                        ->get();
                } else {
                    $cek_denda = DB::table('perpus_pinjaman')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                        ->whereNull('deleted_at')
                        ->whereNull('tgl_kembali')
                        ->where('karyawan_id', '=', $request->karyawan)
                        ->get();
                }

                if ($cek_denda) {
                    $jml = $cek_denda[0]->jml;
                    $jml_pinjam = $cek_denda[0]->jml_pinjam;
                    $denda = $cek_denda[0]->jml_denda * 2;
                    $sisa_limit = $jml + $jml_pinjam + $denda;
                } else {
                    $sisa_limit = 0;
                }

                // cek limit dengan denda
                if ($sisa_limit >= $setting->library_loan_validation) {
                    return response()->json([
                        'code' => 404,
                        'message' => 'Gagal karena melebihi limit peminjaman',
                    ]);
                }

                $pinjaman = new Pinjaman;
                $pinjaman->kode_transaksi = $request->kode_transaksi;
                $pinjaman->milisecond = $request->milisecond;
                $pinjaman->peminjam = $request->peminjam;
                $pinjaman->siswa_id = $request->siswa;
                $pinjaman->karyawan_id = $request->karyawan;
                $pinjaman->class_id = $request->jenjang;
                $pinjaman->buku_id = $request->data_post[$i]['buku_id'];
                $pinjaman->jml = $request->data_post[$i]['jml_buku'];
                $pinjaman->tgl_pinjam = $request->tgl_pinjam;
                $pinjaman->tgl_perkiraan_kembali = Carbon::parse($request->tgl_pinjam)->addDay($setting->library_loan_day);
                $pinjaman->user_created =  Auth::user()->id;
                $pinjaman->save();

                $stock = Buku::findorfail($request->data_post[$i]['buku_id']);
                Buku::where('id', $request->data_post[$i]['buku_id'])->update(['jml_buku' => $stock->jml_buku - $request->data_post[$i]['jml_buku']]);
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
                'message' => 'Gagal Peminjaman Buku',
            ]);
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
        if (in_array('77', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $titles = Pinjaman::where('kode_transaksi', $id_decrypted)->get();
                foreach ($titles as $item) {
                    $stock = Buku::findorfail($item->buku_id);
                    Buku::where('id', $stock->id)->update(['jml_buku' => $stock->jml_buku + $item->jml]);
                }

                $datetime = Carbon::now();
                Pinjaman::where('kode_transaksi', $id_decrypted)->update(['user_deleted' => Auth::user()->id, 'deleted_at' => $datetime]);

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
        if ($request->peminjam == 'Guru' or $request->peminjam == 'Karyawan') {
            $data = Employee::where('niks', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = null;
                $type = $request->peminjam;
                $code = 200;
                $val = $val + 1;
            }
        }
        if ($request->peminjam == '') {
            $data = Buku::where('barcode', $request->barcode)->first();
            if ($data) {
                $id = $data->id;
                $class_id = $data->kategori->kode_kategori . '-' . $data->judul;
                $type = 'buku';
                $code = 200;
                $val = $val + 1;
            }
        } elseif ($request->peminjam != '' and $val == 0) {
            $data = Buku::where('barcode', $request->barcode)->first();
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

    public function scanBarcodeEd(Request $request)
    {
        $data = Buku::where('barcode', $request->barcode)->first();
        if ($data) {
            if ($data->jml_buku < '1') {
                return response()->json([
                    'code' => 404,
                    'message' => 'Stock Buku <strong>' . $data->judul . '</strong> hanya <strong>' . $data->jml_buku . '</strong>',
                ]);
            }

            // cek setting peminjaman jumlah buku berapa hari
            $setting = Setting::first();
            // cek denda
            if ($request->peminjam == 'Siswa') {
                $cek_denda = DB::table('perpus_pinjaman')
                    ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                    ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                    ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                    ->whereNull('deleted_at')
                    ->whereNull('tgl_kembali')
                    ->where('siswa_id', '=', $request->siswa)
                    ->get();
            } else {
                $cek_denda = DB::table('perpus_pinjaman')
                    ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                    ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                    ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                    ->whereNull('deleted_at')
                    ->whereNull('tgl_kembali')
                    ->where('karyawan_id', '=', $request->karyawan)
                    ->get();
            }

            if ($cek_denda) {
                $jml = $cek_denda[0]->jml;
                $jml_pinjam = $cek_denda[0]->jml_pinjam;
                $denda = $cek_denda[0]->jml_denda * 2;
                $sisa_limit = $jml + $jml_pinjam + $denda;
            } else {
                $sisa_limit = 0;
            }

            // cek limit dengan denda
            if ($sisa_limit >= $setting->library_loan_validation) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal karena melebihi limit peminjaman',
                ]);
            }

            $pinjaman = new Pinjaman;
            $pinjaman->kode_transaksi = $request->kode_transaksi;
            $pinjaman->milisecond = $request->milisecond;
            $pinjaman->peminjam = $request->peminjam;
            $pinjaman->siswa_id = $request->siswa;
            $pinjaman->karyawan_id = $request->karyawan;
            $pinjaman->class_id = $request->jenjang;
            $pinjaman->buku_id = $data->id;
            $pinjaman->jml = '1';
            $pinjaman->tgl_pinjam = $request->tgl_pinjam;
            $pinjaman->user_created =  Auth::user()->id;
            $pinjaman->save();

            $stock = Buku::findorfail($data->id);
            Buku::where('id', $data->id)->update(['jml_buku' => '1']);

            return response()->json([
                'code' => 200,
                'message' => 'Peminjaman Buku berhasil',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak terdaftar',
            ]);
        }
    }

    public function scanBarcodeEdit(Request $request)
    {
        $data = Buku::where('barcode', $request->barcode)->first();
        if ($data) {
            $id = $data->id;
            DB::beginTransaction();
            try {
                if ($data->jml_buku < '1') {
                    return response()->json([
                        'code' => 404,
                        'message' => 'Stock Buku <strong>' . $data->judul . '</strong> hanya <strong>' . $data->jml_buku . '</strong>',
                    ]);
                }

                // cek setting peminjaman jumlah buku berapa hari
                $setting = Setting::first();
                // cek denda
                if ($request->peminjam == 'Siswa') {
                    $cek_denda = DB::table('perpus_pinjaman')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                        ->whereNull('deleted_at')
                        ->whereNull('tgl_kembali')
                        ->where('siswa_id', '=', $request->siswa)
                        ->get();
                } else {
                    $cek_denda = DB::table('perpus_pinjaman')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali = CURDATE() THEN 1 END) AS jml')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali > CURDATE() THEN 1 END) AS jml_pinjam')
                        ->selectRaw('COUNT(CASE WHEN tgl_perkiraan_kembali < CURDATE() THEN 1 END) AS jml_denda')
                        ->whereNull('deleted_at')
                        ->whereNull('tgl_kembali')
                        ->where('karyawan_id', '=', $request->karyawan)
                        ->get();
                }

                if ($cek_denda) {
                    $jml = $cek_denda[0]->jml;
                    $jml_pinjam = $cek_denda[0]->jml_pinjam;
                    $denda = $cek_denda[0]->jml_denda * 2;
                    $sisa_limit = $jml + $jml_pinjam + $denda;
                } else {
                    $sisa_limit = 0;
                }

                // cek limit dengan denda
                if ($sisa_limit >= $setting->library_loan_validation) {
                    return response()->json([
                        'code' => 404,
                        'message' => 'Gagal karena melebihi limit peminjaman',
                    ]);
                }

                $pinjaman = new Pinjaman;
                $pinjaman->kode_transaksi = $request->kode_transaksi;
                $pinjaman->milisecond = $request->milisecond;
                $pinjaman->peminjam = $request->peminjam;
                $pinjaman->siswa_id = $request->siswa;
                $pinjaman->karyawan_id = $request->karyawan;
                $pinjaman->class_id = $request->jenjang;
                $pinjaman->buku_id = $id;
                $pinjaman->jml = '1';
                $pinjaman->tgl_pinjam = $request->tgl_pinjam;
                $pinjaman->user_created =  Auth::user()->id;
                $pinjaman->save();

                DB::commit();

                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil Menambah Buku',
                ]);
            } catch (\Throwable $err) {
                DB::rollBack();
                throw $err;
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal Menambah Buku',
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak terdaftar!',
            ]);
        }
    }

    public function destroy_id(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('77', $session_menu)) {
            $variabel = Crypt::decryptString($id);
            $dat = explode("|", $variabel);
            $id_decrypted = $dat[0];
            $kode_transaksi = $dat[1];

            DB::beginTransaction();
            try {
                $pinjaman = Pinjaman::findorfail($id_decrypted);
                // update stock
                $stock = Buku::findorfail($pinjaman->buku_id);
                Buku::where('id', $stock->id)->update(['jml_buku' => $stock->jml_buku + $pinjaman->jml]);
                // delete pinjaman
                $pinjaman->user_deleted = Auth::user()->id;
                $pinjaman->deleted_at = Carbon::now();
                $pinjaman->save();

                DB::commit();
                AlertHelper::deleteAlert(true);

                $count_pinjaman = Pinjaman::where('kode_transaksi', $kode_transaksi)->count();
                if ($count_pinjaman == 0) {
                    return redirect('pinjaman');
                } else {
                    return back();
                }
            } catch (\Throwable $err) {
                DB::rollBack();
                AlertHelper::deleteAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function edit_buku(Request $request)
    {
        $data = [
            'id' => $request->id,
            'item' => Pinjaman::findorfail(Crypt::decryptString($request->id)),
        ];
        return view('pinjaman.jml_peminjaman_edit')->with($data);
    }

    public function update_jml(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $request->validate([
            'jml' => 'required',
            'buku_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            if ($request['jml'] > $request->jml_old) {
                $stock = Buku::findorfail($request->buku_id);
                $kurang = $request['jml'] - $request->jml_old;
                dd($kurang);
                if ($kurang < 0) {
                    AlertHelper::updateAlert(true);
                    return back();
                } else {
                    Buku::where('id', $request->buku_id)->update(['jml_buku' => $stock->jml_buku - $kurang]);
                }
            } elseif ($request['jml'] < $request->jml_old) {
                // dd('xq');
                $stock = Buku::findorfail($request->buku_id);
                $tambah = $request->jml_old - $request['jml'];
                if ($tambah < 0) {
                    AlertHelper::updateAlert(true);
                    return back();
                } else {
                    Buku::where('id', $request->buku_id)->update(['jml_buku' => $stock->jml_buku + $tambah]);
                }
            }
            $pinjaman = Pinjaman::findOrFail($id);
            $pinjaman->jml = $request['jml'];
            $pinjaman->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            return back();
        }
    }

    public function approve($id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'pinjaman',
            'label' => 'approve pinjaman',
            'buku' => Buku::all(),
            'kategori' => Kategori::all(),
            'penerbit' => Penerbit::all(),
            'pinjaman' => Pinjaman::where('kode_transaksi', $id_decrypted)->get(),
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('78', $session_menu)) {
            return view('pinjaman.approve')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function export_pinjaman_buku(Request $request)
    {
        $data = [
            'kode' => $request->kode,
            'peminjam' => $request->peminjam,
            'kelas' => $request->kelas,
            'tgl_start' => $request->tgl_start,
            'tgl_end' => $request->tgl_end,
            'jml_start' => $request->jml_start,
            'jml_end' => $request->jml_end,
            'type' => $request->type,
            'search_manual' => $request->search_manual,
            'like' => $request->like,
        ];
        return Excel::download(new PinjamanBuku($data), 'pinjaman_buku.xlsx');
    }

    public function search_loan()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('74', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'cek pinjaman',
                'label' => 'Cari data pinjaman',
            ];
            return view('pinjaman.search_loan')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function getsearch(Request $request)
    {
        function timeAndMilliseconds()
        {
            $m = explode(' ', microtime());
            return [$m[1], (int) round($m[0] * 1000, 3)];
        }
        [$totalSeconds, $extraMilliseconds] = timeAndMilliseconds();
        $milisecond = date('YmdHis', $totalSeconds) . "$extraMilliseconds";

        if ($request->value_peminjam == 'Siswa') {
            $idPeminjam = Siswa::where('barcode', $request->scanner_barcode)->first();
            if ($idPeminjam) {
                $peminjam = Pinjaman::where('peminjam', $request->value_peminjam)->whereNull('tgl_kembali')->where('siswa_id', $idPeminjam->id)->get();
                return response()->json([
                    'code' => 200,
                    'milisecond' => $milisecond,
                    'peminjam' => $request->value_peminjam,
                    'jenjang' => $idPeminjam->class_id,
                    'siswa' => $idPeminjam->id,
                    'karyawan' => null,
                    'encrypt_peminjam' => Crypt::encryptString($idPeminjam->id),
                    'data' => count($peminjam),
                    'tgl_pinjam' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'message' => 'Data tidak terdaftar',
                ]);
            }
        } else {
            $idPeminjam = Employee::where('niks', $request->scanner_barcode)->first();
            if ($idPeminjam) {
                $peminjam = Pinjaman::where('peminjam', $request->value_peminjam)->whereNull('tgl_kembali')->where('karyawan_id', $idPeminjam->id)->get();
                return response()->json([
                    'code' => 200,
                    'milisecond' => $milisecond,
                    'peminjam' => $request->value_peminjam,
                    'jenjang' => null,
                    'siswa' => null,
                    'karyawan' => $idPeminjam->id,
                    'encrypt_peminjam' => Crypt::encryptString($idPeminjam->id),
                    'data' => count($peminjam),
                    'tgl_pinjam' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'message' => 'Data tidak terdaftar',
                ]);
            }
        }
    }

    public function return_book($id, $type)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('74', $session_menu)) {
            if ($type == 'Siswa') {
                $user = Siswa::findorfail(Crypt::decryptString($id));
                $loan = Pinjaman::where('siswa_id', $user->id)->wherenull('all_date_return')->orderBy('id', 'asc')->get();
                if ($user->classes_student->school_class) {
                    $classes = $user->classes_student->school_class->classes;
                } else {
                    $classes = null;
                }
                $name = $user->nis . ' - ' . $user->nama_lengkap . ' - ' . $user->classes_student->school_level->level . ' ' . $classes . ' ' . $user->classes_student->jurusan . ' ' . $user->classes_student->type;
            } else {
                $user = Employee::findorfail(Crypt::decryptString($id));
                $loan = Pinjaman::where('karyawan_id', $user->id)->wherenull('all_date_return')->orderBy('id', 'asc')->get();
                $name = $user->niks . ' - ' . $user->nama_lengkap;
            }
            $list = [];
            foreach ($loan as $item) {
                $dataA = [
                    'flag' => 'header',
                    'id' => null,
                    'kode' => $item->kode_transaksi, 'tgl_pinjam' => $item->tgl_pinjam, 'tgl_perkiraan_kembali' => $item->tgl_perkiraan_kembali, 'tgl_kembali' => null
                ];
                if (!in_array($dataA, $list)) {
                    array_push($list, $dataA);
                }
                $dataB = [
                    'flag' => 'detail',
                    'id' => $item->id,
                    'kode' => $item->kode_transaksi, 'tgl_pinjam' => '[' . $item->buku->barcode . '] - [' . $item->buku->kategori->kode_kategori . '] - ' . $item->buku->judul, 'tgl_perkiraan_kembali' => $item->jml, 'tgl_kembali' => $item->tgl_kembali
                ];
                array_push($list, $dataB);
            }

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'cek pinjaman',
                'label' => 'Cari data pinjaman',
                'user' => $user,
                'list' => $list,
                'name' => $name,
                'type' => $type,
            ];
            return view('pinjaman.return_book')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function book_return($id, $kode)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('76', $session_menu)) {
            $id = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                Pinjaman::where('id', $id)->update(['tgl_kembali' => Carbon::now()]);

                $pinjaman = Pinjaman::where('kode_transaksi', $kode)->wherenull('tgl_kembali')->count();
                if ($pinjaman == 0) {
                    Pinjaman::where('kode_transaksi', $kode)->update(['all_date_return' => Carbon::now()]);
                }

                DB::commit();
                AlertHelper::alertDinamis(true, 'Berhasil dikembalikan');
                return back();
            } catch (\Throwable $err) {
                DB::rollback();
                AlertHelper::alertDinamis(false, 'Gagal dikembalikan');
                throw $err;
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function cancle_return($id, $kode)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('76', $session_menu)) {
            $id = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                Pinjaman::where('id', $id)->update(['tgl_kembali' => null]);

                $pinjaman = Pinjaman::where('kode_transaksi', $kode)->wherenull('tgl_kembali')->count();
                if ($pinjaman > 0) {
                    Pinjaman::where('kode_transaksi', $kode)->update(['all_date_return' => null]);
                }

                DB::commit();
                AlertHelper::alertDinamis(true, 'Berhasil batal dikembalikan');
                return back();
            } catch (\Throwable $err) {
                DB::rollback();
                AlertHelper::alertDinamis(false, 'Gagal batal dikembalikan');
                throw $err;
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function kembalikan_buku(Request $request)
    {
        $buku = Buku::where('barcode', $request->scanner_barcode)->first();
        if ($buku == null) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak terdaftar',
            ]);
        }

        DB::beginTransaction();
        try {
            $matchThese = [];
            if ($request->type == 'Siswa') {
                $user = array('siswa_id' => $request->user);
            } else {
                $user = array('karyawan_id' => $request->user);
            }
            $buku_pinjaman = array('buku_id' => $buku->id);
            $matchThese = $user + $buku_pinjaman;
            $pinjaman = Pinjaman::where('peminjam', $request->type)->where($matchThese)->first();

            Pinjaman::where('id', $pinjaman->id)->update(['tgl_kembali' => Carbon::now()]);

            $cek_pinjaman = Pinjaman::where('kode_transaksi', $pinjaman->kode_transaksi)->wherenull('tgl_kembali')->count();
            if ($cek_pinjaman == 0) {
                Pinjaman::where('kode_transaksi', $pinjaman->kode_transaksi)->update(['all_date_return' => Carbon::now()]);
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'encrypt_peminjam' => Crypt::encryptString($request->user),
                'type' => $request->type,
            ]);
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;

            return response()->json([
                'code' => 404,
                'type' => $request->type,
                'encrypt_peminjam' => Crypt::encryptString($request->user),
                'message' => 'Gagal pengembalianii',
            ]);
        }
    }
}
