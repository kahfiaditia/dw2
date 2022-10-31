<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Diskon;
use App\Models\Diskon_prestasi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PrestasiController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'diskon prestasi';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('52', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data ' . $this->submenu,
            ];
            return view('prestasi.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function list_prestasi(Request $request)
    {
        $prestasi = Diskon_prestasi::orderBy('id', 'DESC')->get();
        return DataTables::of($prestasi)
            ->addColumn('diskon', function ($prestasi) {
                return $prestasi->diskon->diskon;
            })
            ->addColumn('nis', function ($prestasi) {
                return $prestasi->student->nis;
            })
            ->addColumn('siswa', function ($prestasi) {
                return $prestasi->student->nama_lengkap;
            })
            ->addColumn('action', 'prestasi.button')
            ->rawColumns(['action', 'siswa'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('53', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
                'diskon' => Diskon::where('type_diskon', 0)->get()
            ];
            return view('prestasi.create')->with($data);
        } else {
            return view('not_found');
        }
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
        if (in_array('53', $session_menu)) {
            $validated = $request->validate([
                'diskon' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            if ($request->nis == '' and $request->siswa == '') {
                AlertHelper::alertDinamis(false, 'Siswa wajib dipilih');
                return back();
            } else if ($request->nis == '' and $request->siswa != '') {
                $siswa_id = $request->siswa;
            } else {
                $siswa = Siswa::where('nis', str_replace("-", "", $request->nis))->firstorfail();
                if ($siswa) {
                    $siswa_id = $siswa->id;
                } else {
                    AlertHelper::alertDinamis(false, 'Siswa tidak terdaftar');
                    return back();
                }
            }
            DB::beginTransaction();
            try {
                Diskon_prestasi::create([
                    'siswa_id' => $siswa_id,
                    'diskon_id' => $validated['diskon'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'user_created' => Auth::user()->id,
                ]);
                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('prestasi');
            } catch (\Throwable $err) {
                DB::rollBack();
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('54', $session_menu)) {
            $prestasi = Diskon_prestasi::findOrFail(Crypt::decryptString($id));
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Ubah ' . $this->submenu,
                'prestasi' => $prestasi,
                'diskon' => Diskon::where('type_diskon', 0)->get()
            ];
            return view('prestasi.edit')->with($data);
        } else {
            return view('not_found');
        }
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
        if (in_array('54', $session_menu)) {
            $decrypted_id = Crypt::decryptString($id);
            $validated = $request->validate([
                'diskon' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            if ($request->nis == '' and $request->siswa == '') {
                AlertHelper::alertDinamis(false, 'Siswa wajib dipilih');
                return back();
            } else if ($request->nis == '' and $request->siswa != '') {
                $siswa_id = $request->siswa;
            } else {
                $siswa = Siswa::where('nis', str_replace("-", "", $request->nis))->firstorfail();
                if ($siswa) {
                    $siswa_id = $siswa->id;
                } else {
                    AlertHelper::alertDinamis(false, 'Siswa tidak terdaftar');
                    return back();
                }
            }
            DB::beginTransaction();
            try {
                $prestasi = Diskon_prestasi::findOrFail($decrypted_id);
                $prestasi->siswa_id = $siswa_id;
                $prestasi->diskon_id = $validated['diskon'];
                $prestasi->start_date = $validated['start_date'];
                $prestasi->end_date = $validated['end_date'];
                $prestasi->user_updated = Auth::user()->id;
                $prestasi->save();
                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('prestasi');
            } catch (\Throwable $err) {
                DB::rollBack();
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
        if (in_array('55', $session_menu)) {
            DB::beginTransaction();
            try {
                $delete = Diskon_prestasi::findOrFail(Crypt::decryptString($id));
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
