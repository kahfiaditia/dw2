<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // dd(public_path('files/nik'));
        DB::beginTransaction();
        try {
            $employee = new Employee();
            $employee->nama_lengkap = $request->nama_lengkap;
            $employee->no_hp = $request->no_hp;
            $employee->tempat_lahir = $request->tempat_lahir;
            $employee->tgl_lahir = $request->tgl_lahir;
            $employee->nik = $request->nik;
            if($request->dok_nik) {
                $fileName = Carbon::now()->format('ymdhis').'_'.$request->id.'_'.str::random(25).'.'.$request->dok_nik->extension();
                $employee->dok_nik = $fileName;
                // $request->file->move(public_path('files/nik'), $fileName);
                // $request->file($fileName)->store('public/files/nik');
                $path = $request->file('file')->store('public/files/nik');
            }
            $employee->npwp = $request->npwp;
    $employee->dok_npwp = $request->dok_npwp;
            $employee->kk = $request->kk;
    $employee->dok_kk = $request->dok_kk;
            $employee->bpjs_kesehatan = $request->bpjs_kesehatan;
            $employee->bpjs_ketenagakerjaan = $request->bpjs_ketenagakerjaan;
            $employee->agama_id  = $request->agama;
            $employee->golongan_darah = $request->golongan_darah;
            $employee->nama_pasangan = $request->nama_pasangan;
            $employee->no_pasangan = $request->no_pasangan;
            $employee->alamat_asal = $request->alamat_asal;
            $employee->rt_asal = $request->rt_asal;
            $employee->rw_asal = $request->rw_asal;
            $employee->provinsi_asal = $request->provinsi_asal;
            $employee->kota_asal = $request->kota_asal;
            $employee->kecamatan_asal = $request->kecamatan_asal;
            $employee->kelurahan_asal = $request->kelurahan_asal;
            $employee->kodepos_asal = $request->kodepos_asal;

            if($request->AlamatSama === null){
                $employee->alamat = $request->alamat;
                $employee->rt = $request->rt;
                $employee->rw = $request->rw;
                $employee->provinsi = $request->provinsi;
                $employee->kota = $request->kota;
                $employee->kecamatan = $request->kecamatan;
                $employee->kelurahan = $request->kelurahan;
                $employee->kodepos = $request->kodepos;
            }else{
                $employee->alamat = $request->alamat_asal;
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
            return redirect('employee');
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
    public function edit(Employee $Employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $Employee)
    {
        //
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
}
