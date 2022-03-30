<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AkunController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'akun';
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
            'submenu' => null,
            'label' => 'data akun',
        ];
        return view('akun.list')->with($data);
    }

    public function data_ajax()
    {
        $user = User::select(['*']);
        return DataTables::of($user)
            ->addColumn('status', function ($model) {
                $model->status === "1" ? $flag = 'success' : $flag = 'danger';
                $model->status === "1" ? $status = 'Aktif' : $status = 'Non Aktif';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'akun.button')
            ->rawColumns(['status', 'action'])
            ->order(function ($user) {
                $user->orderBy('name', 'asc');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            'submenu' => null,
            'label' => 'ubah akun',
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
                $user->password = $request->password;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
