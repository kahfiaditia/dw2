<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Helper\AlertHelper;
use App\Models\Anak_karyawan;
use App\Models\Anak_karyawan_sekolah_dw;
use App\Models\Employee;
use App\Models\Ijazah;
use App\Models\Kontak_darurat;
use App\Models\Riwayat_karyawan;
use App\Models\Sk_karyawan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    protected $title = 'dharmawidya';
    protected $sid = 'SID';
    protected $menu = 'karyawan';

    public function index(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('2', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->sid,
                'submenu' => $this->menu,
                'label' => 'list karyawan',
            ];

            if (Auth::user()->roles !== 'Admin' and Auth::user()->roles !== 'Administrator') {
                $employee = DB::table('karyawan')
                    ->select(
                        'karyawan.id',
                        'nama_lengkap',
                        'email',
                        'nik',
                        'npwp',
                        'no_hp',
                        'jabatan',
                        'karyawan.aktif',
                    )
                    ->Join('users', 'users.id', 'karyawan.user_id')
                    ->where('karyawan.user_id', Auth::user()->id)
                    ->whereNull('karyawan.deleted_at');
            } else {
                $employee = DB::table('karyawan')
                    ->select(
                        'karyawan.id',
                        'nama_lengkap',
                        'email',
                        'nik',
                        'npwp',
                        'no_hp',
                        'jabatan',
                        'karyawan.aktif',
                        'tgl_resign',
                    )
                    ->Join('users', 'users.id', 'karyawan.user_id')
                    ->whereNull('karyawan.deleted_at');
                if ($request->get('search_manual') != null) {
                    $search = $request->get('search_manual');
                    $employee->where(function ($where) use ($search) {
                        if ($search) {
                            if (strtolower($search) == 'aktif') {
                                $status = 1;
                                $where->orWhere('karyawan.aktif', '=', $status);
                            } elseif (strtolower($search) == 'non aktif' or strtolower($search) == 'non') {
                                $status = 0;
                                $where->orWhere('karyawan.aktif', '=', $status);
                                $where->WhereNull('karyawan.tgl_resign');
                            } elseif (strtolower($search) == 'resign') {
                                $status = 0;
                                $where->orWhereNotNull('karyawan.tgl_resign');
                            }
                        }
                        $where
                            ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('nik', 'like', '%' . $search . '%')
                            ->orWhere('npwp', 'like', '%' . $search . '%')
                            ->orWhere('no_hp', 'like', '%' . $search . '%')
                            ->orWhere('jabatan', 'like', '%' . $search . '%');
                    });

                    $search = $request->get('search');
                    $employee->where(function ($where) use ($search) {
                        if ($search) {
                            if (strtolower($search) == 'aktif') {
                                $status = 1;
                                $where->orWhere('karyawan.aktif', '=', $status);
                            } elseif (strtolower($search) == 'non aktif' or strtolower($search) == 'non') {
                                $status = 0;
                                $where->orWhere('karyawan.aktif', '=', $status);
                                $where->WhereNull('karyawan.tgl_resign');
                            } elseif (strtolower($search) == 'resign') {
                                $where->orWhereNotNull('karyawan.tgl_resign');
                            }
                        }
                        $where
                            ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('nik', 'like', '%' . $search . '%')
                            ->orWhere('npwp', 'like', '%' . $search . '%')
                            ->orWhere('no_hp', 'like', '%' . $search . '%')
                            ->orWhere('jabatan', 'like', '%' . $search . '%');
                    });
                } else {
                    if ($request->get('nama') != null) {
                        $nama = $request->get('nama');
                        // $employee->where('nama_lengkap', '=', $nama);
                        $employee->Where('nama_lengkap', 'like', '%' . $nama . '%');
                    }
                    if ($request->get('email') != null) {
                        $email = $request->get('email');
                        $employee->where('email', '=', $email);
                    }
                    if ($request->get('nik') != null) {
                        $nik = $request->get('nik');
                        $employee->where('nik', '=', $nik);
                    }
                    if ($request->get('npwp') != null) {
                        $npwp = $request->get('npwp');
                        $employee->where('npwp', '=', $npwp);
                    }
                    if ($request->get('kontak') != null) {
                        $kontak = $request->get('kontak');
                        $employee->where('no_hp', '=', $kontak);
                    }
                    if ($request->get('jabatan') != null) {
                        $jabatan = $request->get('jabatan');
                        $employee->where('jabatan', '=', $jabatan);
                    }
                    if ($request->get('stat') != null) {
                        $stat = $request->get('stat');
                        if (strtolower($stat) == 'aktif') {
                            $stat = 1;
                            $employee->where('karyawan.aktif', '=', $stat);
                        } elseif (strtolower($stat) == 'non aktif' or strtolower($stat) == 'non') {
                            $stat = 0;
                            $employee->where('karyawan.aktif', '=', $stat);
                            $employee->WhereNull('karyawan.tgl_resign');
                        } elseif (strtolower($stat) == 'resign') {
                            $employee->WhereNotNull('karyawan.tgl_resign');
                        }
                    }
                    if ($request->get('search') != null) {
                        $search = $request->get('search');
                        $employee->where(function ($where) use ($search) {
                            if ($search) {
                                if (strtolower($search) == 'aktif') {
                                    $status = 1;
                                    $where->orWhere('karyawan.aktif', '=', $status);
                                } elseif (strtolower($search) == 'non aktif' or strtolower($search) == 'non') {
                                    $status = 0;
                                    $where->orWhere('karyawan.aktif', '=', $status);
                                    $where->WhereNull('karyawan.tgl_resign');
                                } elseif (strtolower($search) == 'resign') {
                                    $where->orWhereNotNull('karyawan.tgl_resign');
                                }
                            }
                            $where
                                ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%')
                                ->orWhere('nik', 'like', '%' . $search . '%')
                                ->orWhere('npwp', 'like', '%' . $search . '%')
                                ->orWhere('no_hp', 'like', '%' . $search . '%')
                                ->orWhere('jabatan', 'like', '%' . $search . '%');
                        });
                    }
                }
            }

            if ($request->ajax()) {
                return DataTables::of($employee)
                    ->addIndexColumn()
                    ->addColumn('Opsi', 'employee._form')
                    ->addColumn('status', function ($employee) {
                        // $employee->aktif === '1' ? $flag = 'success' : $flag = 'danger';
                        // ($employee->aktif === '1' and $employee->tgl_resign != '') ? $status = 'Aktif' : $status = 'Non Aktif';
                        if ($employee->aktif == '1' and $employee->tgl_resign == null) {
                            $status = 'Aktif';
                            $flag = 'success';
                        } elseif ($employee->aktif == '0' and $employee->tgl_resign != null) {
                            $status = 'Resign';
                            $flag = 'warning';
                        } else {
                            $status = 'Non Aktif';
                            $flag = 'danger';
                        }
                        return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
                    })
                    ->rawColumns(['Opsi', 'status'])
                    ->make(true);
            } else {
                return view('employee.list_employee')->with($data);
            }
        } else {
            return view('not_found');
        }
    }

    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('3', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->sid,
                'submenu' => $this->menu,
                'label' => 'karyawan baru',
            ];
            return view('employee.add_employee')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('3', $session_menu)) {
            $request->validate([
                'nama_lengkap' => 'required|max:128',
                'tempat_lahir' => 'required|max:64',
                'tgl_lahir' => 'required',
                'agama' => 'required',
                'jabatan' => 'required',
                'masuk_kerja' => 'required',
                'nik' => 'required|max:20',
                'niks' => 'required|max:20|unique:karyawan,niks,NULL,id,deleted_at,NULL',
                'kk' => 'required|max:20',
                'dok_nik' => 'mimes:png,jpeg,jpg,pdf|max:2048',
                'dok_npwp' => 'mimes:png,jpeg,jpg,pdf|max:2048',
                'dok_kk' => 'mimes:png,jpeg,jpg,pdf|max:2048',
                'foto' => 'mimes:png,jpeg,jpg|max:2048',
            ]);
            DB::beginTransaction();
            try {
                $employee = new Employee();
                $employee->nama_lengkap = $request->nama_lengkap;
                $employee->no_hp = $request->no_hp;
                $employee->tempat_lahir = $request->tempat_lahir;
                $employee->tgl_lahir = $request->tgl_lahir;
                // niks (no induk karyawan sekolah)
                $employee->niks = $request->niks;
                // dokumen nik
                $employee->nik = $request->nik;
                if ($request->dok_nik) {
                    $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_nik->extension();
                    $employee->dok_nik = $fileName;
                    $request->file('dok_nik')->storeAs('public/karyawan/nik', $fileName);
                }
                // dokumen npwp
                $employee->npwp = $request->npwp;
                if ($request->dok_npwp) {
                    $fileNameNpwp = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_npwp->extension();
                    $employee->dok_npwp = $fileNameNpwp;
                    $request->file('dok_npwp')->storeAs('public/karyawan/npwp', $fileNameNpwp);
                }
                // dokumen kartu keluarga
                $employee->kk = $request->kk;
                if ($request->dok_kk) {
                    $fileNameKK = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_kk->extension();
                    $employee->dok_kk = $fileNameKK;
                    $request->file('dok_kk')->storeAs('public/karyawan/kk', $fileNameKK);
                }
                // dokumen foto karyawan
                $employee->foto = $request->foto;
                if ($request->foto) {
                    $fileNameFoto = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->foto->extension();
                    $employee->foto = $fileNameFoto;
                    $request->file('foto')->storeAs('public/karyawan/foto', $fileNameFoto);
                }
                $employee->bpjs_kesehatan = $request->bpjs_kesehatan;
                $employee->bpjs_ketenagakerjaan = $request->bpjs_ketenagakerjaan;
                $employee->agama_id  = $request->agama;
                $employee->golongan_darah = $request->golongan_darah;
                $employee->nama_pasangan = $request->nama_pasangan;
                $employee->no_pasangan = $request->no_pasangan;
                $employee->alamat_asal = $request->alamat_asal;
                $employee->dusun_asal = $request->dusun_asal;
                $employee->rt_asal = $request->rt_asal;
                $employee->rw_asal = $request->rw_asal;
                $employee->provinsi_asal = $request->provinsi_asal;
                $employee->kota_asal = $request->kota_asal;
                $employee->kecamatan_asal = $request->kecamatan_asal;
                $employee->kelurahan_asal = $request->kelurahan_asal;
                $employee->kodepos_asal = $request->kodepos_asal;

                if ($request->AlamatSama === null) {
                    $employee->alamat = $request->alamat;
                    $employee->dusun = $request->dusun;
                    $employee->rt = $request->rt;
                    $employee->rw = $request->rw;
                    $employee->provinsi = $request->provinsi;
                    $employee->kota = $request->kota;
                    $employee->kecamatan = $request->kecamatan;
                    $employee->kelurahan = $request->kelurahan;
                    $employee->kodepos = $request->kodepos;
                } else {
                    $employee->alamat = $request->alamat_asal;
                    $employee->dusun = $request->dusun_asal;
                    $employee->rt = $request->rt_asal;
                    $employee->rw = $request->rw_asal;
                    $employee->provinsi = $request->provinsi_asal;
                    $employee->kota = $request->kota_asal;
                    $employee->kecamatan = $request->kecamatan_asal;
                    $employee->kelurahan = $request->kelurahan_asal;
                    $employee->kodepos = $request->kodepos_asal;
                }
                $employee->jabatan = $request->jabatan;
                $employee->divisi = $request->divisi;
                $employee->masuk_kerja = $request->masuk_kerja;
                $employee->aktif = '1';
                $employee->user_id = $request->user_id;
                $employee->user_created = Auth::user()->id;
                $employee->save();
                $last_id = $employee->id;

                // update avatar untuk chat 
                User::where("id", Auth::user()->id)
                    ->update(["avatar" => $fileNameFoto]);

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('employee/ijazah/' . Crypt::encryptString($last_id));
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                AlertHelper::addAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function show($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('2', $session_menu)) {
            $id_karyawan = Crypt::decryptString($id);
            $employee = Employee::findOrFail($id_karyawan);
            $data = [
                'title' => $this->title,
                'menu' => $this->sid,
                'submenu' => $this->menu,
                'label' => 'karyawan',
                'item' => $employee,
                'child' => Anak_karyawan::where('karyawan_id', $id_karyawan)->orderBy('anak_ke', 'asc')->get(),
                'school' => Anak_karyawan_sekolah_dw::where('karyawan_id', $id_karyawan)
                    ->orderBy('jenjang')
                    ->orderByRaw("FIELD('KB', 'TK', 'SD', 'SMP', 'SMK')")
                    ->get(),
                'ijazah' => Ijazah::select('gelar_ijazah', 'type', 'karyawan_id')->where('karyawan_id', $id_karyawan)
                    ->orderByRaw("FIELD(gelar_ijazah, 'Kursus', 'Seminar', 'SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2','S3')")->groupby('gelar_ijazah')->get(),
                'sk' => Sk_karyawan::where('karyawan_id', $id_karyawan)->get(),
                'riwayat' => Riwayat_karyawan::where('karyawan_id', $id_karyawan)->get(),
                'kontak' => Kontak_darurat::where('karyawan_id', $id_karyawan)->get(),
            ];
            return view('employee.show_employee')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function edit($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('4', $session_menu)) {
            $result = Crypt::decryptString($id);
            $employee = Employee::findOrFail($result);
            $data = [
                'title' => $this->title,
                'menu' => $this->sid,
                'submenu' => $this->menu,
                'label' => 'karyawan',
                'item' => $employee,
            ];
            return view('employee.edit_employee')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function update(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('4', $session_menu)) {
            $id = Crypt::decryptString($request->id);
            $request->validate([
                'nama_lengkap' => 'required|max:128',
                'tempat_lahir' => 'required|max:64',
                'tgl_lahir' => 'required',
                'jabatan' => 'required',
                'masuk_kerja' => 'required',
                'agama' => 'required',
                'nik' => 'required|max:20',
                'niks' => "required|max:20|unique:karyawan,niks,$id,id,deleted_at,NULL",
                'kk' => 'required|max:20',
            ]);
            DB::beginTransaction();
            try {
                $employee = Employee::findorfail($id);
                $employee->nama_lengkap = $request->nama_lengkap;
                if ($request->nama_lengkap_old != $request->nama_lengkap) {
                    $user = User::findorfail($employee->user_id);
                    $user->name = $request->nama_lengkap;
                    $user->user_updated = Auth::user()->id;
                    $user->save();
                }
                $employee->no_hp = $request->no_hp;
                $employee->tempat_lahir = $request->tempat_lahir;
                $employee->tgl_lahir = $request->tgl_lahir;
                // niks (no induk karyawan sekolah)
                $employee->niks = $request->niks;
                // dokumen nik
                $employee->nik = $request->nik;
                if ($request->dok_nik) {
                    $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_nik->extension();
                    $employee->dok_nik = $fileName;
                    $request->file('dok_nik')->storeAs('public/karyawan/nik', $fileName);
                    // Storage::delete('public/karyawan/nik/' . $request->dok_nik_old);
                }
                // dokumen npwp
                $employee->npwp = $request->npwp;
                if ($request->dok_npwp) {
                    $fileNameNpwp = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_npwp->extension();
                    $employee->dok_npwp = $fileNameNpwp;
                    $request->file('dok_npwp')->storeAs('public/karyawan/npwp', $fileNameNpwp);
                    // Storage::delete('public/karyawan/npwp/' . $request->dok_npwp_old);
                }
                // dokumen kartu keluarga
                $employee->kk = $request->kk;
                if ($request->dok_kk) {
                    $fileNameKK = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_kk->extension();
                    $employee->dok_kk = $fileNameKK;
                    $request->file('dok_kk')->storeAs('public/karyawan/kk', $fileNameKK);
                    // Storage::delete('public/karyawan/kk/' . $request->dok_kk_old);
                }
                // dokumen foto
                if ($request->foto) {
                    $fileNameFoto = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->foto->extension();
                    $employee->foto = $fileNameFoto;
                    $request->file('foto')->storeAs('public/karyawan/foto', $fileNameFoto);
                    // Storage::delete('public/karyawan/foto/' . $request->foto_old);

                    // update avatar untuk chat 
                    User::where("id", $employee->user_id)
                        ->update(["avatar" => $fileNameFoto]);
                }
                $employee->bpjs_kesehatan = $request->bpjs_kesehatan;
                $employee->bpjs_ketenagakerjaan = $request->bpjs_ketenagakerjaan;
                $employee->agama_id  = $request->agama;
                $employee->golongan_darah = $request->golongan_darah;
                $employee->nama_pasangan = $request->nama_pasangan;
                $employee->no_pasangan = $request->no_pasangan;
                $employee->alamat_asal = $request->alamat_asal;
                $employee->dusun_asal = $request->dusun_asal;
                $employee->rt_asal = $request->rt_asal;
                $employee->rw_asal = $request->rw_asal;
                $employee->provinsi_asal = $request->provinsi_asal;
                $employee->kota_asal = $request->kota_asal;
                $employee->kecamatan_asal = $request->kecamatan_asal;
                $employee->kelurahan_asal = $request->kelurahan_asal;
                $employee->kodepos_asal = $request->kodepos_asal;

                if ($request->AlamatSama === null) {
                    $employee->alamat = $request->alamat;
                    $employee->dusun = $request->dusun;
                    $employee->rt = $request->rt;
                    $employee->rw = $request->rw;
                    $employee->provinsi = $request->provinsi;
                    $employee->kota = $request->kota;
                    $employee->kecamatan = $request->kecamatan;
                    $employee->kelurahan = $request->kelurahan;
                    $employee->kodepos = $request->kodepos;
                } else {
                    $employee->alamat = $request->alamat_asal;
                    $employee->dusun = $request->dusun_asal;
                    $employee->rt = $request->rt_asal;
                    $employee->rw = $request->rw_asal;
                    $employee->provinsi = $request->provinsi_asal;
                    $employee->kota = $request->kota_asal;
                    $employee->kecamatan = $request->kecamatan_asal;
                    $employee->kelurahan = $request->kelurahan_asal;
                    $employee->kodepos = $request->kodepos_asal;
                }
                $employee->jabatan = $request->jabatan;
                $employee->divisi = $request->divisi;
                $employee->masuk_kerja = $request->masuk_kerja;
                $employee->user_id = $request->user_id;

                $resign = isset($request->resign) ? 1 : 0;
                if ($resign == 0) {
                    $employee->tgl_resign = null;
                    $employee->alasan_resign = null;
                } else {
                    $employee->tgl_resign = $request->tgl_resign;
                    $employee->alasan_resign = $request->alasan_resign;
                }

                $aktif = isset($request->aktif) ? 1 : 0;
                if ($request->aktif_old != $aktif) {
                    $user = User::findorfail($employee->user_id);
                    $user->aktif = $aktif;
                    $user->user_updated = Auth::user()->id;
                    $user->save();
                }

                $employee->aktif = $aktif;
                $employee->user_updated = Auth::user()->id;
                $employee->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('employee/ijazah/' . $request->id);
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                AlertHelper::updateAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function destroy(Employee $employee, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('5', $session_menu)) {
            $date = Carbon::now();
            $employee_id = Crypt::decryptString($id);
            // karyawan
            $employee = Employee::findOrFail($employee_id);
            $employee->user_deleted = Auth::user()->id;
            $employee->deleted_at = $date;
            $employee->save();

            // user
            $user = User::findorfail($employee->user_id);
            $user->user_deleted = Auth::user()->id;
            $user->deleted_at = $date;
            $user->save();

            AlertHelper::deleteAlert(true);
            return back();
        } else {
            return view('not_found');
        }
    }

    public function ijazah($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
            'lists' => Ijazah::where('karyawan_id', Crypt::decryptString($id))->get(),
        ];
        return view('employee.ijazah_employee')->with($data);
    }

    public function sk($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
            'sk' => Sk_karyawan::where('karyawan_id', Crypt::decryptString($id))->get(),
        ];
        return view('employee.sk_employee')->with($data);
    }

    public function child($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
            'child' => Anak_karyawan::where('karyawan_id', Crypt::decryptString($id))->orderBy('anak_ke', 'asc')->get(),
            'dropdown_child' => Anak_karyawan::doesntHave('anak_karyawan_sekolah_dw')->where('karyawan_id', Crypt::decryptString($id))->orderBy('anak_ke', 'asc')->get(),
            'school' => Anak_karyawan_sekolah_dw::where('karyawan_id', Crypt::decryptString($id))
                ->orderBy('jenjang')
                ->orderByRaw("FIELD('KB', 'TK', 'SD', 'SMP', 'SMK')")
                ->get(),
        ];
        return view('employee.child_employee')->with($data);
    }

    public function store_child(Request $request)
    {
        $request->validate([
            'anak_ke' => 'required|max:2',
            'nama' => 'required|max:64',
            'usia' => 'required|max:2',
        ]);
        $id = Crypt::decryptString($request->karyawan_id);
        $cek = Anak_karyawan::where(['karyawan_id' => $id, 'anak_ke' => $request->anak_ke])->get()->count();
        if ($cek > 0) {
            AlertHelper::addAlert(false);
            return back();
        } else {
            DB::beginTransaction();
            try {
                $anak = new Anak_karyawan();
                $anak->anak_ke = $request->anak_ke;
                $anak->nama = $request->nama;
                $anak->usia = $request->usia;
                $anak->karyawan_id = $id;
                $anak->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return back();
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                AlertHelper::addAlert(false);
                return back();
            }
        }
    }

    public function store_child_dw(Request $request)
    {
        $request->validate([
            'anak_karyawan' => 'required|unique:anak_kar_sklh_dw,anak_id,' . $request->anak_karyawan . ',id,deleted_at,NULL',
            'jenjang' => 'required',
            'karyawan_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->karyawan_id);
            $dw = new Anak_karyawan_sekolah_dw();
            $dw->anak_id = $request->anak_karyawan;
            $dw->jenjang = $request->jenjang;
            $dw->karyawan_id = $id;
            $dw->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function dokumen(Request $request)
    {
        $doc = explode("|", $request->id);
        $eks = explode(".", $doc[0]);
        $data = [
            'file' => $doc[0],
            'eks' => $eks[1],
            'type' => $doc[1],
            'modul' => $doc[2],
        ];
        return view('dokumen')->with($data);
    }

    public function store_sk(Request $request)
    {
        $request->validate([
            'no_sk' => 'required|max:64|unique:sk_karyawan,no_sk',
            'tgl_sk' => 'required',
            'jabatan' => 'required|max:64',
            'dok_sk' => 'mimes:png,jpeg,jpg,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->id);
            $sk = new Sk_karyawan();
            $sk->no_sk = $request->no_sk;
            $sk->tgl_sk = $request->tgl_sk;
            $sk->jabatan = $request->jabatan;
            $sk->karyawan_id = $id;
            // dokumen sk
            if ($request->dok_sk) {
                $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_sk->extension();
                $sk->dok_sk = $fileName;
                $request->file('dok_sk')->storeAs('public/sk/', $fileName);
            }
            $sk->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('employee/sk/' . $request->id);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_sk(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $agama = Sk_karyawan::findorfail($id_decrypted);
            $agama->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_sk(Request $request)
    {
        $data = [
            'id' => $request->id,
            'item' => Sk_karyawan::findorfail(Crypt::decryptString($request->id)),
        ];
        return view('employee.sk_employee_edit')->with($data);
    }

    public function update_sk(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->id);
            $sk = Sk_karyawan::findorfail($id);
            $sk->no_sk = $request->edit_no_sk;
            $sk->tgl_sk = $request->edit_tgl_sk;
            $sk->jabatan = $request->edit_jabatan;
            // dokumen sk
            if ($request->edit_dok_sk) {
                $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->edit_dok_sk->extension();
                $sk->dok_sk = $fileName;
                $request->file('edit_dok_sk')->storeAs('public/sk/', $fileName);
                // Storage::delete('public/sk/' . $request->dok_sk_old);
            }
            $sk->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_anak(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $agama = Anak_karyawan::findorfail($id_decrypted);
            $agama->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function destroy_dw(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $agama = Anak_karyawan_sekolah_dw::findorfail($id_decrypted);
            $agama->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_anak(Request $request)
    {
        $request = explode("|", $request->id);
        $id = $request[0];
        $type = $request[1];
        $karyawan_id = $request[2];
        if ($type === 'anak') {
            $data = [
                'id' => $id,
                'item' => Anak_karyawan::findorfail(Crypt::decryptString($id)),
            ];
            return view('employee.anak_edit')->with($data);
        } elseif ($type === 'dw') {
            $data = [
                'id' => $id,
                'item' => Anak_karyawan_sekolah_dw::findorfail(Crypt::decryptString($id)),
                'child' => Anak_karyawan::where('karyawan_id', $karyawan_id)->orderBy('anak_ke', 'asc')->get(),
            ];
            return view('employee.anak_dw_edit')->with($data);
        }
    }

    public function update_anak(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->id);
            $anak = Anak_karyawan::findorfail($id);
            $anak->anak_ke = $request->edit_anak_ke;
            $anak->nama = $request->edit_nama;
            $anak->usia = $request->edit_usia;
            $anak->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function update_anak_dw(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $cek = Anak_karyawan_sekolah_dw::where('id', '!=', $id)->where('anak_id', '=', $request->edit_anak_id)->get()->count();
        if ($cek > 0) {
            AlertHelper::addAlert(false);
            return back();
        } else {
            DB::beginTransaction();
            try {
                $dw = Anak_karyawan_sekolah_dw::findorfail($id);
                $dw->anak_id  = $request->edit_anak_id;
                $dw->jenjang = $request->edit_jenjang;
                $dw->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return back();
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                AlertHelper::addAlert(false);
                return back();
            }
        }
    }

    public function riwayat($id)
    {
        $contacts = Kontak_darurat::where('karyawan_id', Crypt::decryptString($id))->get();
        $types =
            [
                0 => 'Kontak Kerabat Serumah',
                1 => 'Kontak Kerabat Beda Rumah',
                2 => 'Kontak Kerabat Sekampung'
            ];
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
            'riwayat' => Riwayat_karyawan::where('karyawan_id', Crypt::decryptString($id))->get(),
            'kontak' => $contacts,
            'types' => $types
        ];
        return view('employee.riwayat_employee')->with($data);
    }

    public function store_riwayat(Request $request)
    {
        $request->validate([
            'penyakit' => 'required|max:64',
            'keterangan' => 'required|max:128',
        ]);
        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->id);
            $riwayat = new Riwayat_karyawan();
            $riwayat->penyakit = $request->penyakit;
            $riwayat->keterangan = $request->keterangan;
            $riwayat->karyawan_id = $id;
            $riwayat->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_riwayat(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $agama = Riwayat_karyawan::findorfail($id_decrypted);
            $agama->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_riwayat(Request $request)
    {
        $request = explode("|", $request->id);
        $id = $request[0];
        $type = $request[1];

        $types =
            [
                0 => 'Kontak Kerabat Serumah',
                1 => 'Kontak Kerabat Beda Rumah',
                2 => 'Kontak Kerabat Sekampung'
            ];

        if ($type === 'riwayat') {
            $data = [
                'id' => $id,
                'item' => Riwayat_karyawan::findorfail(Crypt::decryptString($id)),
            ];
            return view('employee.riwayat_employee_edit')->with($data);
        } elseif ($type === 'kontak') {
            $data = [
                'id' => $id,
                'item' => Kontak_darurat::findorfail(Crypt::decryptString($id)),
                'results' => $types
            ];
            return view('employee.kontak_edit')->with($data);
        }
    }

    public function update_riwayat(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $riwayat = Riwayat_karyawan::findorfail($id);
            $riwayat->penyakit  = $request->edit_penyakit;
            $riwayat->keterangan = $request->edit_keterangan;
            $riwayat->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function store_kontak(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:64',
            'no_hp' => 'required|max:20',
            'keterangan_kontak' => 'required|max:128',
        ]);
        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->id);
            $riwayat = new Kontak_darurat();
            $riwayat->nama = $request->nama;
            $riwayat->no_hp = $request->no_hp;
            $riwayat->keterangan = $request->keterangan_kontak;
            $riwayat->karyawan_id = $id;
            $riwayat->tipe = $request->tipe;
            $riwayat->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_kontak(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $agama = Kontak_darurat::findorfail($id_decrypted);
            $agama->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function update_kontak(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $kontak = Kontak_darurat::findorfail($id);
            $kontak->nama  = $request->edit_nama_kontak;
            $kontak->no_hp  = $request->edit_no_hp_kontak;
            $kontak->keterangan = $request->edit_keterangan_kontak;
            $kontak->tipe = $request->tipe;
            $kontak->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function create_ijazah($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'jurusan' => ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
            'jurusan_non' => ['Kursus', 'Seminar'],
            'id' => $id,
        ];
        return view('employee.create_ijazah')->with($data);
    }

    public function store_ijazah(Request $request)
    {
        if ($request->type === 'Akademik') {
            $request->validate([
                'nama_pendidikan' => 'required|max:128',
                'gelar_ijazah' => 'required|max:64',
                'tahun_masuk' => 'required',
                'tahun_lulus' => 'required',
                'dok_ijazah' => 'required|mimes:png,jpeg,jpg,pdf|max:2048',
            ]);
        } else {
            $request->validate([
                'instansi' => 'required',
                'gelar_ijazah_non' => 'required|max:64',
                'gelar_non_akademik_panjang' => 'required',
                'gelar_non_akademik_pendek' => 'required',
                'dok_ijazah' => 'required|mimes:png,jpeg,jpg,pdf|max:2048',
            ]);
        }
        DB::beginTransaction();
        try {
            $ijazah = new Ijazah();
            $ijazah->type = $request->type;
            if ($request->type === 'Akademik') {
                $ijazah->nama_pendidikan = $request->nama_pendidikan;
                $ijazah->gelar_ijazah = $request->gelar_ijazah;
                $ijazah->jurusan = $request->jurusan;
                $ijazah->tahun_masuk = $request->tahun_masuk;
                $ijazah->tahun_lulus = $request->tahun_lulus;
                $ijazah->gelar_akademik_panjang = $request->gelar_akademik_panjang;
                $ijazah->gelar_akademik_pendek = $request->gelar_akademik_pendek;
            } else {
                $ijazah->instansi = $request->instansi;
                $ijazah->gelar_ijazah = $request->gelar_ijazah_non;
                $ijazah->gelar_non_akademik_panjang = $request->gelar_non_akademik_panjang;
                $ijazah->gelar_non_akademik_pendek = $request->gelar_non_akademik_pendek;
            }
            // dokumen sk
            if ($request->dok_ijazah) {
                $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_ijazah->extension();
                $ijazah->dok_ijazah = $fileName;
                $request->file('dok_ijazah')->storeAs('public/ijazah/', $fileName);
            }
            $ijazah->karyawan_id = Crypt::decryptString($request->id);
            $ijazah->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('employee/ijazah/' . $request->id);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function destroy_ijazah(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $ijazah = Ijazah::findorfail($id_decrypted);
            $ijazah->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function edit_ijazah($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'jurusan' => ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
            'jurusan_non' => ['Kursus', 'Seminar'],
            'item' => Ijazah::findorfail(Crypt::decryptString($id)),
        ];
        return view('employee.edit_ijazah')->with($data);
    }

    public function show_ijazah(Request $request)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'jurusan' => ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
            'item' => Ijazah::findorfail(Crypt::decryptString($request->id)),
        ];
        return view('employee.lihat_ijazah')->with($data);
    }

    public function update_ijazah(Request $request)
    {
        if ($request->type === 'Akademik') {
            $request->validate([
                'nama_pendidikan' => 'required|max:128',
                'gelar_ijazah' => 'required|max:64',
                'tahun_masuk' => 'required',
                'tahun_lulus' => 'required',
                'dok_ijazah' => 'mimes:png,jpeg,jpg,pdf|max:2048',
            ]);
        } else {
            $request->validate([
                'instansi' => 'required',
                'gelar_ijazah_non' => 'required|max:64',
                'gelar_non_akademik_panjang' => 'required',
                'gelar_non_akademik_pendek' => 'required',
                'dok_ijazah' => 'mimes:png,jpeg,jpg,pdf|max:2048',
            ]);
        }
        $id = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $ijazah = Ijazah::findorfail($id);
            $ijazah->type = $request->type;
            if ($request->type === 'Akademik') {
                // input
                $ijazah->nama_pendidikan = $request->nama_pendidikan;
                $ijazah->gelar_ijazah = $request->gelar_ijazah;
                $ijazah->jurusan = $request->jurusan;
                $ijazah->tahun_masuk = $request->tahun_masuk;
                $ijazah->tahun_lulus = $request->tahun_lulus;
                $ijazah->gelar_akademik_panjang = $request->gelar_akademik_panjang;
                $ijazah->gelar_akademik_pendek = $request->gelar_akademik_pendek;
                // null
                $ijazah->instansi = null;
                $ijazah->gelar_non_akademik_panjang = null;
                $ijazah->gelar_non_akademik_pendek = null;
            } else {
                // null
                $ijazah->nama_pendidikan = null;
                $ijazah->jurusan = null;
                $ijazah->tahun_masuk = null;
                $ijazah->tahun_lulus = null;
                $ijazah->gelar_akademik_panjang = null;
                $ijazah->gelar_akademik_pendek = null;
                // input
                $ijazah->instansi = $request->instansi;
                $ijazah->gelar_ijazah = $request->gelar_ijazah_non;
                $ijazah->gelar_non_akademik_panjang = $request->gelar_non_akademik_panjang;
                $ijazah->gelar_non_akademik_pendek = $request->gelar_non_akademik_pendek;
            }
            // dokumen sk
            if ($request->dok_ijazah) {
                $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_ijazah->extension();
                $ijazah->dok_ijazah = $fileName;
                $request->file('dok_ijazah')->storeAs('public/ijazah/', $fileName);
                // Storage::delete('public/ijazah/' . $request->dok_ijazah_old);
            }
            $ijazah->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('employee/ijazah/' . $request->karyawan_id);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }

    public function dropdown_email_create()
    {
        $email = User::select('users.*')->where('roles', '=', 'Karyawan')->where('aktif', '=', '1')->whereNotIn('id', function ($query) {
            $query->select('user_id')->from('karyawan')->wherenotnull('user_id');
        })->get();
        return $email;
    }

    public function dropdown_email()
    {
        $email = User::select('*')->get();
        return $email;
    }

    public function get_email(Request $request)
    {
        $data = Employee::where('user_id', $request->user_id)->where('user_id', '!=', $request->user_id_old)->get();
        if (count($data) > 0) {
            return response()->json([
                'code' => 404,
                'message' => 'User sudah dipilih',
            ]);
        } else {
            $user = User::findorfail($request->user_id);
            return response()->json([
                'code' => 200,
                'user' => $user->roles,
                'message' => 'berhasil',
            ]);
        }
    }

    public function cek_ijazah(Request $request)
    {
        $message = [];
        // ijazah
        if ($request->jabatan === 'Karyawan') {
            $count = Ijazah::where('karyawan_id', $request->karyawan_id)
                ->where(function ($query) {
                    $query->where('gelar_ijazah', '!=', 'Kursus')
                        ->orWhere('gelar_ijazah', '!=', 'Seminar');
                })->count();

            $count_divisi = Employee::where('id', $request->karyawan_id)->whereNotNull('divisi')->count();

            if ($count == 0 or $count_divisi == 0) {
                $code = 404;
                if ($count == 0) {
                    array_push($message, "Ijazah, ");
                }
                if ($count_divisi == 0) {
                    array_push($message, "Divisi, ");
                }
            } else {
                $code = 200;
            }
        } elseif ($request->jabatan === 'Guru') {
            $ijazah = DB::table('ijazah_karyawan')
                ->select(
                    DB::raw("count(CASE WHEN gelar_ijazah like '%SD%' THEN id ELSE NULL END) AS sd"),
                    DB::raw("count(CASE WHEN gelar_ijazah like '%SMP%' THEN id ELSE NULL END) AS smp"),
                    DB::raw("count(CASE WHEN gelar_ijazah like '%SMA%' THEN id ELSE NULL END) AS sma"),
                    DB::raw("count(CASE WHEN gelar_ijazah like '%SMK%' THEN id ELSE NULL END) AS smk"),
                    DB::raw("count(CASE WHEN gelar_ijazah like '%S1%' THEN id ELSE NULL END) AS s1"),
                )
                ->where('karyawan_id', $request->karyawan_id)
                ->wherenull('deleted_at')
                ->groupBy('karyawan_id')
                ->get();
            if (count($ijazah) > 0) {
                if (intval($ijazah[0]->sd) >= 1 and intval($ijazah[0]->smp) >= 1 and (intval($ijazah[0]->sma) + intval($ijazah[0]->smk)) >= 1 and intval($ijazah[0]->s1) >= 1) {
                    $code = 200;
                } else {
                    $code = 404;
                    $data = 'Ijazah ';
                    if (intval($ijazah[0]->sd) === 0) {
                        $data .= 'SD, ';
                    }
                    if (intval($ijazah[0]->smp) === 0) {
                        $data .= 'SMP, ';
                    }
                    if (intval($ijazah[0]->sma) === 0 and intval($ijazah[0]->smk) === 0) {
                        $data .= 'SMA/SMK, ';
                    }
                    if (intval($ijazah[0]->s1) === 0) {
                        $data .= 'S1, ';
                    }
                    array_push($message, $data);
                }
            } else {
                $code = 404;
                $data = 'Ijazah SD, SMP, SMA/SMK, S1, ';
                array_push($message, $data);
            }
        } else {
            $code = 200;
        }

        // kontak
        $kontak = DB::table('kontak_darurat')
            ->select(
                DB::raw("count(CASE WHEN tipe like '%Kontak Kerabat Sekampung%' THEN id ELSE NULL END) AS sekampung"),
                DB::raw("count(CASE WHEN tipe like '%Kontak Kerabat Serumah%' THEN id ELSE NULL END) AS serumah"),
                DB::raw("count(CASE WHEN tipe like '%Kontak Kerabat Beda Rumah%' THEN id ELSE NULL END) AS bedarumah"),
            )
            ->where('karyawan_id', $request->karyawan_id)
            ->wherenull('deleted_at')
            ->groupBy('karyawan_id')
            ->get();
        if (count($kontak) > 0) {
            if ($kontak[0]->sekampung >= 1 and $kontak[0]->serumah >= 1 and $kontak[0]->bedarumah >= 1) {
                $code_kontak = 200;
            } else {
                $code_kontak = 404;
                $data = '';
                if (intval($kontak[0]->serumah) === 0) {
                    $data .= 'Kontak Kerabat Serumah, ';
                }
                if (intval($kontak[0]->bedarumah) === 0) {
                    $data .= 'Kontak Kerabat Beda Rumah, ';
                }
                if (intval($kontak[0]->sekampung) === 0) {
                    $data .= 'Kontak Kerabat Sekampung, ';
                }
                array_push($message, $data);
            }
        } else {
            $code_kontak = 404;
            $data = 'Kontak Kerabat Serumah, Kontak Kerabat Beda Rumah, Kontak Kerabat Sekampung, ';
            array_push($message, $data);
        }

        return response()->json([
            'code' => $code,
            'code_kontak' => $code_kontak,
            'message' => $message,
        ]);
    }

    public function export_employee(Request $request)
    {
        $data = [
            'like' => $request->like,
            'search' => $request->search,
            'nama' => $request->nama,
            'email' => $request->email,
            'nik' => $request->nik,
            'npwp' => $request->npwp,
            'kontak' => $request->kontak,
            'jabatan' => $request->jabatan,
            'stat' => $request->stat,
        ];
        return Excel::download(new EmployeeExport($data), 'karyawan.xlsx');
    }

    public function dropdown_karyawan(Request $request)
    {
        if ($request->value_peminjam) {
            $employee = Employee::select('*')->where('jabatan', $request->value_peminjam)->where('aktif', '1')->wherenull('deleted_at')->get();
            return $employee;
        }
    }
}
