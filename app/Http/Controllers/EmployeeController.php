<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Employee;
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
            if($request->dok_nik) {
                $fileName = Carbon::now()->format('ymdhis').'_'.str::random(25).'.'.$request->dok_nik->extension();
                $employee->dok_nik = $fileName;
                $request->dok_nik->store('public/karyawan/nik');
            }
            // dokumen npwp
            $employee->dok_npwp = $request->dok_npwp;
            if($request->dok_npwp) {
                $fileName = Carbon::now()->format('ymdhis').'_'.str::random(25).'.'.$request->dok_npwp->extension();
                $employee->dok_npwp = $fileName;
                $request->dok_npwp->store('public/karyawan/npwp');
            }
            // dokumen kartu keluarga
            $employee->kk = $request->kk;
            if($request->dok_kk) {
                $fileName = Carbon::now()->format('ymdhis').'_'.str::random(25).'.'.$request->dok_kk->extension();
                $employee->dok_kk = $fileName;
                $request->dok_kk->store('public/karyawan/kk');
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

            if($request->AlamatSama === null){
                $employee->alamat = $request->alamat;
                $employee->dusun = $request->dusun;
                $employee->rt = $request->rt;
                $employee->rw = $request->rw;
                $employee->provinsi = $request->provinsi;
                $employee->kota = $request->kota;
                $employee->kecamatan = $request->kecamatan;
                $employee->kelurahan = $request->kelurahan;
                $employee->kodepos = $request->kodepos;
            }else{
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
            // AlertHelper::addAlert(true);
            // return redirect('employee');
            return redirect('employee/ijazah');
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
            // 'dok_nik' => 'mimes:png,jpeg,jpg|max:2048',
            // 'dok_npwp' => 'mimes:png,jpeg,jpg|max:2048',
            // 'dok_kk' => 'mimes:png,jpeg,jpg|max:2048',
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
            dd($request);
            $employee->nik = $request->nik;
            if($request->dok_nik) {
                $fileName = Carbon::now()->format('ymdhis').'_'.str::random(25).'.'.$request->dok_nik->extension();
                $employee->dok_nik = $fileName;
                // $request->dok_nik->store('public/karyawan/nik', $fileName);
                $request()->file('dok_nik')->store('public/karyawan/nik');
                // $path = storage_path('storage/app/public/karyawan/nik/'.$fileName);
                // Storage::put($fileName, $path);
                // Storage::path('storage/app/public/karyawan/nik/'.$fileName);
                // Storage::delete('public/karyawan/nik/'.$request->dok_nik_old);
            }
            // dokumen npwp
            $employee->dok_npwp = $request->dok_npwp;
            if($request->dok_npwp) {
                $fileName = Carbon::now()->format('ymdhis').'_'.str::random(25).'.'.$request->dok_npwp->extension();
                $employee->dok_npwp = $fileName;
                $request->dok_npwp->store('public/karyawan/npwp', $fileName);
                // Storage::delete('public/karyawan/npwp/'.$request->dok_npwp_old);
            }
            // dokumen kartu keluarga
            $employee->kk = $request->kk;
            if($request->dok_kk) {
                $fileName = Carbon::now()->format('ymdhis').'_'.str::random(25).'.'.$request->dok_kk->extension();
                $employee->dok_kk = $fileName;
                $request->dok_kk->store('public/karyawan/kk');
                // Storage::delete('public/karyawan/kk/'.$request->dok_kk_old);
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

            if($request->AlamatSama === null){
                $employee->alamat = $request->alamat;
                $employee->dusun = $request->dusun;
                $employee->rt = $request->rt;
                $employee->rw = $request->rw;
                $employee->provinsi = $request->provinsi;
                $employee->kota = $request->kota;
                $employee->kecamatan = $request->kecamatan;
                $employee->kelurahan = $request->kelurahan;
                $employee->kodepos = $request->kodepos;
            }else{
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
            return back();
            // return redirect('employee/ijazah');
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

    public function ijazah(Request $request)
    {
        dd($request);
        # code...
    }
}
