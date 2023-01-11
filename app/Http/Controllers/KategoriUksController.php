<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\KategoriModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class KategoriUksController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'uks';
    protected $submenu = 'kategori';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('111', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data ' . $this->submenu,
                'data' => KategoriModel::all(),
            ];
            return view('uks.kategori.index')->with($data);
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
        if (in_array('112', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
            ];
            return view('uks.kategori.add')->with($data);
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
        if (in_array('112', $session_menu)) {
            $request->validate([
                'kategori' => 'required|unique:uks_kategori,kategori,NULL,id,deleted_at,NULL|max:64',
            ]);
            DB::beginTransaction();
            try {
                $kategori = new KategoriModel();
                $kategori->kategori = strtoupper($request['kategori']);
                $kategori->user_created = Auth::user()->id;
                $kategori->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('uks/uks_kategori');
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
        if (in_array('113', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'ubah ' . $this->submenu,
                'data' => KategoriModel::findorfail($id_decrypted)
            ];
            return view('uks.kategori.edit')->with($data);
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
        if (in_array('113', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'kategori' => "required|max:64|unique:uks_kategori,kategori,$id,id,deleted_at,NULL",
            ]);
            DB::beginTransaction();
            try {
                $update = KategoriModel::findOrFail($id);
                $update->kategori = strtoupper($request['kategori']);
                $update->user_updated = Auth::user()->id;
                $update->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('uks/uks_kategori');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::updateAlert(false);
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
                $delete = KategoriModel::findorfail($id_decrypted);
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
