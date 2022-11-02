<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index()
    {

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'inventaris',
            'label' => 'Data Inventaris',
        ];
        $inventaris = Inventaris::all();
        return view('inventaris.data', compact('inventaris'))->with($data);
        // dd($inventaris);
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
            'label' => 'Tambah Inventaris',
        ];

        return view('inventaris.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inventaris = new Inventaris([
            'nama' => $request->name,
            'nomor_inventaris' => $request->owner,
            'id_barang' => $request->desc,
            'indikasi' => $request->qty,
            'pemilik' => $request->status,
            'deskripsi' => $request->status,
            'qty' => $request->status,
            'status' => $request->status,
            'user_created' => $request->status,
            'user_updated' => $request->status,
            'user_deleted' => Auth::user()->id,
        ]);

        $inventaris->save();

        return redirect('inventaris');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function show(Inventaris $inventaris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventaris $inventaris, $id)
    {

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'inventaris',
            'label' => 'Edit Inventaris',
            'inventaris' => Inventaris::find($id),
        ];
        // $inventaris = Inventaris::find($id);
        return view('inventaris.edit')->with($data);
        // dd($inventaris);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        Inventaris::where('id', $id)
            ->update([
                'nama' => $request->nama,
                'nomor_inventaris' => $request->nomor_inventaris,
                'idbarang' => $request->idbarang,
                'ruangan' => $request->ruangan,
                'qty' => $request->qty,
                'status' => $request->status,
                'indikasi' => $request->indikasi,
                'pemilik' => $request->pemilik,
                'desc' => $request->desc,
                'user_created' => Auth::user()->id,
                'user_updated' => Auth::user()->id,
                'user_deleted' => Auth::user()->id,
            ]);

        return redirect('inventaris');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventaris $inventaris)
    {
        //
    }
}
