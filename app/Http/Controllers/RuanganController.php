<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Inv_Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'Inventaris';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'ruangan',
            'label' => 'Data Ruangan',
        ];

        $ruangan = Inv_Ruangan::all();
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('83', $session_menu)) {
            return view('inv_ruangan.data', compact('ruangan'))->with($data);
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
            'submenu' => 'ruangan',
            'label' => 'Tambah Ruangan',
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('84', $session_menu)) {
            return view('inv_ruangan.create')->with($data);
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
        DB::beginTransaction();
        try {
            $inv_ruangan = new Inv_ruangan([
                'nama' => $request->nama,
                'user_created' => Auth::user()->id,
            ]);
            $inv_ruangan->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('ruangan');
        } catch (\Throwable $err) {
            DB::rollBack();
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
            'submenu' => 'ruangan',
            'label' => 'Edit Data Ruangan',
            'ruangan' => Inv_Ruangan::findOrFail($id_decrypted)
        ];
        return view('inv_ruangan.edit')->with($data);
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
        DB::beginTransaction();
        try {
            $ruangan = Inv_Ruangan::findOrFail($id)->update([
                'nama' => $request->nama,
                'user_updated' => Auth::user()->id,
            ]);

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('ruangan');
        } catch (\Throwable $err) {
            DB::rollBack();
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
        $id_decrypted = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $ruangan = Inv_Ruangan::where('id', $id_decrypted)->update([
                'user_deleted' => Auth::user()->id,
            ]);
            $ruangan = Inv_Ruangan::findorfail($id_decrypted);
            $ruangan->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }
}
