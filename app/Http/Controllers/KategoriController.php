<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
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
        if (in_array('58', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'kategori',
                'label' => 'data kategori',
                'lists' => Kategori::orderBy('id', 'ASC')->get()
            ];
            return view('kategori.list_kategori')->with($data);
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
        if (in_array('59', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'kategori',
                'label' => 'tambah kategori',
            ];
            return view('kategori.add_kategori')->with($data);
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
        if (in_array('59', $session_menu)) {
            $request->validate([
                'kode_kategori' => 'required|unique:perpus_kategori_buku,kode_kategori,NULL,id,deleted_at,NULL|max:4',
                'kategori' => 'required|unique:perpus_kategori_buku,kategori,NULL,id,deleted_at,NULL|max:64',
            ]);
            DB::beginTransaction();
            try {
                $kategori = new Kategori();
                $kategori->kode_kategori = strtoupper($request['kode_kategori']);
                $kategori->kategori = strtoupper($request['kategori']);
                $kategori->user_created = Auth::user()->id;
                $kategori->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('kategori');
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
        if (in_array('60', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'kategori',
                'label' => 'ubah kategori',
                'kategori' => Kategori::findorfail($id_decrypted)
            ];
            return view('kategori.edit_kategori')->with($data);
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
        if (in_array('60', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'kode_kategori' => "required|max:4|unique:perpus_kategori_buku,kode_kategori,$id,id,deleted_at,NULL",
                'kategori' => "required|max:64|unique:perpus_kategori_buku,kategori,$id,id,deleted_at,NULL",
            ]);
            DB::beginTransaction();
            try {
                $kategori = Kategori::findOrFail($id);
                $kategori->kode_kategori = strtoupper($request['kode_kategori']);
                $kategori->kategori = strtoupper($request['kategori']);
                $kategori->user_updated = Auth::user()->id;
                $kategori->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('kategori');
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
        if (in_array('61', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $kategori = Kategori::findorfail($id_decrypted);
                $kategori->user_deleted = Auth::user()->id;
                $kategori->deleted_at = Carbon::now();
                $kategori->save();

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
        $kategori = Kategori::all();
        return $kategori;
    }

    public function get_kode(Request $request)
    {
        $kategori = Kategori::findorfail($request->kategoriId);
        return $kategori;
    }
}
