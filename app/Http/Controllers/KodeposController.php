<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kodepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class KodeposController extends Controller
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
            'menu' => $this->menu,
            'submenu' => 'kodepos',
            'label' => 'data kodepos',
        ];
        return view('kodepos.ListKodepos')->with($data);
    }

    public function data_ajax()
    {
        return Datatables::of(Kodepos::query())
        ->addColumn('action', function($model){
            return '<a href="'. route('kodepos.edit',['id' => Crypt::encryptString($model->id)]) .'" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                    <a href="'. route('kodepos.destroy',['id' => Crypt::encryptString($model->id),'method'=>'DELETE']) .'" class="text-danger delete_confirm"><i class="mdi mdi-delete font-size-18"></i></a>';
        })
        // ->rawColumns(['action'])
        ->make(true);
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
            'menu' => $this->menu,
            'submenu' => 'kodepos',
            'label' => 'tambah kodepos',
        ];
        return view('kodepos.AddKodepos')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $kodepos = new Kodepos();
            $kodepos->provinsi = $request->provinsi;
            $kodepos->kabupaten = $request->kabupaten;
            $kodepos->kecamatan = $request->kecamatan;
            $kodepos->kelurahan = $request->kelurahan;
            $kodepos->kodepos = $request->kodepos;
            $kodepos->status = 'A';
            $kodepos->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('kodepos');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function show(Kodepos $kodepos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'kodepos',
            'label' => 'ubah kodepos',
            'kodepos' => Kodepos::findorfail($id_decrypted)
        ];
        return view('kodepos.EditKodepos')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kodepos $kodepos)
    {
        DB::beginTransaction();
        try {
            $kodepos = Kodepos::findorfail($request->id);
            $kodepos->provinsi = $request->provinsi;
            $kodepos->kabupaten = $request->kabupaten;
            $kodepos->kecamatan = $request->kecamatan;
            $kodepos->kelurahan = $request->kelurahan;
            $kodepos->kodepos = $request->kodepos;
            $kodepos->status = isset($request->Status) ? 'A' : '';
            $kodepos->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('kodepos');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kodepos  $kodepos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $kodepos = Kodepos::findorfail($id_decrypted);
            $kodepos->status = 0;
            $kodepos->save();

            $kodepos = Kodepos::findorfail($id_decrypted);
            $kodepos->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function dropdown()
    {
        $kota = Kodepos::select('kabupaten')->where('provinsi','=','Banten')->groupBy('kabupaten')->get();
        return $kota;
    }

    public function kota(Request $request)
    {
        $kecamatan = Kodepos::select('kecamatan')
                    ->where('provinsi','=','Banten')
                    ->where('kabupaten','=',$request->Kota)
                    ->groupBy('kecamatan')->get();
        return $kecamatan;
    }

    public function kecamatan(Request $request)
    {
        $kelurahan = Kodepos::select('kelurahan')
                    ->where('provinsi','=','Banten')
                    ->where('kabupaten','=',$request->KotaA)
                    ->where('kecamatan','=',$request->KecamatanA)
                    ->groupBy('kelurahan')->get();
        return $kelurahan;
    }

    public function kelurahan(Request $request)
    {
        $kodepos = Kodepos::select('kodepos')
                    ->where('provinsi','=','Banten')
                    ->where('kabupaten','=',$request->KotaA)
                    ->where('kecamatan','=',$request->KecamatanA)
                    ->where('kelurahan','=',$request->KelurahanA)
                    ->groupBy('kodepos')->get();
        return $kodepos;
    }
}
