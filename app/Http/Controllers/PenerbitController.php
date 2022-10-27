<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PenerbitController extends Controller
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
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'penerbit',
            'label' => 'data penerbit',
            'lists' => Penerbit::orderBy('id', 'ASC')->get()
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('66', $session_menu)) {
            return view('penerbit.list_penerbit')->with($data);
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
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'penerbit',
            'label' => 'tambah penerbit',
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('67', $session_menu)) {
            return view('penerbit.add_penerbit')->with($data);
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
        $request->validate([
            'nama_penerbit' => 'required|unique:perpus_penerbit,nama_penerbit,NULL,id,deleted_at,NULL|max:64',
        ]);
        DB::beginTransaction();
        try {
            $penerbit = new Penerbit();
            $penerbit->nama_penerbit = $request['nama_penerbit'];
            $penerbit->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('penerbit');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
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
            'submenu' => 'penerbit',
            'label' => 'ubah penerbit',
            'penerbit' => Penerbit::findorfail($id_decrypted)
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('68', $session_menu)) {
            return view('penerbit.edit_penerbit')->with($data);
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
        $id = Crypt::decryptString($id);
        $request->validate([
            'nama_penerbit' => "required|max:64|unique:perpus_penerbit,nama_penerbit,$id,id,deleted_at,NULL",
        ]);
        DB::beginTransaction();
        try {
            $penerbit = Penerbit::findOrFail($id);
            $penerbit->nama_penerbit = $request['nama_penerbit'];
            $penerbit->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('penerbit');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            return back();
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
        if (in_array('69', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $penerbit = Penerbit::findorfail($id_decrypted);
                $penerbit->delete();

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

    public function dropdown()
    {
        $penerbit = Penerbit::all();
        return $penerbit;
    }
}
