<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Inv_Ruangan;
use App\Models\Inventaris;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventarisController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => 'Inventaris',
            'submenu' => 'Data Barang',
            'label' => 'Data Inventaris',
        ];
        $inventaris = Inventaris::all();
        return view('inventaris.data', compact('inventaris'))->with($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $ruangs = Inv_Ruangan::all();
        $data = [
            'title' => $this->title,
            'menu' => 'Inventaris',
            'submenu' => 'Data Barang',
            'label' => 'Tambah Inventaris',
        ];
        return view('inventaris.create', compact('ruangs'))->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo json_encode('1');
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('80', $session_menu)) {

            DB::beginTransaction();
            try {


                for ($i = 0; $i < count($request->databarang); $i++) {
                    $inventaris = new Inventaris;
                    $inventaris->nama = $request->databarang[$i]['hasilnama'];
                    $inventaris->nomor_inventaris = $request->databarang[$i]['hasilno_inv'];
                    $inventaris->idbarang = $request->databarang[$i]['hasilidbarang'];
                    $inventaris->id_ruangan  = $request->databarang[$i]['id'];
                    $inventaris->pemilik = $request->databarang[$i]['pemilik'];
                    $inventaris->status = $request->databarang[$i]['keterangan'];
                    $inventaris->ketersediaan =  $request->databarang[$i]['ketersediaan'];
                    $inventaris->indikasi = $request->databarang[$i]['hasilindikasi'];
                    $inventaris->deskripsi =  $request->databarang[$i]['hasildesc'];
                    $inventaris->qty  = 1;
                    $inventaris->user_created =  Auth::user()->id;
                    // $inventaris->id_ruangan =  1;
                    $inventaris->save();
                }

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'message' => 'Berhasil Input Data',
                ]);
                // return redirect('inventaris');
            } catch (\Throwable $err) {
                DB::rollBack();
                throw $err;
                return response()->json([
                    'code' => 404,
                    'message' => 'Gagal Input Data',
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Sorry, page not found',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function show(Inventaris $inventaris, $id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $ruangs = Inv_Ruangan::all();
        $data = [
            'title' => $this->title,
            'menu' => 'Inventaris',
            'submenu' => 'Data Barang',
            'label' => 'Inventaris',
            'inventaris' => Inventaris::findORFail($id_decrypted),
        ];
        return view('inventaris.show', compact('inventaris', 'ruangs'))->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $ruangs = Inv_Ruangan::all();
        $data = [
            'title' => $this->title,
            'menu' => 'Inventaris',
            'submenu' => 'Data Barang',
            'label' => 'Edit Inventaris',
            'inventaris' => Inventaris::findORFail($id_decrypted),
        ];

        return view('inventaris.edit', compact('ruangs'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);

        DB::beginTransaction();
        try {

            Inventaris::where('id', $id)
                ->update([
                    'nama' => $request->nama,
                    'nomor_inventaris' => $request->nomor_inventaris,
                    'idbarang' => $request->idbarang,
                    'id_ruangan' => $request->id_ruangan,
                    'qty' => $request->qty,
                    'status' => $request->status,
                    'indikasi' => $request->indikasi,
                    'pemilik' => $request->pemilik,
                    'deskripsi' => $request->deskripsi,
                    'user_updated' => Auth::user()->id,
                ]);

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('inventaris');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $id_decrypted = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $inventaris = Inventaris::findorfail($id_decrypted);
            $inventaris->user_deleted = Auth::user()->id;
            $inventaris->deleted_at = Carbon::now();
            $inventaris->save();

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
