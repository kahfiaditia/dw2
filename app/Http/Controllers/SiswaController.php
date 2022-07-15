<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Kebutuhan_khusus;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\AlertHelper;
use App\Imports\StudentImport;
use App\Models\Beasiswa;
use App\Models\Classes;
use App\Models\Kesejahteraan_siswa;
use Yajra\DataTables\DataTables;
use App\Models\Kodepos;
use App\Models\Parents;
use App\Models\Payment;
use App\Models\Priodik_siswa;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'siswa';

    public function index(Request $request)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'siswa',
            'label' => 'data siswa'
        ];

        if (Auth::user()->roles == 'Siswa') {
            $students = Siswa::where('user_id', Auth::user()->id)->get();
        } else {
            $students = Siswa::orderBy('id', 'DESC')->get();
        }

        if ($request->ajax()) {
            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('kelas', function ($students) {
                    return $students->classes_student->school_level->level . ' ' . $students->classes_student->school_class->classes . ' ' . $students->classes_student->jurusan . ' ' . $students->classes_student->type;
                })
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
        if (Auth::user()->roles == 'Admin') {
            $students = User::doesntHave('student')->where('roles', 'Siswa')->orderBy('id', 'DESC')->get();
        } else {
            $students = '';
        }

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Data Pribadi',
            'label' => 'tambah siswa',
            'student' => Auth::user()->student,
            'users' => $students,
            'religions' => Agama::orderBy('agama', 'ASC')->get(),
            'districts' => Kodepos::select('kecamatan')->groupBy('kecamatan')->get(),
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'ASC')->get(),
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
                'reason_reject_kip' => $request->reason_reject_kip,
                'user_id' => Auth::user()->id
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            $siswa = Siswa::orderBy('id', 'DESC')->first();
            return redirect('show_parents/' . Crypt::encryptString($siswa->id));
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $student = Siswa::with('religion', 'special_need', 'periodic_student', 'beasiswa', 'performances', 'kesejahteraan')->findOrFail($id);

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
            'submenu' => 'Data Pribadi',
            'label' => ' siswa',
            'student' => $student,
            'father' => $father,
            'mother' => $mother,
            'guardian' => $guardian
        ];

        return view('siswa.detail')->with($data);
    }

    public function edit($id)
    {
        $student = Siswa::findOrFail(Crypt::decryptString($id));

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
            'submenu' => 'Data Pribadi',
            'label' => 'siswa',
            'student' => $student,
            'religions' => Agama::orderBy('agama', 'ASC')->get(),
            'districts' => Kodepos::select('kecamatan')->groupBy('kecamatan')->get(),
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'ASC')->get(),
            'blood_types' => $blood_types,
            'residences' => $residences,
            'reject_kip' => $reject_kip
        ];

        return view('siswa.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
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
            // if (Auth::user()->roles == 'Siswa') {
            //     return back();
            // } else {
            //     return redirect('siswa');
            // }
            return redirect('show_parents/' . Crypt::encryptString($student->id));
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

    public function show_parents($student_id)
    {
        $student = Siswa::findOrFail(Crypt::decryptString($student_id));

        $father = Parents::with('special_need')->where([
            ['type', '=', 'Ayah'],
            ['siswa_id', '=', $student->id]
        ])->first();

        $mother = Parents::with('special_need')->where([
            ['type', '=', 'Ibu'],
            ['siswa_id', '=', $student->id]
        ])->first();

        $guardian = Parents::with('special_need')->where([
            ['type', '=', 'Wali'],
            ['siswa_id', '=', $student->id]
        ])->first();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'orang tua',
            'label' => 'data orang tua / wali siswa',
            'father' => $father,
            'mother' => $mother,
            'guardian' => $guardian,
            'student' => $student
        ];

        return view('siswa.show_parents')->with($data);
    }

    public function add_parent_student($student_id, $data)
    {

        $student = Siswa::findOrFail(Crypt::decryptString($student_id));

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'orang tua',
            'label' => 'tambah orang tua / wali siswa',
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'type' => $data,
            'student' => $student
        ];

        return view('siswa.add_parent')->with($data);
    }

    public function store_parent_student(Request $request)
    {
        $status = 'Orang Tua';

        if ($request->type == 'wali') {
            $status = 'wali';
        }
        $student_id = Crypt::decryptString($request->student_id);
        DB::beginTransaction();
        try {
            Parents::create([
                'nik' => $request->nik_orang_tua,
                'name' => $request->nama_orang_tua,
                'tanggal_lahir' => $request->tanggal_lahir_orang_tua,
                'no_hp' => $request->no_handphone_orang_tua,
                'pendidikan' => $request->pendidikan_orang_tua,
                'pekerjaan' => $request->pekerjaan_orang_tua,
                'penghasilan' => $request->penghasilan_orang_tua,
                'type' => $request->type,
                'status' => $request->status,
                'siswa_id' => $student_id,
                'kebutuhan_khusus_id' => $request->kebutuhan_khusus,
                'status' => $status
            ]);
            AlertHelper::addAlert(true);
            DB::commit();
            return redirect('show_parents/' . $request->student_id);
        } catch (\Throwable $err) {
            AlertHelper::addAlert(false);
            DB::rollBack();
            return back();
        }
    }

    public function show_periodic($id)
    {
        $id = Crypt::decryptString($id);
        $student = Siswa::with('periodic_student')->findOrFail($id);

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'priodik',
            'label' => 'Data priodik siswa',
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'student' => $student
        ];

        return view('siswa.show_periodic')->with($data);
    }

    public function add_periodic_student($id)
    {
        $id = Crypt::decryptString($id);
        $student = Siswa::with('periodic_student')->findOrFail($id);

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'priodik',
            'label' => 'tambah priodik siswa',
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'student' => $student
        ];

        return view('siswa.add_periodic_student')->with($data);
    }

    public function destroy_parent($id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $parent = Parents::findOrFail($id);
            $parent->delete();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_parent($id, $type)
    {
        $id = Crypt::decryptString($id);
        $educations = ["Tidak Sekolah", "Putus SD", "SD Sederajat", "SMP Sederajat", "SMA Sederajat", "D1", "D2", "D3", "D4/S1", "S2", "S3"];
        $jobs = ["Tidak Bekerja", "Nelayan", "Petani", "Peternak", "PNS/TNI/POLRI", "Karyawan Swasta", "Pedagang Kecil", "Pedagang Besar", "Wiraswasta", "Wirausaha", "Buruh", "Pensiunan", "Dll"];
        $incomes = ["< Rp. 500.000", "Rp. 500.000 - Rp. 999.999", "Rp. 1.000.000 - Rp. 1.999.999", "Rp. 2.000.000 - Rp. 4.999.999", "Rp. 5.000.000 - Rp. 20.000.000"];
        $parent = Parents::findOrFail($id);
        $student = Siswa::findOrFail($parent->siswa_id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'orang tua',
            'label' => 'Edit data orang tua / wali siswa',
            'type' => $type,
            'parent' => $parent,
            'student' => $student,
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'educations' => $educations,
            'jobs' => $jobs,
            'incomes' => $incomes
        ];

        return view('siswa.edit_parent')->with($data);
    }

    public function update_parent(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $parent = Parents::findOrFail($id);
            $parent->nik = $request->nik_orang_tua;
            $parent->name = $request->nama_orang_tua;
            $parent->tanggal_lahir = $request->tanggal_lahir_orang_tua;
            $parent->no_hp = $request->no_handphone_orang_tua;
            $parent->pendidikan = $request->pendidikan_orang_tua;
            $parent->pekerjaan = $request->pekerjaan_orang_tua;
            $parent->penghasilan = $request->penghasilan_orang_tua;
            $parent->kebutuhan_khusus_id = $request->kebutuhan_khusus;
            $parent->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('show_parents/' . Crypt::encryptString($parent->siswa_id));
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function store_periodic_student(Request $request)
    {
        $student_id = Crypt::decryptString($request->student_id);
        DB::beginTransaction();
        try {
            Priodik_siswa::create([
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'lingkar_kepala' => $request->lingkar_kepala,
                'jarak_tempat_tinggal_ke_sekolah' => $request->jarak_tempuh,
                'in_km' => $request->in_km,
                'waktu_tempuh_jam' => $request->jam,
                'waktu_tempuh_menit' => $request->menit,
                'jumlah_saudara_kandung' => $request->saudara_kandung,
                'siswa_id' => $student_id
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('show_periodic/' . Crypt::encryptString($student_id));
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_periodic_student($id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $periodic_student = Priodik_siswa::findOrFail($id);
            $periodic_student->delete();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_periodic_student($id)
    {
        $id = Crypt::decryptString($id);
        $periodic = Priodik_siswa::with('student')->findOrFail($id);
        $student = Siswa::findOrFail($periodic->siswa_id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'priodik',
            'label' => 'Edit Data Priodik Siswa',
            'periodic' => $periodic,
            'student' => $student
        ];

        return view('siswa.edit_periodic_student')->with($data);
    }

    public function update_student_periodic(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $periodic_student = Priodik_siswa::findOrFail($id);
            $periodic_student->tinggi_badan = $request->tinggi_badan;
            $periodic_student->berat_badan = $request->berat_badan;
            $periodic_student->lingkar_kepala = $request->lingkar_kepala;
            $periodic_student->jarak_tempat_tinggal_ke_sekolah = $request->jarak_tempuh;
            $periodic_student->in_km = $request->in_km;
            $periodic_student->waktu_tempuh_jam = $request->jam;
            $periodic_student->waktu_tempuh_menit = $request->menit;
            $periodic_student->jumlah_saudara_kandung = $request->saudara_kandung;
            $periodic_student->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('show_periodic/' . $request->student_id);
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function list_performance_students($id)
    {
        $id = Crypt::decryptString($id);
        $student = Siswa::findOrFail($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'prestasi',
            'label' => 'tambah prestasi siswa',
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'student' => $student,
            'performances' => Prestasi::where('siswa_id', $id)->orderBy('id', 'DESC')->get()
        ];

        return view('siswa.list_performance_students')->with($data);
    }

    public function store_performances(Request $request)
    {
        DB::beginTransaction();
        try {
            Prestasi::create([
                'jenis_prestasi' => $request->jenis_prestasi,
                'tingkat_prestasi' => $request->tingkat_prestasi,
                'nama_prestasi' => $request->nama_prestasi,
                'tahun_prestasi' => $request->tahun_prestasi,
                'penyelenggara' => $request->penyelenggara,
                'peringkat' => $request->peringkat,
                'siswa_id' => $request->student_id
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_performance_student($id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $performance = Prestasi::findOrFail($id);
            $performance->delete();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_performance_student($id)
    {
        $id = Crypt::decryptString($id);
        $performance_types = ["Sains", "Seni", "Olahraga", 'Lain-lain'];
        $perfomance_levels = ["Sekolah", "Kecamatan", "Kabupaten", "Provinsi", "Nasional", "Internasional"];
        $performance = Prestasi::findOrFail($id);
        $student = Siswa::findOrFail($performance->siswa_id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'prestasi',
            'label' => 'edit prestasi siswa',
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'student_id' => $id,
            'performance' => $performance,
            'student' => $student,
            'performance_types' => $performance_types,
            'performance_levels' => $perfomance_levels
        ];

        return view('siswa.edit_performance_student')->with($data);
    }

    public function update_performance_student(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $performance = Prestasi::findOrFail($id);
            $performance->jenis_prestasi = $request->jenis_prestasi;
            $performance->tingkat_prestasi = $request->tingkat_prestasi;
            $performance->nama_prestasi = $request->nama_prestasi;
            $performance->tahun_prestasi = $request->tahun_prestasi;
            $performance->penyelenggara = $request->penyelenggara;
            $performance->peringkat = $request->peringkat;
            $performance->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('list_performance_students/' . $request->student_id);
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function index_beasiswa_student($id)
    {
        $id = Crypt::decryptString($id);
        $student = Siswa::findOrFail($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'beasiswa',
            'label' => 'Beasiswa siswa',
            'student' => $student,
            'special_needs' => Kebutuhan_khusus::orderBy('id', 'DESC')->get(),
            'scholarships' => Beasiswa::orderBy('id', 'DESC')->get()
        ];

        return view('siswa.index_beasiswa_student')->with($data);
    }

    public function store_beasiswa(Request $request)
    {
        DB::beginTransaction();
        try {
            Beasiswa::create([
                'jenis_beasiswa' => $request->jenis_beasiswa,
                'keterangan' => $request->keterangan,
                'tahun_mulai' => $request->tahun_mulai,
                'tahun_selesai' => $request->tahun_selesai,
                'siswa_id' => $request->student_id
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_scholarship($id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $scholarship = Beasiswa::findOrFail($id);
            $scholarship->delete();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_scholarship($id)
    {
        $id = Crypt::decryptString($id);
        $scholarship_types = ["Anak Berprestasi", "Anak Miskin", "Pendidikan", "Unggulan"];

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'beasiswa',
            'label' => 'Edit Beassiwa',
            'student_id' => $id,
            'scholarship' => Beasiswa::findOrFail($id),
            'scholarship_types' => $scholarship_types
        ];

        return view('siswa.edit_scholarship')->with($data);
    }

    public function update_scholarship(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $scholarship = Beasiswa::findOrFail($id);
            $scholarship->jenis_beasiswa = $request->jenis_beasiswa;
            $scholarship->keterangan = $request->keterangan;
            $scholarship->tahun_mulai = $request->tahun_mulai;
            $scholarship->tahun_selesai = $request->tahun_selesai;

            $scholarship->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('index_beasiswa_student/' . $request->student_id);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function index_kesejahteraan_siswa($id)
    {
        $id = Crypt::decryptString($id);
        $student = Siswa::findOrFail($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'kesejahteraan',
            'label' => 'List Kesejahteraan Peserta Didik',
            'student' => $student,
            'kesejahteraan' => Kesejahteraan_siswa::orderBy('id', 'DESC')->get()
        ];

        return view('siswa.index_kesejahteraan_siswa')->with($data);
    }

    public function store_kesejahteraan(Request $request)
    {
        DB::beginTransaction();
        try {
            Kesejahteraan_siswa::create([
                'jenis_kesejahteraan' => $request->jenis_kesejahteraan,
                'nomor_kartu' => $request->nomor_kartu,
                'nama_kartu' => $request->nama_kartu,
                'siswa_id' => $request->student_id
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_kesejahteraan($id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $result = Kesejahteraan_siswa::findOrFail($id);
            $result->delete();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_kesejahteraan($id)
    {
        $kesejahteraan = ['PKH', "PIP", "Kartu Perlindungan Sosial", "Kartu Keluarga Sejahtera", "Kartu Kesehatan"];

        $id = Crypt::decryptString($id);

        $result = Kesejahteraan_siswa::findOrFail($id);
        $student = Siswa::findOrFail($result->siswa_id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'kesejahteraan',
            'label' => 'Edit Kesejahteraan Peserta Didik',
            'result' => $result,
            'kesejahteraan' => $kesejahteraan,
            'student' => $student
        ];

        return view('siswa.edit_kesejahteraan')->with($data);
    }

    public function update_kesejahteraan(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $item = Kesejahteraan_siswa::findOrFail($id);
            $item->jenis_kesejahteraan = $request->jenis_kesejahteraan;
            $item->nomor_kartu = $request->nomor_kartu;
            $item->nama_kartu = $request->nama_kartu;
            $item->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('index_kesejahteraan_siswa/' . $request->student_id);
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
    }

    public function import_csv(Request $request)
    {
        $original_extension = $request->file('student_csv')->getClientOriginalExtension();

        if ($original_extension !== 'csv') {
            AlertHelper::uploadValidation(false);
            return back();
        }

        $request->validate([
            'student_csv' => 'mimes:csv,txt',
        ]);

        DB::beginTransaction();
        try {

            $import = Excel::toArray(new StudentImport(), $request->file('student_csv'));
            $classes = Classes::where('id', $import[0][0][4])->count();
            $formulir = Payment::where('id', $import[0][0][5])->count();
            $uang_pangkal = Payment::where('id', $import[0][0][6])->count();
            $spp = Payment::where('id', $import[0][0][7])->count();
            $kegiatan = Payment::where('id', $import[0][0][8])->count();

            if ($classes + $formulir + $uang_pangkal + $spp + $kegiatan >= 5) {
                // proses import
                Excel::import(new StudentImport, $request->file('student_csv'));
            } else {
                AlertHelper::settingPayment(false);
                return back();
            }

            DB::commit();
            AlertHelper::import(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::import(false);
            return back();
        }
    }

    public function csv_download()
    {
        $files = public_path('assets' . '\\' . 'files' . '\\' . 'import_student.xls');
        return response()->download($files);
    }
}
