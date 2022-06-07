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
            'submenu' => 'siswa',
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
            'no_kk' => 'required|unique:siswa',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'golongan_darah' => 'required',
            'akta_lahir' => 'required',
            'agama' => 'required',
            'alamat_jalan' => 'required',
            'email' => 'required',
            'no_handphone' => 'required',
            'kewarganegaraan' => 'required',
            'kebutuhan_khusus' => 'required',
            'nama_negara' => 'required',
            'tempat_tinggal' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'nama_dusun' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
            'moda_transportasi' => 'required',
            'anak_keberapa' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Siswa::create([
                'nisn' => $validated['nisn'],
                'nik' => $validated['nik'],
                'no_kk' => $validated['no_kk'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'golongan_darah' => $validated['golongan_darah'],
                'no_registrasi_akta_lahir' => $validated['akta_lahir'],
                'agama_id' => $validated['agama'],
                'alamat' => $validated['alamat_jalan'],
                'email' => $validated['email'],
                'no_handphone' => $validated['no_handphone'],
                'kewarganegaraan' => $validated['kewarganegaraan'],
                'nama_negara' => $validated['nama_negara'],
                'kebutuhan_khusus_id' => $validated['kebutuhan_khusus']
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return back();
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
