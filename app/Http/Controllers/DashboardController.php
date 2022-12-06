<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'beranda';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->roles == 'Orang Tua') {
        } elseif (Auth::user()->roles == 'Siswa') {
            if (Auth::user()->student != null) {
                $siswa = Siswa::findorfail(Auth::user()->student->id);
                if ($siswa->uang_formulir) {
                    $invoice = Invoice::where('siswa_id', Auth::user()->student->id)->get();
                    $invoice_tahunan = Invoice::where('siswa_id', Auth::user()->student->id)
                        ->where(function ($query) use ($siswa) {
                            $query->where('payment_id', $siswa->uang_formulir->id)
                                ->orWhere('payment_id', '=', $siswa->uang_pangkal->id);
                        })
                        ->orderBY('id', 'desc')
                        ->sum('amount');

                    $invoice_bulan = Invoice::where('siswa_id', Auth::user()->student->id)
                        ->where(function ($query) use ($siswa) {
                            $query->where('payment_id', $siswa->spp->id)
                                ->orWhere('payment_id', '=', $siswa->kegiatan->id);
                        })
                        ->orderBY('id', 'desc')
                        ->sum('amount');
                } else {
                    $invoice = [];
                    $invoice_tahunan = [];
                    $invoice_bulan = [];
                }
                $count_karyawan = null;
                $count_guru = null;
                $count_siswa = null;
            } else {
                $siswa = [];
                $invoice = [];
                $invoice_tahunan = [];
                $invoice_bulan = [];
                $count_karyawan = null;
                $count_guru = null;
                $count_siswa = null;
            }
        } else {
            $siswa = [];
            $invoice = [];
            $invoice_tahunan = [];
            $invoice_bulan = [];
            $count_karyawan = Employee::where('jabatan', 'Karyawan')->count('id');
            $count_guru = Employee::where('jabatan', 'Guru')->count('id');
            $count_siswa = Siswa::count();
        }

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'label' => $this->menu,
            'siswa' => $siswa,
            'invoice' => $invoice,
            'invoice_tahunan' => $invoice_tahunan,
            'invoice_bulan' => $invoice_bulan,
            'count_siswa' => $count_siswa,
            'count_karyawan' => $count_karyawan,
            'count_guru' => $count_guru,
        ];
        return view('dashboard.dashboard')->with($data);
    }

    public function history_payment($student_id)
    {
        $student = Siswa::findorfail(Crypt::decryptString($student_id));
        $invoice = Invoice::where('siswa_id', Auth::user()->student->id)->orderBY('id', 'desc')->get();
        // cek histori uang formulir
        $invoice_tahunan = DB::table('invoice')
            ->selectRaw("sum(CASE WHEN bills = 'Uang Formulir' THEN amount ELSE 0 END) AS formulir, sum(CASE WHEN bills = 'Uang Pangkal' THEN amount ELSE 0 END) AS pangkal")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', Crypt::decryptString($student_id))
            ->first();
        // cek histori uang pangkal
        $invoice_bulanan = DB::table('invoice')
            ->selectRaw("group_concat(DISTINCT `month` separator ',') AS bulan, count(DISTINCT month) count_bulan")
            ->selectRaw("sum(CASE WHEN bills = 'SPP' THEN amount ELSE 0 END) AS uang_spp, sum(CASE WHEN bills = 'Uang Kegiatan' THEN amount ELSE 0 END) AS uang_kegiatan")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', Crypt::decryptString($student_id))
            ->where(function ($query) use ($student) {
                $query->where('payment_id', '=', $student->spp_id)
                    ->orWhere('payment_id', '=', $student->kegiatan_id);
            })
            ->where('year', $student->spp->year)
            ->where('year_end', $student->spp->year_end)
            ->first();
        $data = [
            'title' => 'rincian Pembayaran',
            'menu' => $this->menu,
            'submenu' => 'rincian Pembayaran',
            'label' => 'rincian Pembayaran',
            'students' => $student,
            'invoice' => $invoice,
            'invoice_tahunan' => $invoice_tahunan,
            'invoice_bulanan' => $invoice_bulanan,
        ];
        return view('dashboard.history_payment')->with($data);
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
     * @param  \App\Models\Dashboard  $Dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $Dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $Dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $Dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $Dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $Dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $Dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $Dashboard)
    {
        //
    }

    public function tema(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($request->button == 'dark' or $request->button == 'light') {
            $user->menu_tema = $request->button;
        } elseif ($request->button == 'text' or $request->button == 'icon') {
            $user->menu_icon = $request->button;
        }
        $user->save();

        return response()->json([
            'code' => 200,
        ]);
    }

    public function phpinfo()
    {
        echo phpinfo();
    }
}
