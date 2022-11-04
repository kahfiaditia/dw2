<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\penerbit;
use Carbon\Carbon;
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('66', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'penerbit',
                'label' => 'data penerbit',
                'lists' => Penerbit::orderBy('id', 'ASC')->get()
            ];
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('67', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'penerbit',
                'label' => 'tambah penerbit',
            ];
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('67', $session_menu)) {
            $request->validate([
                'nama_penerbit' => 'required|unique:perpus_penerbit,nama_penerbit,NULL,id,deleted_at,NULL|max:64',
            ]);
            DB::beginTransaction();
            try {
                $penerbit = new Penerbit();
                $penerbit->nama_penerbit = $request['nama_penerbit'];
                $penerbit->user_created = Auth::user()->id;
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
        if (in_array('68', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'penerbit',
                'label' => 'ubah penerbit',
                'penerbit' => Penerbit::findorfail($id_decrypted)
            ];
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('68', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'nama_penerbit' => "required|max:64|unique:perpus_penerbit,nama_penerbit,$id,id,deleted_at,NULL",
            ]);
            DB::beginTransaction();
            try {
                $penerbit = Penerbit::findOrFail($id);
                $penerbit->nama_penerbit = $request['nama_penerbit'];
                $penerbit->user_updated = Auth::user()->id;
                $penerbit->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('penerbit');
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
        if (in_array('69', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $penerbit = Penerbit::findorfail($id_decrypted);
                $penerbit->user_deleted = Auth::user()->id;
                $penerbit->deleted_at = Carbon::now();
                $penerbit->save();


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
