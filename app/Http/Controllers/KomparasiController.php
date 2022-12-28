<?php

namespace App\Http\Controllers;

use App\Models\KomparasiModel;
use App\Models\ObatModel;
use App\Models\OpnameStokModel;
use App\Models\StokObatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KomparasiController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = 'komparasi';

    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('108', $session_menu)) {
            // cek data yang belum opname
            $count = DB::table('uks_obat')
                ->select('status', 'obat')
                ->leftJoin('uks_opname_stok', function ($join) {
                    $join->on('uks_opname_stok.id_obat', '=', 'uks_obat.id')
                        ->where('uks_opname_stok.status', '!=', 'D')
                        ->whereNull('uks_opname_stok.deleted_at');
                })
                ->whereNull('uks_opname_stok.deleted_at')
                ->whereNull('kode_transaksi')
                ->where(function ($query) {
                    $query->orWhere('uks_opname_stok.status', '=', 'A')
                        ->orwhereNull('uks_opname_stok.status');
                })
                ->groupBy('uks_obat.id')
                ->havingRaw('CASE WHEN status = "A" THEN sum(jml) ELSE 0 END > 0 or SUM(stok) > 0')
                ->count();

            // cek data jml opname > jml Sistem = silisih > 0 (tambah stok manual) ]
            $count_manual = DB::table('uks_obat')
                ->select('stok')
                ->selectRaw('ifnull(SUM(jml),0) - stok as selisih')
                ->leftJoin('uks_opname_stok', function ($join) {
                    $join->on('uks_opname_stok.id_obat', '=', 'uks_obat.id')
                        ->where('uks_opname_stok.status', '!=', 'D');
                })
                ->whereNull('uks_opname_stok.deleted_at')
                ->where(function ($query) {
                    $query->orWhere('uks_opname_stok.status', '=', 'A')
                        ->orwhereNull('uks_opname_stok.status');
                })
                ->groupBy('uks_obat.id')
                ->havingRaw('ifnull(SUM(jml),0) - stok > 0')
                ->count();

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data ' . $this->submenu,
                'count' => $count,
                'count_manual' => $count_manual,
            ];
            return view('uks.komparasi.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function komparasi_list(Request $request)
    {
        // querynya
        $list = DB::table('uks_obat')
            ->select(
                'kode_transaksi',
                'tgl_opname',
                'obat',
                'jenis_obat',
                'uks_opname_stok.created_at',
                'users.name as user',
                'stok as jml_sistem',
            )
            ->selectRaw('count(DISTINCT id_obat) as jml_jenis_obat')
            ->selectRaw('CASE WHEN status = "A" THEN sum(jml) ELSE 0 END as jml_opname')
            ->selectRaw('substr(max(CONCAT(CAST(uks_opname_stok.created_at AS CHAR), status )), 20) as status')
            ->Join('uks_jenis_obat', 'uks_jenis_obat.id', 'uks_obat.id_jenis_obat')
            ->leftJoin('uks_opname_stok', function ($join) {
                $join->on('uks_opname_stok.id_obat', '=', 'uks_obat.id')
                    ->where('uks_opname_stok.status', '!=', 'D')
                    ->whereNull('uks_opname_stok.deleted_at');
            })
            ->leftJoin('users', 'users.id', 'uks_opname_stok.user_created')
            ->where(function ($query) {
                $query->orWhere('uks_opname_stok.status', '=', 'A')
                    ->orWhere('uks_opname_stok.status', '=', 'C')
                    ->orwhereNull('uks_opname_stok.status');
            })
            ->groupBy('uks_obat.id')
            ->havingRaw('CASE WHEN status = "A" THEN sum(jml) ELSE 0 END > 0 or SUM(stok) > 0')
            ->orderByRaw("FIELD(status, '', 'C', 'A'), SUM(stok) - CASE WHEN status = 'A' THEN sum(jml) ELSE 0 END DESC");

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('selisih', function ($list) {
                $selisih = $list->jml_opname - $list->jml_sistem;
                if ($selisih == 0) {
                    return $selisih;
                } elseif ($selisih > 0) {
                    $flag = 'danger';
                    return '<span class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $selisih . '</span>';
                } else {
                    $flag = 'danger';
                    return '<span class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $selisih . '</span>';
                }
            })
            ->addColumn('keterangan', function ($list) {
                if ($list->status == 'C') {
                    $keterangan = '<span class="badge badge-pill badge-soft-warning font-size-12">Belum Approve Opname</span>';
                } else {
                    if ($list->kode_transaksi) {
                        $selisih = $list->jml_opname - $list->jml_sistem;
                        if ($selisih < 0) {
                            $flag = 'warning';
                            $ket = 'Stok Berlebih';
                            $keterangan = '<span class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $ket . '</span>';
                        } elseif ($selisih > 0) {
                            $flag = 'info';
                            $ket = 'Tambah Stok Manual';
                            $keterangan = '<span class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $ket . '</span>';
                        } else {
                            $keterangan = '<span class="badge badge-pill badge-soft-success font-size-12">Sesuai</span>';
                        }
                    } else {
                        $keterangan = '<span class="badge badge-pill badge-soft-danger font-size-12">Belum Opname</span>';
                    }
                }
                return $keterangan;
            })
            ->addColumn('action', 'uks.opname.button')
            ->rawColumns(['action', 'selisih', 'keterangan'])
            ->make(true);
    }

    public function hitung_komparasi(Request $request)
    {
        DB::beginTransaction();
        try {
            $registration_number = KomparasiModel::pluck('kode_komparasi')->last();
            $no_date = Carbon::now()->format('ymd');
            if (!$registration_number) {
                $kode_komparasi = "KOM" . $no_date . sprintf('%04d', 1);
            } else {
                $last_number = (int)substr($registration_number, 9);
                $moon = (int)substr($registration_number, 5, 2);
                $moon_now = Carbon::now()->format('m');
                if ($moon != $moon_now) {
                    $kode_komparasi = "KOM" . $no_date . sprintf('%04d', 1);
                } else {
                    $kode_komparasi = "KOM" . $no_date . sprintf('%04d', $last_number + 1);
                }
            }

            $list = DB::table('uks_obat')
                ->select(
                    'kode_transaksi',
                    'id_obat',
                    'stok as jml_sistem',
                    'users.id as user',
                    'status',
                )
                ->selectRaw('CASE WHEN status = "A" THEN sum(jml) ELSE 0 END as jml_opname')
                ->leftJoin('uks_opname_stok', 'uks_opname_stok.id_obat', 'uks_obat.id')
                ->leftJoin('users', 'users.id', 'uks_opname_stok.user_created')
                ->whereNull('uks_opname_stok.deleted_at')
                ->Where('uks_opname_stok.status', '=', 'A')
                ->groupBy('uks_obat.id')
                ->orderByRaw("FIELD(status, '', 'C', 'A'), SUM(stok) - CASE WHEN status = 'A' THEN sum(jml) ELSE 0 END DESC")
                ->get();

            foreach ($list as $item) {
                $selisih = $item->jml_opname - $item->jml_sistem;
                if ($item->jml_opname < $item->jml_sistem) {
                    $type_adjust = 'kurang';
                } else {
                    $type_adjust = null;
                }

                $store = new KomparasiModel();
                $store->kode_komparasi = $kode_komparasi; // komparasi stok
                $store->tgl_komparasi = Carbon::now();
                $store->kode_opname = $item->kode_transaksi;
                $store->id_obat = $item->id_obat;
                $store->stok_opname = $item->jml_opname;
                $store->stok_sistem = $item->jml_sistem;
                $store->adjust_stok = abs($selisih);
                $store->type_adjust = $type_adjust;
                $store->user_opname = $item->user;
                $store->user_created = Auth::user()->id;
                $store->save();

                // selisih > 0 atau ($item->jml_opname - $item->jml_sistem) harus tambah stok manual dari admin (jml opname > jml sistem)
                // jika < 0 kurangin sistemnya (jml opname < jml sistem)
                if ($selisih < 0) {
                    // kurang stok obat [uks_obat]
                    $stock = ObatModel::findorfail($item->id_obat);
                    ObatModel::where('id', $item->id_obat)->update(['stok' => $stock->stok - abs($selisih)]);

                    // kurangin stok jml tambah stok di jml_out tabel uks_stok_obat
                    for ($i = 0; $i < abs($selisih); $i++) {
                        $list_stok = DB::table('uks_stok_obat')
                            ->select(
                                'id',
                                'jml',
                                'jml_keluar',
                            )
                            ->whereNull('deleted_at')
                            ->Where('id_obat', '=', $item->id_obat)
                            ->whereRaw('jml-IFNULL(jml_keluar, 0) > 0')
                            ->groupBy('id')
                            ->orderByRaw("tgl_ed ASC")
                            ->limit(1)
                            ->get();
                        foreach ($list_stok as $item_stok) {
                            // pengurangan di stok obat
                            StokObatModel::where('id', $item_stok->id)->update(['jml_keluar' => $item_stok->jml_keluar + 1]);
                        }
                    }
                }

                // update flag opname stok jadi "D"
                OpnameStokModel::where('kode_transaksi', $item->kode_transaksi)->update(['status' => 'D', 'kode_komparasi' => $kode_komparasi]);
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Menyesuaikan Stok Berhasil',
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                'code' => 404,
                'message' => 'Menyesuaikan Stok Gagal',
                'err' => $err,
            ]);
        }
    }
}
