<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\ObatModel;
use App\Models\OpnameStokModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OpnameObatController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = 'opname';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('104', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data opname',
            ];
            return view('uks.opname.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function opname_list(Request $request)
    {
        // querynya
        $list = DB::table('uks_opname_stok')
            ->select(
                'kode_transaksi',
                'tgl_opname',
                'uks_opname_stok.created_at',
                'users.name as user',
                'status',
            )
            ->selectRaw('count(DISTINCT id_obat) as jml_jenis_obat')
            ->selectRaw('SUM(jml) as jml')
            ->Join('users', 'users.id', 'uks_opname_stok.user_created')
            ->whereNull('uks_opname_stok.deleted_at')
            ->groupBy('uks_opname_stok.kode_transaksi')
            ->orderBy('uks_opname_stok.kode_transaksi', 'DESC');

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('status', function ($model) {
                if ($model->status == 'C') {
                    $status = 'Create';
                    $flag = 'info';
                } elseif ($model->status == 'A') {
                    $status = 'Approve';
                    $flag = 'warning';
                } elseif ($model->status == 'D') {
                    $status = 'Done';
                    $flag = 'success';
                }
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'uks.opname.button')
            ->rawColumns(['status', 'action'])
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
        if (in_array('105', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
                'obat' => ObatModel::all(),
            ];
            return view('uks.opname.add')->with($data);
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
        if (in_array('105', $session_menu)) {
            DB::beginTransaction();
            try {
                $registration_number = OpnameStokModel::pluck('kode_transaksi')->last();
                $no_date = Carbon::now()->format('ymd');
                if (!$registration_number) {
                    $no_stok = "OPN" . $no_date . sprintf('%04d', 1);
                } else {
                    $last_number = (int)substr($registration_number, 9);
                    $moon = (int)substr($registration_number, 5, 2);
                    $moon_now = Carbon::now()->format('m');
                    if ($moon != $moon_now) {
                        $no_stok = "OPN" . $no_date . sprintf('%04d', 1);
                    } else {
                        $no_stok = "OPN" . $no_date . sprintf('%04d', $last_number + 1);
                    }
                }

                $created_at = Carbon::now();
                for ($i = 0; $i < count($request->data_post); $i++) {
                    $store = new OpnameStokModel();
                    $store->kode_transaksi = $no_stok;
                    $store->tgl_opname = $request->data_post[$i]['tanggal'];
                    $store->id_obat = $request->data_post[$i]['id_obat'];
                    $store->jml = $request->data_post[$i]['jumlah'];
                    $store->status = 'C';
                    $store->user_created = Auth::user()->id;
                    $store->created_at = $created_at;
                    $store->save();
                }

                DB::commit();

                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil Opname',
                ]);
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal Opname',
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
        if (in_array('104', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'lihat ' . $this->submenu,
                'data' => OpnameStokModel::where('kode_transaksi', $id_decrypted)->get(),
            ];
            return view('uks.opname.show')->with($data);
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
        if (in_array('106', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'ubah ' . $this->submenu,
                'obat' => ObatModel::all(),
                'data' => OpnameStokModel::where('kode_transaksi', $id_decrypted)->get(),
            ];
            return view('uks.opname.edit')->with($data);
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
        if (in_array('106', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'obat' => "required|max:64|unique:uks_obat,obat,$id,id,deleted_at,NULL",
                'jenis' => 'required|max:64',
            ]);
            DB::beginTransaction();
            try {
                $rak = ObatModel::findOrFail($id);
                $rak->obat = $request['obat'];
                $rak->id_jenis_obat = $request['jenis'];
                $rak->user_updated = Auth::user()->id;
                $rak->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('uks/obat');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function opname_store(Request $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->data_post); $i++) {

                $store = new OpnameStokModel();
                $store->kode_transaksi = $request->kode_transaksi;
                $store->id_obat = $request->data_post[$i]['obat_id'];
                $store->tgl_opname = $request->data_post[$i]['tanggal'];
                $store->jml = $request->data_post[$i]['jml_obat'];
                $store->status = 'C';
                $store->user_created = Auth::user()->id;
                $store->created_at = Carbon::now();
                $store->save();
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Opname',
                'kode_transaksi' => Crypt::encryptString($request->kode_transaksi),
            ]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Opname',
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
        if (in_array('107', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {

                OpnameStokModel::where('kode_transaksi', $id_decrypted)->update(['user_deleted' => Auth::user()->id, 'deleted_at' => Carbon::now()]);

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

    public function opname_destroy_id(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('106', $session_menu)) {
            $variabel = Crypt::decryptString($id);
            $dat = explode("|", $variabel);
            $id_decrypted = $dat[0];
            $kode_transaksi = $dat[1];

            DB::beginTransaction();
            try {
                $delete = OpnameStokModel::findorfail($id_decrypted);
                $delete->user_deleted = Auth::user()->id;
                $delete->deleted_at = Carbon::now();
                $delete->save();

                DB::commit();
                AlertHelper::deleteAlert(true);

                $count = OpnameStokModel::where('kode_transaksi', $kode_transaksi)->count();
                if ($count == 0) {
                    return redirect('uks/opname_obat');
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

    public function approve_opname(Request $request, $kode, $type)
    {
        DB::beginTransaction();
        try {

            OpnameStokModel::where('kode_transaksi', $kode)->update(['status' => $type]);

            DB::commit();
            AlertHelper::updateAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            return back();
        }
    }
}
