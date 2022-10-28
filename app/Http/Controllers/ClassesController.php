<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Classes;
use App\Models\School_class;
use App\Models\School_level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ClassesController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Kelas';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('31', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data Kelas',
            ];

            return view('classes.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function list_classes(Request $request)
    {
        $item = Classes::orderBy('id', 'DESC')->get();
        return DataTables::of($item)
            ->addColumn('level', function ($item) {
                return $item->school_level ? $item->school_level->level : '';
            })
            ->addColumn('classes', function ($item) {
                return  $item->school_class ? $item->school_class->classes : '';
            })
            ->addColumn('jurusan', function ($item) {
                return $item->jurusan;
            })
            ->addColumn('type', function ($item) {
                return $item->type;
            })
            ->addColumn('action', 'classes.button')
            ->rawColumns(['action'])
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
        if (in_array('32', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah Kelas',
                'jurusan' => School_level::all(),
            ];
            return view('classes.create')->with($data);
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
        if (in_array('32', $session_menu)) {
            $validated = $request->validate([
                'jenjang' => 'required',
            ]);
            DB::beginTransaction();
            try {
                Classes::create([
                    'id_school_level' => $validated['jenjang'],
                    'jurusan' => $request->jurusan,
                    'class_id' => $request->kelas,
                    'type' => $request->type
                ]);
                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('classes');
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
        $session_menu = explode(',', Auth::User()->akses_submenu);
        if (in_array('33', $session_menu)) {
            $classes = Classes::findOrFail(Crypt::decryptString($id));
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Ubah ' . $this->submenu,
                'classes' => $classes,
                'jurusan' => School_level::all(),
                'kelas' => School_class::where('school_level_id', $classes->id_school_level)->get(),
            ];
            return view('classes.edit')->with($data);
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
        if (in_array('33', $session_menu)) {
            $decrypted_id = Crypt::decryptString($id);
            $validated = $request->validate([
                'jenjang' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $classes = Classes::findOrFail($decrypted_id);
                $classes->id_school_level = $validated['jenjang'];
                $classes->jurusan = $request->jurusan;
                $classes->class_id = $request->kelas;
                $classes->type = $request->type;
                $classes->save();
                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('classes');
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
        if (in_array('34', $session_menu)) {
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
        } else {
            return view('not_found');
        }
    }

    public function get_school_class(Request $request)
    {
        $kelas = School_class::where('school_level_id', $request->jenjang)->get();
        if (count($kelas) > 0) {
            $code = 200;
        } else {
            $code = 400;
        }
        return response()->json([
            'code' => $code,
            'message' => $kelas,
        ]);
    }
}
