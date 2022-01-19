<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Kebutuhan_khusus;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\AlertHelper;

class SiswaController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'siswa',
            'label' => 'data siswa',
            'lists' => Siswa::orderBy('id', 'DESC')->get()
        ];

        return view('siswa.index')->with($data);
    }

    public function create()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'agama',
            'label' => 'tambah siswa',
            'religions' => Agama::orderBy('id', 'DESC')->get(),
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get()
        ];

        return view('siswa.create')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|unique:siswa',
            'nik' => 'required|unique:siswa',
            'no_kk' => 'unique:siswa'
        ]);

        DB::beginTransaction();
        try {
            Siswa::create([
                'nisn' => $validated['nisn'],
                'nik' => $validated['nik'],
                'no_kk' => $validated['no_kk'],
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'golongan_darah' => $request->golongan_darah,
                'no_registrasi_akta_lahir' => $request->no_registrasi_akta_lahir,
                'agama_id' => $request->agama,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'no_handphone' => $request->no_handphone,
                'kewarganegaraan' => $request->kewarganegaraan,
                'nama_negara' => $request->nama_negara,
                'kebutuhan_khusus_id' => $request->kebutuhan_khusus
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('siswa');
        } catch (\Throwable $err) {
            DB::rollBack();
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
