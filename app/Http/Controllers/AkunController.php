<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Employee;
use App\Models\School_level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AkunController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
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
            'submenu' => 'akun',
            'label' => 'data akun',
        ];
        return view('akun.list')->with($data);
    }

    public function data_ajax(Request $request)
    {
        $user = User::select(['*'])->orderBy('id', 'DESC')->get();
        return DataTables::of($user)
            ->addColumn('status', function ($model) {
                $model->aktif === '1' ? $flag = 'success' : $flag = 'danger';
                $model->aktif === '1' ? $status = 'Aktif' : $status = 'Non Aktif';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('verifikasi', function ($model) {
                $model->email_verified_at ? $flag = 'success' : $flag = 'warning';
                $model->email_verified_at ? $status = 'Sudah Verifikasi' : $status = 'Belum Verifikasi';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'akun.button')
            ->rawColumns(['status', 'action', 'verifikasi'])
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = strtolower($request->get('search'));
                        if ($search === 'aktif') {
                            $w->Where('aktif', '=', "1");
                        } elseif ($search === 'sudah' or $search === 'verifikasi' or $search === 'sudah verifikasi') {
                            $w->Wherenotnull('email_verified_at');
                        } elseif ($search === 'belum' or $search === 'belum verifikasi') {
                            $w->Wherenull('email_verified_at');
                        } elseif ($search === 'non' or $search === 'non aktif') {
                            $w->orWhere('aktif', '=', null)
                                ->orWhere('aktif', '=', '0')
                                ->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('roles', 'LIKE', "%$search%");
                        } else {
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('roles', 'LIKE', "%$search%");
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
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'akun',
            'label' => 'data akun',
            'school_level' => School_level::all(),
        ];
        return view('akun.add')->with($data);
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
            'username' => 'required|max:128',
            'roles' => 'required',
            'email' => 'required|email:dns|unique:users|max:128',
            'password' => 'required|min:5|max:255',
        ]);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->username;
            $user->roles = $request->roles;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            // set user akses
            if ($request->roles === 'Karyawan') {
                $user->akses_menu = '1,2';
                $user->akses_submenu = '1,2,3,4,6';
            } elseif ($request->roles === 'Admin') {
                $user->akses_menu = '1,2,3,4,5,6,7';
                $user->akses_submenu = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26';
            } elseif ($request->roles === 'Administrator') {
                $user->akses_menu = '1,2,3,4,5,6,7,8,9,10,11,12';
                $user->akses_submenu = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44';
            } elseif ($request->roles === 'Siswa') {
                $user->akses_menu = '1,6';
                $user->akses_submenu = '1,19,20,21';
                $user->id_school_level = $request->id_school_level;
            } elseif ($request->roles === 'Alumni') {
                $user->tahun_lulus = $request->tahun_lulus;
                $user->akses_menu = '1';
                $user->akses_submenu = '1';
            } elseif ($request->roles === 'Ortu') {
            }
            $user->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('akun');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
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
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'akun',
            'label' => 'ubah akun',
            'school_level' => School_level::all(),
            'akun' => User::findorfail($id_decrypted)
        ];
        return view('akun.edit')->with($data);
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
        $request->validate([
            'username' => 'required',
            'roles' => 'required',
            'email' => 'required|email:dns|unique:users,email,' . $id,
            'password' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = User::findorfail($id);
            $user->name = $request->username;
            $user->roles = $request->roles;
            $user->email = $request->email;
            if ($request->password_old != $request->password) {
                $user->password = bcrypt($request->password);
            }
            // set user akses
            if ($request->roles === 'Karyawan') {
                $user->akses_menu = '1,2';
                $user->akses_submenu = '1,2,3,4,6';
            } elseif ($request->roles === 'Admin') {
                $user->akses_menu = '1,2,3,4,5,6,7';
                $user->akses_submenu = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26';
            } elseif ($request->roles === 'Administrator') {
                $user->akses_menu = '1,2,3,4,5,6,7,8,9,10,11,12';
                $user->akses_submenu = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44';
            } elseif ($request->roles === 'Siswa') {
                $user->akses_menu = '1,6';
                $user->akses_submenu = '1,19,20,21';
            } elseif ($request->roles === 'Alumni') {
                $user->tahun_lulus = $request->tahun_lulus;
                $user->akses_menu = '1';
                $user->akses_submenu = '1';
            } elseif ($request->roles === 'Ortu') {
            }
            // update class
            if ($request->roles === 'Siswa') {
                $user->id_school_level = $request->id_school_level;
            } else {
                $user->id_school_level = null;
            }
            $user->aktif = isset($request->aktif) ? 1 : 0;
            $user->save();

            DB::commit();
            AlertHelper::addAlert(true);
            if (Auth::user()->roles === 'Admin') {
                return redirect('akun');
            } else {
                return back();
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
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
        $id_decrypted = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            $user = User::findorfail($id_decrypted);
            $user->delete();

            $karyawan = Employee::where('user_id', $id_decrypted)->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function confirmasi($id)
    {
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'akun',
            'label' => 'ubah akun',
            'school_level' => School_level::all(),
            'akun' => User::findorfail($id_decrypted)
        ];
        return view('akun.confirmasi')->with($data);
    }

    public function save_confirmasi(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findorfail($id);
            $user->aktif = isset($request->aktif) ? 1 : null;
            $user->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('akun');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            AlertHelper::addAlert(false);
            return back();
        }
    }
}
