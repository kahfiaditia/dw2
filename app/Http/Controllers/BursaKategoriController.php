<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\AlertHelper;
use App\Models\BursaKategori;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BursaKategoriController extends Controller
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('139', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Kategori',
                'label' => 'data Kategori',
                'kategori' => BursaKategori::all()
            ];
            return view('bursa.bursa_kategori.list')->with($data);
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
        if (in_array('140', $session_menu)) {

            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Kategori',
                'label' => 'data Kategori',
            ];
            return view('bursa.bursa_kategori.add')->with($data);
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
        if (in_array('140', $session_menu)) {
            $request->validate([
                'nama' => 'required',
            ]);

            DB::beginTransaction();

            try {
                $satuan = new BursaKategori();
                $satuan->nama = strtoupper($request['nama']);
                $satuan->status = 1;
                $satuan->user_created = Auth::user()->id;
                $satuan->save();


                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/bursa_kategori');
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
        if (in_array('141', $session_menu)) {

            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'Kategori',
                'label' => 'data Kategori',
                'kategori' => BursaKategori::findORFail(
                    $id_decrypted
                )
            ];
            return view('bursa.bursa_kategori.edit')->with($data);
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
        if (in_array('141', $session_menu)) {
            $request->validate([
                'nama' => 'required',
            ]);

            $id = Crypt::decryptString($id);
            DB::beginTransaction();

            try {
                $kategori = BursaKategori::findORfail($id);
                $kategori->nama = strtoupper($request['nama']);
                $kategori->status = isset($request['status1']) ? 1 : 0;
                $kategori->user_updated = Auth::user()->id;
                $kategori->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/bursa_kategori');
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
        if (in_array('142', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $delete = BursaKategori::findorfail($id_decrypted);
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
