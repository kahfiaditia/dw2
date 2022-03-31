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
        return view('kodepos.list_kodepos')->with($data);
    }

    public function data_ajax(Request $request)
    {
        $kodepos = Kodepos::select(['*']);
        return Datatables::of($kodepos)
            ->addColumn('status', function ($model) {
                $model->status === "1" ? $flag = 'success' : $flag = 'danger';
                $model->status === "1" ? $status = 'Aktif' : $status = 'Non Aktif';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'kodepos.button')
            ->rawColumns(['status', 'action'])
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = strtolower($request->get('search'));
                        if ($search === 'aktif') {
                            $w->Wherenotnull('status');
                        } elseif ($search === 'non' or $search === 'non aktif') {
                            $w->Wherenull('status')
                                ->orWhere('provinsi', 'LIKE', "%$search%")
                                ->orWhere('kabupaten', 'LIKE', "%$search%")
                                ->orWhere('kecamatan', 'LIKE', "%$search%")
                                ->orWhere('kelurahan', 'LIKE', "%$search%");
                        } else {
                            $w->orWhere('provinsi', 'LIKE', "%$search%")
                                ->orWhere('kabupaten', 'LIKE', "%$search%")
                                ->orWhere('kecamatan', 'LIKE', "%$search%")
                                ->orWhere('kelurahan', 'LIKE', "%$search%");
                        }
                    });
                }
            })
            ->order(function ($query) {
                $query->orderBy('provinsi', 'asc');
            })
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
        return view('kodepos.add_kodepos')->with($data);
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
            'provinsi' => 'required|max:100',
            'kabupaten' => 'required|max:100',
            'kecamatan' => 'required|max:100',
            'kelurahan' => 'required|max:100',
            'kodepos' => 'required|max:5',
        ]);
        DB::beginTransaction();
        try {
            $kodepos = new Kodepos();
            $kodepos->provinsi = $request->provinsi;
            $kodepos->kabupaten = $request->kabupaten;
            $kodepos->kecamatan = $request->kecamatan;
            $kodepos->kelurahan = $request->kelurahan;
            $kodepos->kodepos = $request->kodepos;
            $kodepos->status = '1';
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
        return view('kodepos.edit_kodepos')->with($data);
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
            $kodepos->status = isset($request->Status) ? '1' : '0';
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
        $provinsi = Kodepos::select('provinsi')->groupBy('provinsi')->get();
        return $provinsi;
    }

    public function provinsi(Request $request)
    {
        $provinsi = Kodepos::select('kabupaten')
            ->where('provinsi', '=', $request->Provinsi)
            ->groupBy('kabupaten')->get();
        return $provinsi;
    }

    public function kota(Request $request)
    {
        $kecamatan = Kodepos::select('kecamatan')
            ->where('provinsi', '=', $request->Provinsi)
            ->where('kabupaten', '=', $request->Kota)
            ->groupBy('kecamatan')->get();
        return $kecamatan;
    }

    public function kecamatan(Request $request)
    {
        $kelurahan = Kodepos::select('kelurahan')
            ->where('provinsi', '=', $request->Provinsi)
            ->where('kabupaten', '=', $request->Kota)
            ->where('kecamatan', '=', $request->Kecamatan)
            ->groupBy('kelurahan')->get();
        return $kelurahan;
    }

    public function kelurahan(Request $request)
    {
        $kodepos = Kodepos::select('kodepos')
            ->where('provinsi', '=', $request->Provinsi)
            ->where('kabupaten', '=', $request->Kota)
            ->where('kecamatan', '=', $request->Kecamatan)
            ->where('kelurahan', '=', $request->Kelurahan)
            ->groupBy('kodepos')->get();
        return $kodepos;
    }
}
