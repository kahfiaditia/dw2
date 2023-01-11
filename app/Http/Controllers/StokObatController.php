<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\KategoriModel;
use App\Models\ObatModel;
use App\Models\StokObatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StokObatController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = 'tambah stok';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('96', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data ' . $this->submenu,
            ];
            return view('uks.stok.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function stok_list(Request $request)
    {
        // querynya
        $list = DB::table('uks_stok_obat')
            ->select(
                'kode_transaksi',
                'uks_stok_obat.created_at',
                'users.name as user'
            )
            ->selectRaw('count(DISTINCT id_obat) as jml_jenis_obat')
            ->selectRaw('SUM(jml) as jml')
            ->selectRaw("GROUP_CONCAT(DISTINCT tgl_ed SEPARATOR ', ') as ed")
            ->Join('users', 'users.id', 'uks_stok_obat.user_created')
            ->whereNull('uks_stok_obat.deleted_at')
            ->groupBy('uks_stok_obat.kode_transaksi')
            ->orderBy('uks_stok_obat.kode_transaksi', 'DESC');

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('action', 'uks.stok.button')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('97', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
                // 'obat' => ObatModel::all(),
                'kategori' => KategoriModel::all(),
            ];
            return view('uks.stok.add')->with($data);
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
        if (in_array('97', $session_menu)) {
            DB::beginTransaction();
            try {
                $registration_number = StokObatModel::pluck('kode_transaksi')->last();
                $no_date = Carbon::now()->format('ymd');
                if (!$registration_number) {
                    $no_stok = "STK" . $no_date . sprintf('%04d', 1);
                } else {
                    $last_number = (int)substr($registration_number, 9);
                    $moon = (int)substr($registration_number, 5, 2);
                    $moon_now = Carbon::now()->format('m');
                    if ($moon != $moon_now) {
                        $no_stok = "STK" . $no_date . sprintf('%04d', 1);
                    } else {
                        $no_stok = "STK" . $no_date . sprintf('%04d', $last_number + 1);
                    }
                }

                $created_at = Carbon::now();
                for ($i = 0; $i < count($request->data_post); $i++) {
                    $store = new StokObatModel();
                    $store->kode_transaksi = $no_stok;
                    $store->id_obat = $request->data_post[$i]['id_obat'];
                    $store->tgl_ed = $request->data_post[$i]['tanggal'];
                    $store->jml = $request->data_post[$i]['jumlah'];
                    $store->keterangan = $request->data_post[$i]['keterangan'];
                    $store->user_created = Auth::user()->id;
                    $store->created_at = $created_at;
                    $store->save();

                    $stock = ObatModel::findorfail($request->data_post[$i]['id_obat']);
                    ObatModel::where('id', $request->data_post[$i]['id_obat'])->update(['stok' => $stock->stok + $request->data_post[$i]['jumlah']]);
                }

                DB::commit();

                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil Tambah Stok',
                ]);
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal Tambah Stok',
                ]);
            }
        } else {
            return view('not_found');
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
        if (in_array('96', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'lihat ' . $this->submenu,
                'data' => StokObatModel::where('kode_transaksi', $id_decrypted)->get(),
            ];
            return view('uks.stok.show')->with($data);
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
        if (in_array('98', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'ubah ' . $this->submenu,
                'obat' => ObatModel::all(),
                'data' => StokObatModel::where('kode_transaksi', $id_decrypted)->get(),
            ];
            return view('uks.stok.edit')->with($data);
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
        if (in_array('98', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'obat' => 'required',
                'tanggal' => 'required',
                'jumlah' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $update = StokObatModel::findOrFail($id);
                $update->id_obat = $request['obat'];
                $update->tgl_ed = $request['tanggal'];
                $update->jml = $request['jumlah'];
                $update->keterangan = $request->keterangan;
                $update->user_updated = Auth::user()->id;
                $update->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('uks/stok_obat');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
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
        if (in_array('99', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {

                $stok = StokObatModel::where('kode_transaksi', $id_decrypted)->get();
                foreach ($stok as $value) {
                    $stock = ObatModel::findorfail($value->id_obat);
                    ObatModel::where('id', $value->id_obat)->update(['stok' => $stock->stok - $value->jml]);
                }
                StokObatModel::where('kode_transaksi', $id_decrypted)->update(['user_deleted' => Auth::user()->id, 'deleted_at' => Carbon::now()]);

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

    public function destroy_id(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('98', $session_menu)) {
            $variabel = Crypt::decryptString($id);
            $dat = explode("|", $variabel);
            $id_decrypted = $dat[0];
            $kode_transaksi = $dat[1];

            DB::beginTransaction();
            try {
                $delete = StokObatModel::findorfail($id_decrypted);
                // update stock
                $stock = ObatModel::findorfail($delete->id_obat);
                ObatModel::where('id', $stock->id)->update(['stok' => $stock->stok - $delete->jml]);
                // delete pinjaman
                $delete->user_deleted = Auth::user()->id;
                $delete->deleted_at = Carbon::now();
                $delete->save();

                DB::commit();
                AlertHelper::deleteAlert(true);

                $count = StokObatModel::where('kode_transaksi', $kode_transaksi)->count();
                if ($count == 0) {
                    return redirect('uks/stok_obat');
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

    public function store_edit(Request $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->data_post); $i++) {

                $store = new StokObatModel();
                $store->kode_transaksi = $request->kode_transaksi;
                $store->id_obat = $request->data_post[$i]['obat_id'];
                $store->tgl_ed = $request->data_post[$i]['tanggal'];
                $store->jml = $request->data_post[$i]['jml_obat'];
                $store->keterangan = $request->data_post[$i]['keterangan'];
                $store->user_created = Auth::user()->id;
                $store->created_at = Carbon::now();
                $store->save();

                $stock = ObatModel::findorfail($request->data_post[$i]['obat_id']);
                ObatModel::where('id', $request->data_post[$i]['obat_id'])->update(['stok' => $stock->stok + $request->data_post[$i]['jml_obat']]);
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Tambah Stok',
                'kode_transaksi' => Crypt::encryptString($request->kode_transaksi),
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Tambah Stok',
            ]);
        }
    }

    public function get_obat_id(Request $request)
    {
        $obat = DB::table('uks_obat')
            ->select('*')
            ->where('stok', $request->id_kategori)
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
}
