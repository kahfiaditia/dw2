<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Agama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AgamaController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

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
            'submenu' => 'agama',
            'label' => 'data agama',
            'lists' => Agama::all()
        ];
        return view('agama.list_agama')->with($data);
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
            'submenu' => 'agama',
            'label' => 'tambah agama',
        ];
        return view('agama.add_agama')->with($data);
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
            'agama' => 'required|unique:agama|max:64',
        ]);
        DB::beginTransaction();
        try {
            $agama = new Agama();
            $agama->agama = $request->Agama;
            $agama->aktif = '1';
            $agama->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('agama');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agama  $agama
     * @return \Illuminate\Http\Response
     */
    public function show(Agama $agama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agama  $agama
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'agama',
            'label' => 'ubah agama',
            'agama' => Agama::findorfail($id_decrypted)
        ];
        return view('agama.edit_agama')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agama  $agama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agama $agama)
    {
        $request->validate([
            'agama' => 'required|max:64|unique:agama,agama,'.$request->id,
        ]);
        DB::beginTransaction();
        try {
            $agama = Agama::findorfail($request->id);
            $agama->agama = $request->agama;
            $agama->aktif = isset($request->aktif) ? 1 : 0;
            $agama->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('agama');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agama  $agama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $agama = Agama::findorfail($id_decrypted);
            $agama->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function dropdown()
    {
        $agama = Agama::select('id','agama')->where('aktif','1')->get();
        return $agama;
    }
}
