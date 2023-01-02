<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PrimessionController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('43', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'hak akses',
                'label' => 'data hak akses',
            ];
            return view('primession.list')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function data_primession(Request $request)
    {
        $user = User::select(['*'])->where('aktif', '=', '1')->whereNotNull('email_verified_at');
        return DataTables::of($user)
            ->addColumn('status', function ($model) {
                $model->aktif === '1' ? $flag = 'success' : $flag = 'danger';
                $model->aktif === '1' ? $status = 'Aktif' : $status = 'Non Aktif';
                return '<span  class="badge badge-pill badge-soft-' . $flag . ' font-size-12">' . $status . '</span>';
            })
            ->addColumn('action', 'primession.button')
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

    public function edit($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('44', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $user = User::where(['id' => $id_decrypted])->firstOrFail();

            if (Auth::user()->roles == 'Administrator') {
                $where =  ['menu.id', '>', '0'];
            } else {
                $where =  ['menu.id', '!=', '13'];
            }

            $primession = DB::table('submenu')
                ->select(
                    'menu',
                    'submenu',
                    DB::raw("MAX(CASE WHEN type_menu like '%insert%' THEN submenu.id ELSE NULL END) AS inserts"),
                    DB::raw("MAX(CASE WHEN type_menu like '%edit%' THEN submenu.id ELSE NULL END) AS edits"),
                    DB::raw("MAX(CASE WHEN type_menu like '%view%' THEN submenu.id ELSE NULL END) AS views"),
                    DB::raw("MAX(CASE WHEN type_menu like '%delete%' THEN submenu.id ELSE NULL END) AS deletes"),
                    DB::raw("MAX(CASE WHEN type_menu like '%approve%' THEN submenu.id ELSE NULL END) AS approves"),
                )
                ->Join('menu', 'menu.id', 'submenu.menu_id')
                ->where([$where])
                ->where('menu.display', '1')
                ->groupBy('menu_id')
                ->groupBy('submenu.submenu')
                ->orderBy('menu.order_menu', 'ASC')
                ->orderBy('submenu.order_submenu', 'ASC')
                ->get();
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'hak akses',
                'label' => 'data hak akses',
                'user' => $user,
                'primession' => $primession,
            ];
            return view('primession.primession')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function update(Request $request, $id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('44', $session_menu)) {
            $akses_id = ($request->akses_id > 0) ? implode(',', $request->akses_id) : ' ';
            DB::beginTransaction();
            try {
                $session_submenu = explode(',', $akses_id);
                $arr = array();
                foreach ($session_submenu as $item) {
                    $menu = DB::table('submenu')
                        ->select('menu_id')->where('id', $item)
                        ->get();
                    array_push($arr, $menu[0]->menu_id);
                }
                $user = User::findOrFail(Crypt::decryptString($id));
                $user->akses_menu = implode(",", array_unique($arr));
                $user->akses_submenu = $akses_id;
                $user->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('/primession');
            } catch (\Throwable $err) {
                DB::rollback();
                throw $err;
                AlertHelper::updateAlert(false);
                return back();
            }
        } else {
            return view('not_found');
        }
    }
}
