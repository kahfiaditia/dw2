<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Kodepos;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting website';
    protected $submenu = 'maintenance';


    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('45', $session_menu)) {
            $settings = Setting::orderBy('id', 'DESC')->get();
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data ' . $this->submenu,
                'settings' => $settings
            ];
            return view('setting.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function create()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('45', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'tambah ' . $this->submenu,
                'provinsi' => Kodepos::orderBy('provinsi', 'ASC')->groupBy('provinsi')->get()
            ];
            return view('setting.create')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function store(Request $request)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('45', $session_menu)) {
            $request->validate([
                'provinsi_sekolah' => 'required',
                'library_loan_day' => 'max:1',
                'library_loan_validation' => 'max:1',
            ]);

            DB::beginTransaction();
            try {
                $setting = new Setting();
                $setting->maintenance = isset($request->maintenance) ? 1 : null;
                $setting->provinsi_sekolah = $request->provinsi_sekolah;
                $setting->library_loan_day = $request->library_loan_day;
                $setting->library_loan_validation = $request->library_loan_validation;
                $setting->save();
                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('setting');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('45', $session_menu)) {
            $setting = Setting::findOrFail(Crypt::decryptString($id));
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'ubah ' . $this->submenu,
                'setting' => $setting,
                'provinsi' => Kodepos::orderBy('provinsi', 'ASC')->groupBy('provinsi')->get()
            ];
            return view('setting.edit')->with($data);
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
        if (in_array('45', $session_menu)) {
            $request->validate([
                'provinsi_sekolah' => 'required',
                'library_loan_day' => 'max:1',
                'library_loan_validation' => 'max:1',
            ]);

            $decrypted_id = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $setting = Setting::findOrFail($decrypted_id);
                $setting->maintenance = isset($request->maintenance) ? 1 : 0;
                $setting->provinsi_sekolah = $request->provinsi_sekolah;
                $setting->library_loan_day = $request->library_loan_day;
                $setting->library_loan_validation = $request->library_loan_validation;
                $setting->save();
                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('setting');
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
        //
    }
}
