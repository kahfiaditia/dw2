<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RakController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'perpustakaan';

    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('62', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'rak',
                'label' => 'data rak',
                'lists' => Rak::orderBy('id', 'ASC')->get()
            ];
            return view('rak.list_rak')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('63', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'rak',
                'label' => 'tambah rak',
            ];
            return view('rak.add_rak')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('63', $session_menu)) {
            $request->validate([
                'no_rak' => 'required|max:64',
                'rak' => 'required|max:64',
            ]);
            DB::beginTransaction();
            try {
                $rak = new Rak();
                $rak->no_rak = $request['no_rak'];
                $rak->rak = $request['rak'];
                $rak->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('rak');
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

    public function show(rak $rak)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('64', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'rak',
                'label' => 'ubah rak',
                'rak' => Rak::findorfail($id_decrypted)
            ];
            return view('rak.edit_rak')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function update(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('64', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'no_rak' => 'required|max:64',
                'rak' => 'required|max:64',
            ]);
            DB::beginTransaction();
            try {
                $rak = Rak::findOrFail($id);
                $rak->no_rak = $request['no_rak'];
                $rak->rak = $request['rak'];
                $rak->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('rak');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('65', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $rak = Rak::findorfail($id_decrypted);
                $rak->delete();

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
        $rak = Rak::all();
        return $rak;
    }
}
