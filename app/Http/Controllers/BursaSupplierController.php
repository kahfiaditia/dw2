<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use Illuminate\Http\Request;
use App\Models\BursaSupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BursaSupplierController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'Bursa';
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
            'submenu' => 'Supplier',
            'label' => 'data Supplier',
            'supplier' => BursaSupplier::all()
        ];
        return view('bursa.bursa_supplier.data')->with($data);
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
            'submenu' => 'Supplier',
            'label' => 'tambah Supplier',

        ];
        return view('bursa.bursa_supplier.tambah')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('59', $session_menu)) {
            $request->validate([
                'supplier' => 'required',
                'alamat' => 'required',
                'nama_kontak' => 'required',
                'nomor' => 'required',
                'status' => 'required',
            ]);

            DB::beginTransaction();
            try {
                $supplier = new BursaSupplier();
                $supplier->nama = strtoupper($request['supplier']);
                $supplier->alamat = strtoupper($request['alamat']);
                $supplier->nama_kontak = strtoupper($request['nama_kontak']);
                $supplier->tlp = $request->nomor;
                $supplier->status = $request->status;
                $supplier->user_created = Auth::user()->id;
                $supplier->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/supplier');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::addAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'Supplier',
            'label' => 'ubah Supplier',
            'supplier' => BursaSupplier::findORFail($id_decrypted)
        ];
        return view('bursa.bursa_supplier.ubah')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('60', $session_menu)) {
            $request->validate([
                'nama' => 'required',
                'alamat' => 'required',
                'nama_kontak' => 'required',
                'tlp' => 'required',
                'status' => 'required',
            ]);

            $id = Crypt::decryptString($id);

            DB::beginTransaction();
            try {
                BursaSupplier::where('id', $id)
                    ->update([
                        'nama' => strtoupper($request['nama']),
                        'alamat' => strtoupper($request['alamat']),
                        'nama_kontak' => strtoupper($request['nama_kontak']),
                        'tlp' => $request->tlp,
                        'status' => $request->status,
                        'user_updated' => Auth::user()->id,
                    ]);

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bursa/supplier');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::updateAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('51', $session_menu)) {
            DB::beginTransaction();
            try {
                $delete = BursaSupplier::findOrFail(Crypt::decryptString($id));
                $delete->user_deleted = Auth::user()->id;
                $delete->deleted_at = Carbon::now();
                $delete->save();

                DB::commit();
                AlertHelper::deleteAlert(true);
                return back();
            } catch (\Throwable $err) {
                DB::rollBack();
                AlertHelper::deleteAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }
}
