<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kebutuhan_khusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class NeedsController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Kebutuhan Khusus';

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
            'submenu' => $this->submenu,
            'label' => ' data Kebutuhan Khusus',
            'lists' => Kebutuhan_khusus::all()
        ];
        return view('needs.list')->with($data);
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
            'submenu' => 'kebutuhan khusus',
            'label' => 'tambah kebutuhan khusus',
        ];
        return view('needs.add')->with($data);
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
            'kode' => 'required|unique:kebutuhan_khusus|max:64',
            'nama' => 'required|max:64',
        ]);
        DB::beginTransaction();
        try {
            $needs = new Kebutuhan_khusus();
            $needs->kode = $request->kode;
            $needs->nama = $request->nama;
            $needs->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('needs');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
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
            'submenu' => 'kebutuhan khusus',
            'label' => 'edit kebutuhan khusus',
            'needs' => Kebutuhan_khusus::findorfail($id_decrypted)
        ];
        return view('needs.edit')->with($data);
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
        $request->validate([
            'kode' => 'required|max:64|unique:kebutuhan_khusus,kode,' . $request->id,
            'nama' => 'required|max:64',
        ]);
        DB::beginTransaction();
        try {
            $needs = Kebutuhan_khusus::findorfail($request->id);
            $needs->kode = $request->kode;
            $needs->nama = $request->nama;
            $needs->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('needs');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
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
            $needs = Kebutuhan_khusus::findorfail($id_decrypted);
            $needs->delete();

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
