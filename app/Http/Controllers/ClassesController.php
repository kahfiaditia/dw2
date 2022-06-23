<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Kelas';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::orderBy('id', 'DESC')->get();
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data Kelas',
            'classes' => $classes
        ];

        return view('classes.index')->with($data);
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
            'submenu' => $this->submenu,
            'label' => 'tambah Kelas',
            'jurusan' => ['TK', 'SD', 'SMP', 'SMA', 'SMK'],
        ];
        return view('classes.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenjang' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Classes::create([
                'jenjang' => $validated['jenjang'],
                'jurusan' => $validated['jurusan'],
                'class' => $validated['kelas'],
                'type' => $request->type
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('classes');
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
        $classes = Classes::findOrFail(Crypt::decryptString($id));
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'Edit bills',
            'classes' => $classes,
            'jurusan' => ['TK', 'SD', 'SMP', 'SMA', 'SMK'],
        ];
        return view('classes.edit')->with($data);
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
        $decrypted_id = Crypt::decryptString($id);
        $validated = $request->validate([
            'jenjang' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $classes = Classes::findOrFail($decrypted_id);
            $classes->jenjang = $validated['jenjang'];
            $classes->jurusan = $validated['jurusan'];
            $classes->class = $validated['kelas'];
            $classes->type = $request->type;
            $classes->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('classes');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
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
        DB::beginTransaction();
        try {
            $delete = Classes::findOrFail(Crypt::decryptString($id));
            $delete->delete();
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
