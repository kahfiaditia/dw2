<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Diskon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DiskonController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'setting diskon';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('48', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data ' . $this->submenu,
            ];
            return view('diskon.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function list_diskon(Request $request)
    {
        $diskon = Diskon::select(['*']);
        return DataTables::of($diskon)
            ->addColumn('type_diskon', function ($model) {
                $model->type_diskon ? $flag = 'success' : $flag = 'info';
                $model->type_diskon == 1 ? $status = 'Pembayaran' : $status = 'Prestasi';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'diskon.button')
            ->rawColumns(['action', 'type_diskon', 'keterangan'])
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->Where(function ($w) use ($request) {
                        $search = strtolower($request->get('search'));
                        if ($search == 'pe' or  $search == 'pem' or $search == 'pemb' or $search == 'pemba' or $search == 'pembay' or $search == 'pembaya' or $search == 'pembayar' or $search == 'pembayara' or $search == 'pembayaran') {
                            $w->Where('type_diskon', '=', "1")->orWhere('diskon', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('jml_bln_byr', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('diskon_bln', 'LIKE', "%$search%")
                                ->orWhere('diskon_persentase', 'LIKE', "%$search%");
                        } elseif ($search == 'pr' or $search == 'pre' or $search == 'pres' or $search == 'prest' or $search == 'presta' or $search == 'prestas' or $search == 'prestasi') {
                            $w->Where('type_diskon', '=', "0")->orWhere('diskon', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('jml_bln_byr', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('diskon_bln', 'LIKE', "%$search%")
                                ->orWhere('diskon_persentase', 'LIKE', "%$search%");
                        } else {
                            $w->orWhere('diskon', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('jml_bln_byr', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('diskon_bln', 'LIKE', "%$search%")
                                ->orWhere('diskon_persentase', 'LIKE', "%$search%");
                        }
                    });
                }
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('49', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
            ];
            return view('diskon.create')->with($data);
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
        if (in_array('49', $session_menu)) {
            $validated = $request->validate([
                'type_diskon' => 'required',
                'diskon' => 'required',
                'keterangan' => 'required',
                'jml_bln_byr' => 'max:3',
                'diskon_bln' => 'max:3',
                'diskon_persentase' => 'max:3',
            ]);
            DB::beginTransaction();
            try {
                if ($validated['type_diskon'] == 0) {
                    $jml_bln_byr = null;
                } else {
                    $jml_bln_byr = $validated['jml_bln_byr'];
                }
                Diskon::create([
                    'diskon' => $validated['diskon'],
                    'keterangan' => $validated['keterangan'],
                    'type_diskon' => $validated['type_diskon'],
                    'jml_bln_byr' => $jml_bln_byr,
                    'diskon_bln' => $validated['diskon_bln'],
                    'diskon_persentase' => $validated['diskon_persentase'],
                    'user_created' => Auth::user()->id,
                ]);

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('diskon');
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
        if (in_array('50', $session_menu)) {
            $diskon = Diskon::findOrFail(Crypt::decryptString($id));
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Ubah ' . $this->submenu,
                'diskon' => $diskon,
            ];
            return view('diskon.edit')->with($data);
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
        if (in_array('50', $session_menu)) {
            $decrypted_id = Crypt::decryptString($id);
            $validated = $request->validate([
                'type_diskon' => 'required',
                'diskon' => 'required',
                'keterangan' => 'required',
                'jml_bln_byr' => 'max:3',
                'diskon_bln' => 'max:3',
                'diskon_persentase' => 'max:3',
            ]);
            DB::beginTransaction();
            try {
                if ($validated['type_diskon'] == 0) {
                    $jml_bln_byr = null;
                } else {
                    $jml_bln_byr = $validated['jml_bln_byr'];
                }
                $diskon = Diskon::findOrFail($decrypted_id);
                $diskon->diskon = $validated['diskon'];
                $diskon->keterangan = $validated['keterangan'];
                $diskon->type_diskon = $validated['type_diskon'];
                $diskon->jml_bln_byr = $jml_bln_byr;
                $diskon->diskon_bln = $validated['diskon_bln'];
                $diskon->diskon_persentase = $validated['diskon_persentase'];
                $diskon->user_updated = Auth::user()->id;
                $diskon->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('diskon');
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
        if (in_array('51', $session_menu)) {
            DB::beginTransaction();
            try {
                $delete = Diskon::findOrFail(Crypt::decryptString($id));
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

    public function get_diskon(Request $request)
    {
        $diskon = Diskon::findOrFail($request->id_diskon);
        return response()->json([
            'code' => 200,
            'data' => $diskon,
        ]);
    }
}
