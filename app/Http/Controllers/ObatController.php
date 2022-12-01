<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\JenisObatModel;
use App\Models\ObatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = 'obat';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('92', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data obat',
                'obat' => ObatModel::all(),
            ];
            return view('uks.obat.index')->with($data);
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
        if (in_array('93', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
                'jenis_obat' => JenisObatModel::all(),
            ];
            return view('uks.obat.add')->with($data);
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
        if (in_array('93', $session_menu)) {
            $request->validate([
                'obat' => 'required|unique:uks_obat,obat,NULL,id,deleted_at,NULL|max:64',
                'jenis' => 'required|max:64',
            ]);
            DB::beginTransaction();
            try {
                $rak = new ObatModel();
                $rak->obat = $request['obat'];
                $rak->id_jenis_obat = $request['jenis'];
                $rak->user_created = Auth::user()->id;
                $rak->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('uks/obat');
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('94', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'ubah ' . $this->submenu,
                'jenis_obat' => JenisObatModel::all(),
                'data' => ObatModel::findorfail($id_decrypted)
            ];
            return view('uks.obat.edit')->with($data);
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
        if (in_array('94', $session_menu)) {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('95', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $rak = ObatModel::findorfail($id_decrypted);
                $rak->user_deleted = Auth::user()->id;
                $rak->deleted_at = Carbon::now();
                $rak->save();

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
