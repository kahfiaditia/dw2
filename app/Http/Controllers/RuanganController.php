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
    protected $menu = 'Ruangan';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'ruangan',
            'label' => 'Data Ruangan',
        ];
        // $ruangan = DB::table('inv_ruangan')->get();
        // $ruangan = Inv_Ruangan::onlyTrashed()->get();
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
        // dd($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inv_ruangan = new Inv_ruangan([
            'nama' => $request->nama,
            'user_created' => Auth::user()->id,
        ]);
        $inv_ruangan->save();
        return redirect('ruangan');
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
        // $ruangan = Inv_Ruangan::find($id);
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
        // Inv_Ruangan::where('id', $id)
        //     ->update([
        //         'nama' => $request->nama,
        //         'user_created' => Auth::user()->id,
        //         'user_updated' => Auth::user()->id,
        //     ]);

        // return redirect('ruangan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $ruangan = Inv_Ruangan::find($id);
        // Inv_Ruangan::where('id', $id)
        //     ->update([
        //         'user_deleted' => Auth::user()->id,
        //     ]);

        // $ruangan->delete($id);
        // return redirect('ruangan');  

        $id_decrypted = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $ruangan = Inv_Ruangan::where('id', $id_decrypted)->update([
                'user_deleted' => Auth::user()->id,
            ]); {
                $ruangan = Inv_Ruangan::findorfail($id_decrypted);
                $ruangan->delete();
            }
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
