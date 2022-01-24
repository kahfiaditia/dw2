<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Anak_karyawan;
use App\Models\Anak_karyawan_sekolah_dw;
use App\Models\Employee;
use App\Models\Sk_karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'karyawan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => 'data',
            'submenu' => 'karyawan',
            'label' => 'list karyawan',
            'lists' => Employee::all()->sortBy("nama_lengkap")
        ];
        return view('employee.list_employee')->with($data);
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
            'menu' => 'data',
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
        ];
        return view('employee.add_employee')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:128',
            'tempat_lahir' => 'required|max:64',
            'tgl_lahir' => 'required',
            'agama' => 'required',
            'nik' => 'required|max:20',
            'kk' => 'required|max:20',
            'dok_nik' => 'mimes:png,jpeg,jpg|max:2048',
            'dok_npwp' => 'mimes:png,jpeg,jpg|max:2048',
            'dok_kk' => 'mimes:png,jpeg,jpg|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $employee = new Employee();
            $employee->nama_lengkap = $request->nama_lengkap;
            $employee->no_hp = $request->no_hp;
            $employee->tempat_lahir = $request->tempat_lahir;
            $employee->tgl_lahir = $request->tgl_lahir;
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
            $employee->aktif = '1';
            $employee->save();
            $last_id = $employee->id;

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('employee/edit/' . Crypt::encryptString($last_id));
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $Employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => 'data',
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
        ];
        return view('employee.edit_employee')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:128',
            'tempat_lahir' => 'required|max:64',
            'tgl_lahir' => 'required',
            'agama' => 'required',
            'nik' => 'required|max:20',
            'kk' => 'required|max:20',
        ]);

        DB::beginTransaction();
        try {
            $id = Crypt::decryptString($request->id);
            $employee = Employee::findorfail($id);
            $employee->nama_lengkap = $request->nama_lengkap;
            $employee->no_hp = $request->no_hp;
            $employee->tempat_lahir = $request->tempat_lahir;
            $employee->tgl_lahir = $request->tgl_lahir;
            // dokumen nik
            $employee->nik = $request->nik;
            if ($request->dok_nik) {
                $fileName = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_nik->extension();
                $employee->dok_nik = $fileName;
                $request->file('dok_nik')->storeAs('public/karyawan/nik', $fileName);
                Storage::delete('public/karyawan/nik/' . $request->dok_nik_old);
            }
            // dokumen npwp
            $employee->npwp = $request->npwp;
            if ($request->dok_npwp) {
                $fileNameNpwp = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_npwp->extension();
                $employee->dok_npwp = $fileNameNpwp;
                $request->file('dok_npwp')->storeAs('public/karyawan/npwp', $fileNameNpwp);
                Storage::delete('public/karyawan/npwp/' . $request->dok_npwp_old);
            }
            // dokumen kartu keluarga
            $employee->kk = $request->kk;
            if ($request->dok_kk) {
                $fileNameKK = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->dok_kk->extension();
                $employee->dok_kk = $fileNameKK;
                $request->file('dok_kk')->storeAs('public/karyawan/kk', $fileNameKK);
                Storage::delete('public/karyawan/kk/' . $request->dok_kk_old);
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
            $employee->aktif = '1';
            $employee->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('employee/ijazah/'.$request->id);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $Employee)
    {
        //
    }

    public function ijazah($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => 'data',
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
        ];
        return view('employee.ijazah_employee')->with($data);
    }

    public function sk($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => 'data',
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
            'child' => Sk_karyawan::where('karyawan_id',Crypt::decryptString($id))->get(),
        ];
        return view('employee.sk_employee')->with($data);
    }

    public function child($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => 'data',
            'submenu' => $this->menu,
            'label' => 'karyawan baru',
            'item' => Employee::findorfail(Crypt::decryptString($id)),
            'child' => Anak_karyawan::where('karyawan_id',Crypt::decryptString($id))->get(),
            'school' => Anak_karyawan_sekolah_dw::all(),
        ];
        return view('employee.child_employee')->with($data);
    }

    public function store_child(Request $request)
    {
        $id = Crypt::decryptString($request->karyawan_id);
        $request->validate([
            'anak_ke' => 'required|max:2',
            'nama' => 'required|max:64',
            'usia' => 'required|max:2',
        ]);
        $cek = Anak_karyawan::where(['karyawan_id' => $id, 'anak_ke' => $request->anak_ke ])->get()->count();
        if($cek > 0){
            AlertHelper::addAlert(false);
            return back();
        }else{
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
                // something went wrong
                AlertHelper::addAlert(false);
                return back();
            }
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
            'no_sk' => 'required|max:64',
            'tgl_sk' => 'required',
            'jabatan' => 'required|max:64',
            'dok_sk' => 'mimes:png,jpeg,jpg|max:2048',
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
            return redirect('employee/sk/'.$request->id);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
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
                Storage::delete('public/sk/' . $request->dok_sk_old);
            }
            $sk->save();

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
