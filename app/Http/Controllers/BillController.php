<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Bills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Tagihan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('27', $session_menu)) {

            $bills = Bills::orderBy('id', 'ASC')->get();
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data Tagihan',
                'bills' => $bills
            ];
            return view('bills.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('28', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah Tagihan',
            ];
            return view('bills.create')->with($data);
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
        $validated = $request->validate([
            'bills' => 'required|unique:bills,bills,NULL,id,deleted_at,NULL',
            'notes' => 'required'
        ]);
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('28', $session_menu)) {

            DB::beginTransaction();
            try {
                Bills::create([
                    'bills' => $validated['bills'],
                    'notes' => $validated['notes'],
                    'looping' => isset($request->looping) ? 1 : 0
                ]);
                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('bills');
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
        if (in_array('29', $session_menu)) {
            $bills = Bills::findOrFail(Crypt::decryptString($id));
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'Ubah Tagihan',
                'bills' => $bills
            ];
            return view('bills.edit')->with($data);
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
        if (in_array('29', $session_menu)) {
            $decrypted_id = Crypt::decryptString($id);
            $validated = $request->validate([
                'bills' => "required|unique:bills,bills,$decrypted_id,id,deleted_at,NULL",
                'notes' => 'required'
            ]);

            DB::beginTransaction();
            try {
                $special_need = Bills::findOrFail($decrypted_id);
                $special_need->bills = $validated['bills'];
                $special_need->notes = $validated['notes'];
                $special_need->looping = isset($request->looping) ? 1 : 0;
                $special_need->save();
                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('bills');
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
        if (in_array('29', $session_menu)) {
            DB::beginTransaction();
            try {
                $bills = Bills::findOrFail(Crypt::decryptString($id));
                $bills->delete();
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
