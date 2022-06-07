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

    public function index()
    {
        $special_needs = Kebutuhan_khusus::orderBy('id', 'DESC')->get();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data kebutuhan khusus',
            'special_needs' => $special_needs
        ];

        return view('needs.index')->with($data);
    }

    public function create()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'kebutuhan khusus',
            'label' => 'tambah kebutuhan khusus',
        ];
        return view('needs.crete')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:kebutuhan_khusus,kode,NULL,id,deleted_at,NULL|min:2',
            'nama' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Kebutuhan_khusus::create([
                'kode' => $validated['kode'],
                'nama' => $validated['nama']
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('specialneeds');
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $special_need = Kebutuhan_khusus::findOrFail(Crypt::decryptString($id));

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->sub_menu,
            'label' => 'Edit kebutuhan khusus',
            'special_need' => $special_need
        ];

        return view('needs.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $validated = $request->validate([
            'kode' => "required|min:2|unique:kebutuhan_khusus,kode,$decrypted_id,id,deleted_at,NULL",
            'nama' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $special_need = Kebutuhan_khusus::findOrFail($decrypted_id);
            $special_need->kode = $validated['kode'];
            $special_need->nama = $validated['nama'];
            $special_need->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('specialneeds');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $special_need = Kebutuhan_khusus::findOrFail(Crypt::decryptString($id));
            $special_need->delete();
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
