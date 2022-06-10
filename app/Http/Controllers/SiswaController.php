<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Kebutuhan_khusus;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\AlertHelper;
use Yajra\DataTables\DataTables;
use App\Models\Kodepos;
use App\Models\Parents;

class SiswaController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index(Request $request)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'siswa',
            'label' => 'data siswa'
        ];

        $students = Siswa::orderBy('id', 'DESC')->get();

        if ($request->ajax()) {
            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('Opsi', function (Siswa $students) {
                    return \view('siswa.button', compact('students'));
                })
                ->rawColumns(['Opsi', 'status'])
                ->make(true);
        } else {
            return view('siswa.index')->with($data);
        }
    }

    public function create()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'siswa',
            'label' => 'tambah siswa',
            'religions' => Agama::orderBy('id', 'DESC')->get(),
            'districts' => Kodepos::select('kecamatan')->groupBy('kecamatan')->get(),
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
            'email' => 'required|email|unique:siswa,email',
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
                'kebutuhan_khusus_id' => $validated['kebutuhan_khusus'],
                'tempat_tinggal' => $validated['tempat_tinggal'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'dusun' => $validated['nama_dusun'],
                'district' => $validated['kecamatan'],
                'village' => $validated['kelurahan'],
                'postal_code' => $validated['kode_pos'],
                'transportation' => $validated['moda_transportasi'],
                'child_order' => $validated['anak_keberapa'],
                'is_have_kip' => $request->is_have_kip,
                'is_receive_kip' => $request->is_receive_kip,
                'reason_reject_kip' => $request->reason_reject_kip
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('parents/create');
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function show($id)
    {
        $student = Siswa::with('religion', 'special_need')->findOrFail($id);

        $father = Parents::with('special_need')->where([
            ['type', '=', 'Ayah'],
            ['siswa_id', '=', $id]
        ])->first();

        $mother = Parents::with('special_need')->where([
            ['type', '=', 'Ibu'],
            ['siswa_id', '=', $id]
        ])->first();

        $guardian = Parents::with('special_need')->where([
            ['type', '=', 'Wal'],
            ['siswa_id', '=', $id]
        ])->first();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'siswa',
            'label' => 'tambah siswa',
            'student' => $student,
            'father' => $father,
            'mother' => $mother,
            'guardian' => $guardian
        ];

        return view('siswa.detail')->with($data);
    }

    public function edit($id)
    {
        $student = Siswa::findOrFail($id);

        $blood_types = [
            [
                'name' => 'A',
                'value' => 'A'
            ],
            [
                'name' => 'B',
                'value' => 'B'
            ],
            [
                'name' => 'AB',
                'value' => 'AB'
            ],
            [
                'name' => 'O',
                'value' => 'O'
            ]
        ];

        $residences = [
            [
                'name' => 'Bersama Orang Tua',
                'value' => 'Bersama Orang Tua'
            ],
            [
                'name' => 'Wali',
                'value' => 'Wali'
            ],
            [
                'name' => 'Kos',
                'value' => 'Kos'
            ],
            [
                'name' => 'Asrama',
                'value' => 'Asrama'
            ],
            [
                'name' => 'Panti Asuhan',
                'value' => 'Panti Asuhan'
            ]
        ];

        $reject_kip = [
            [
                'value' => 'Dilarang Pemda Karena Menerima Bantuan Serupa'
            ],
            [
                'value' => 'Menolak'
            ],
            [
                'value' => 'Sudah Mampu'
            ]
        ];

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'siswa',
            'label' => 'edit siswa',
            'student' => $student,
            'religions' => Agama::orderBy('id', 'DESC')->get(),
            'districts' => Kodepos::select('kecamatan')->groupBy('kecamatan')->get(),
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'blood_types' => $blood_types,
            'residences' => $residences,
            'reject_kip' => $reject_kip
        ];

        return view('siswa.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nisn' => "required|unique:siswa,nisn,$id,id,deleted_at,NULL",
            'nik' => "required|unique:siswa,nik,$id,id,deleted_at,NULL",
            'no_kk' => "required|unique:siswa,no_kk,$id,id,deleted_at,NULL",
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'golongan_darah' => 'required',
            'akta_lahir' => 'required',
            'agama' => 'required',
            'alamat_jalan' => 'required',
            'email' => "required|email|unique:siswa,email,$id,id,deleted_at,NULL",
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
        $student = Siswa::findOrFail($id);
        try {
            $student->nisn = $validated['nisn'];
            $student->nik = $validated['nik'];
            $student->no_kk = $validated['no_kk'];
            $student->nama_lengkap = $validated['nama_lengkap'];
            $student->jenis_kelamin = $validated['jenis_kelamin'];
            $student->tempat_lahir = $validated['tempat_lahir'];
            $student->tanggal_lahir = $validated['tanggal_lahir'];
            $student->golongan_darah = $validated['golongan_darah'];
            $student->no_registrasi_akta_lahir = $validated['akta_lahir'];
            $student->agama_id = $validated['agama'];
            $student->alamat = $validated['alamat_jalan'];
            $student->email = $validated['email'];
            $student->no_handphone = $validated['no_handphone'];
            $student->kewarganegaraan = $validated['kewarganegaraan'];
            $student->nama_negara = $validated['nama_negara'];
            $student->kebutuhan_khusus_id = $validated['kebutuhan_khusus'];
            $student->tempat_tinggal = $validated['tempat_tinggal'];
            $student->rt = $validated['rt'];
            $student->rw = $validated['rw'];
            $student->dusun = $validated['nama_dusun'];
            $student->village = $validated['kelurahan'];
            $student->district = $validated['kecamatan'];
            $student->postal_code = $validated['kode_pos'];
            $student->transportation = $validated['moda_transportasi'];
            $student->child_order = $validated['anak_keberapa'];
            $student->is_have_kip = $request->is_have_kip;
            $student->is_receive_kip = $request->is_receive_kip;
            $student->reason_reject_kip = $request->reason_reject_kip;
            $student->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('siswa');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $student = Siswa::findOrFail($id);
            $student->delete();
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
