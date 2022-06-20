<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Invoice;
use App\Models\Siswa;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'pembayaran';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::orderBy('id', 'DESC')->get();
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data ' . $this->submenu,
            'invoice' => $invoice
        ];
        return view('invoice.index')->with($data);
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
            'submenu' => $this->submenu,
            'label' => 'tambah ' . $this->submenu,
            // 'mounth' => ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            'students' => Siswa::all(),
            'classes' => Classes::groupBY('jenjang')->orderByRaw("FIELD(jenjang, 'TK', 'SD', 'SMP', 'SMA', 'SMK')")->get(),
        ];
        return view('invoice.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenjang' => 'required',
            'kelas' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Classes::create([
                'jenjang' => $validated['jenjang'],
                'class' => $validated['kelas'],
                'type' => $request->type
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('invoice');
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            AlertHelper::addAlert(false);
            return back();
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
        $invoice = Classes::findOrFail(Crypt::decryptString($id));
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'Edit bills',
            'invoice' => $invoice,
            'jurusan' => ['TK', 'SD', 'SMP', 'SMA', 'SMK'],
        ];
        return view('invoice.edit')->with($data);
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
        $decrypted_id = Crypt::decryptString($id);
        $validated = $request->validate([
            'jenjang' => 'required',
            'kelas' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $invoice = Classes::findOrFail($decrypted_id);
            $invoice->jenjang = $validated['jenjang'];
            $invoice->class = $validated['kelas'];
            $invoice->type = $request->type;
            $invoice->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('invoice');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
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
        DB::beginTransaction();
        try {
            $delete = Classes::findOrFail(Crypt::decryptString($id));
            $delete->delete();
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
