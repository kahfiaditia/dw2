<?php

namespace App\Http\Controllers;

use App\Models\Inv_Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $ruangan = DB::table('inv_ruangan')->get();

        return view('inv_ruangan.data', compact('ruangan'))->with($data);
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
            'label' => 'Input Data Ruangan',
        ];

        // dd($data);
        return view('inv_ruangan.create')->with($data);
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
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'ruangan',
            'label' => 'Edit Data Ruangan',
        ];
        $ruangan = Inv_Ruangan::find($id);
        return view('inv_ruangan.edit', compact('ruangan'))->with($data);
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
        Inv_Ruangan::where('id', $id)
            ->update([
                'nama' => $request->nama,
                'user_created' => Auth::user()->id,
                'user_updated' => Auth::user()->id,
            ]);

        return redirect('ruangan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
