<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kebutuhan_khusus;
use App\Models\Parents;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ParentController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index(Request $request)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'orang tua',
            'label' => 'data orang tua / wali'
        ];

        $parents = Parents::with('student')->orderBy('id', 'DESC')->get();

        if ($request->ajax()) {
            return DataTables::of($parents)
                ->addIndexColumn()
                ->addColumn('Opsi', function (Parents $parents) {
                    return \view('parents.button', compact('parents'));
                })
                ->rawColumns(['Opsi', 'status'])
                ->make(true);
        } else {
            return view('parents.index')->with($data);
        }
    }

    public function create()
    {
        $students = Siswa::doesntHave('parents')->orderBy('id', 'DESC')->get();
        $special_needs = Kebutuhan_khusus::orderBy('id', 'DESC')->get();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'parent',
            'label' => 'tambah orang tua',
            'students' => $students,
            'special_needs' => $special_needs
        ];

        return view('parents.create')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik_ayah' => 'required|unique:wali,nik,NULL,id,deleted_at,NULL',
            'nik_ibu_kandung' => 'required|unique:wali,nik,NULL,id,deleted_at,NULL',
            'nik_wali' => 'required|unique:wali,nik,NULL,id,deleted_at,NULL'
        ]);
        DB::beginTransaction();
        try {
            // Data Ayah
            Parents::create([
                'nik' => $validated['nik_ayah'],
                'name' => $request->nama_ayah_kandung,
                'tanggal_lahir' => $request->tanggal_lahir_ayah,
                'no_hp' => $request->no_handphone_ayah,
                'pendidikan' => $request->pendidikan_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'penghasilan' => $request->penghasilan_ayah,
                'type' => 'Ayah',
                'status' => 'Orang Tua',
                'kebutuhan_khusus_id' => $request->kebutuhan_khusus,
                'siswa_id' => $request->siswa_id
            ]);

            // Data Ibu
            Parents::create([
                'nik' => $validated['nik_ibu_kandung'],
                'name' => $request->nama_ibu_kandung,
                'tanggal_lahir' => $request->tanggal_lahir_ibu_kandung,
                'no_hp' => $request->no_handphone_ibu_kandung,
                'pendidikan' => $request->pendidikan_ibu_kandung,
                'pekerjaan' => $request->pekerjaan_ibu_kandung,
                'penghasilan' => $request->penghasilan_ibu_kandung,
                'type' => 'Ibu',
                'status' => 'Orang Tua',
                'kebutuhan_khusus_id' => $request->kebutuhan_khusus_ibu,
                'siswa_id' => $request->siswa_id
            ]);

            // Data Wali
            if ($request->wali_added != null) {
                Parents::create([
                    'nik' => $validated['nik_wali'],
                    'name' => $request->nama_wali,
                    'tanggal_lahir' => $request->tanggal_lahir_wali,
                    'no_hp' => $request->no_handphone_wali,
                    'pendidikan' => $request->pendidikan_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'penghasilan' => $request->penghasilan_wali,
                    'type' => 'Wali',
                    'status' => 'Wali',
                    'kebutuhan_khusus_id' => $request->kebutuhan_khusus,
                    'siswa_id' => $request->siswa_id
                ]);
            }
            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
