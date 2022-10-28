<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Agama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AgamaController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('11', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'agama',
                'label' => 'data agama',
                'lists' => Agama::orderBy('id', 'DESC')->get()
            ];

            return view('agama.list_agama')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('12', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'agama',
                'label' => 'tambah agama',
            ];
            return view('agama.add_agama')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('12', $session_menu)) {
            $request->validate([
                'agama' => 'required|unique:agama,agama,NULL,id,deleted_at,NULL|max:64',
            ]);
            DB::beginTransaction();
            try {
                $agama = new Agama();
                $agama->agama = $request['agama'];
                $agama->aktif = '1';
                $agama->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('agama');
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

    public function show(Agama $agama)
    {
        //
    }

    public function edit(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('13', $session_menu)) {
            $id_decrypted = Crypt::decryptString($request->id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'agama',
                'label' => 'ubah agama',
                'agama' => Agama::findorfail($id_decrypted)
            ];
            return view('agama.edit_agama')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function update(Request $request, Agama $agama, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('13', $session_menu)) {
            $request->validate([
                'agama' => "required|max:64|unique:agama,agama,$id,id,deleted_at,NULL"
            ]);
            DB::beginTransaction();
            try {
                $agama = Agama::findOrFail($id);
                $agama->agama = $request['agama'];
                $agama->aktif = isset($request->aktif) ? 1 : 0;
                $agama->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('agama');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function destroy(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('14', $session_menu)) {
            $id_decrypted = Crypt::decryptString($request->id);
            DB::beginTransaction();
            try {
                $agama = Agama::findorfail($id_decrypted);
                $agama->delete();

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

    public function dropdown()
    {
        $agama = Agama::select('id', 'agama')->where('aktif', '1')->get();
        return $agama;
    }
}
