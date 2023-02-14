<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\AlertHelper;
use App\Models\BursaSatuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BursaSatuanController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'Bursa';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Satuan',
            'label' => 'data Satuan',
            'satuan' => BursaSatuan::all()
        ];
        return view('bursa.bursa_satuan.data')->with($data);
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
            'submenu' => 'Satuan',
            'label' => 'data Satuan',
        ];
        return view('bursa.bursa_satuan.tambah')->with($data);
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
        if (in_array('59', $session_menu)) {
            $request->validate([
                'nama' => 'required',
                'status' => 'required',
            ]);

            DB::beginTransaction();

            try {
                $satuan = new BursaSatuan();
                $satuan->nama = strtoupper($request['nama']);
                $satuan->status = strtoupper($request['status']);
                $satuan->user_created = Auth::user()->id;
                $satuan->save();


                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/satuan');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::addAlert(false);
                return back();
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
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Satuan',
            'label' => 'data Satuan',
            'satuan' => BursaSatuan::findORFail(
                $id_decrypted
            )
        ];
        return view('bursa.bursa_satuan.ubah')->with($data);
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
        if (in_array('59', $session_menu)) {
            $request->validate([
                'nama' => 'required',
                'status' => 'required',
            ]);

            $id = Crypt::decryptString($id);
            DB::beginTransaction();

            try {
                $satuan = BursaSatuan::findORfail($id);
                $satuan->nama = strtoupper($request['nama']);
                $satuan->status = strtoupper($request['status']);
                $satuan->user_updated = Auth::user()->id;
                $satuan->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/satuan');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::addAlert(false);
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
        if (in_array('114', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $delete = BursaSatuan::findorfail($id_decrypted);
                $delete->user_deleted = Auth::user()->id;
                $delete->deleted_at = Carbon::now();
                $delete->save();

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
