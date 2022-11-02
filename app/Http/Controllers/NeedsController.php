<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kebutuhan_khusus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class NeedsController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Kebutuhan Khusus';

    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('23', $session_menu)) {
            $special_needs = Kebutuhan_khusus::orderBy('id', 'DESC')->get();
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data kebutuhan khusus',
                'special_needs' => $special_needs
            ];
            return view('needs.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('24', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'kebutuhan khusus',
                'label' => 'tambah kebutuhan khusus',
            ];
            return view('needs.create')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('24', $session_menu)) {
            $validated = $request->validate([
                'kode' => 'required|unique:kebutuhan_khusus,kode,NULL,id,deleted_at,NULL|min:2',
                'nama' => 'required'
            ]);
            DB::beginTransaction();
            try {
                Kebutuhan_khusus::create([
                    'kode' => $validated['kode'],
                    'nama' => $validated['nama'],
                    'user_created' =>  Auth::user()->id
                ]);

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('needs');
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('25', $session_menu)) {
        } else {
            return view('not_found');
        }
        $special_need = Kebutuhan_khusus::findOrFail(Crypt::decryptString($id));

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'Ubah kebutuhan khusus',
            'special_need' => $special_need
        ];

        return view('needs.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('25', $session_menu)) {
            $decrypted_id = Crypt::decryptString($id);
            $validated = $request->validate([
                'kode' => "required|min:2|unique:kebutuhan_khusus,kode,$decrypted_id,id,deleted_at,NULL",
                'nama' => 'required'
            ]);
            DB::beginTransaction();
            try {
                $special_need = Kebutuhan_khusus::findOrFail($decrypted_id);
                $special_need->kode = $validated['kode'];
                $special_need->nama = $validated['nama'];
                $special_need->user_updated = Auth::user()->id;
                $special_need->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('needs');
            } catch (\Throwable $err) {
                DB::rollBack();
                AlertHelper::updateAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }

    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('26', $session_menu)) {
            DB::beginTransaction();
            try {
                $special_need = Kebutuhan_khusus::findOrFail(Crypt::decryptString($id));
                $special_need->user_deleted = Auth::user()->id;
                $special_need->deleted_at = Carbon::now();
                $special_need->save();

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
