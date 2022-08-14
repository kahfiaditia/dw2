<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Bills;
use App\Models\Payment;
use App\Models\School_class;
use App\Models\School_level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'setting pembayaran';

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
            'submenu' => $this->submenu,
            'label' => 'data ' . $this->submenu,
        ];
        return view('payment.index')->with($data);
    }

    public function list_payment(Request $request)
    {
        $payment = Payment::orderBy('id', 'DESC')->get();
        return DataTables::of($payment)
            ->addColumn('tahun', function ($payment) {
                return $payment->year . '/' . $payment->year_end;
            })
            ->addColumn('level', function ($payment) {
                return  $payment->schools_level->level;
            })
            ->addColumn('classes', function ($payment) {
                return $payment->schools_class ? $payment->schools_class->classes : '';
            })
            ->addColumn('bills', function ($payment) {
                return $payment->bills->bills;
            })
            ->addColumn('amount', function ($payment) {
                return $payment->amount;
            })
            ->addColumn('action', 'payment.button')
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
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'tambah ' . $this->submenu,
            'classes' => School_level::all(),
            'bills' => Bills::orderByRaw("FIELD(bills, 'SPP', 'Uang Kegiatan', 'Uang Pangkal', 'Uang Formulir')")->get(),
        ];
        return view('payment.create')->with($data);
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
            'tahun' => 'required',
            'school_level_id' => 'required',
            'bills_id' => 'required',
            'amount' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $cek = Payment::where('year', $request->tahun)
                ->where('school_level_id', $request->school_level_id)
                ->where('school_class_id', $request->class_id)
                ->where('bills_id', $request->bills_id)
                ->count();
            if ($cek > 0) {
                AlertHelper::addDuplicate(false);
                return back();
            }
            Payment::create([
                'year' => $validated['tahun'],
                'year_end' => $validated['tahun'] + 1,
                'school_level_id' => $validated['school_level_id'],
                'school_class_id' => $request->class_id,
                'bills_id' => $validated['bills_id'],
                'amount' => str_replace(".", "", $validated['amount']),
                'user_created' => Auth::user()->id,
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('payment');
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
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
        $payment = Payment::findOrFail(Crypt::decryptString($id));
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'Ubah ' . $this->submenu,
            'classes' => School_level::all(),
            'kelas' => School_class::where('school_level_id', $payment->school_level_id)->get(),
            'bills' => Bills::orderByRaw("FIELD(bills, 'SPP', 'Uang Kegiatan', 'Uang Pangkal', 'Uang Formulir')")->get(),
            'payment' => $payment,
        ];
        return view('payment.edit')->with($data);
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
        $decrypted_id = Crypt::decryptString($id);
        $validated = $request->validate([
            'tahun' => 'required',
            'school_level_id' => 'required',
            'bills_id' => 'required',
            'amount' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $payment = Payment::findOrFail($decrypted_id);
            $payment->year = $validated['tahun'];
            $payment->year_end = $validated['tahun'] + 1;
            $payment->school_level_id = $validated['school_level_id'];
            $payment->school_class_id = $request->class_id;
            $payment->bills_id = $validated['bills_id'];
            $payment->amount = str_replace(".", "", $validated['amount']);
            $payment->user_updated = Auth::user()->id;
            $payment->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('payment');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
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
        DB::beginTransaction();
        try {
            $delete = Payment::findOrFail(Crypt::decryptString($id));
            $delete->user_deleted = Auth::user()->id;
            $delete->deleted_at = Carbon::now();
            $delete->save();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function get_class_payment(Request $request)
    {
        $kelas = DB::table('school_class')
            ->where('school_level_id', $request->school_level_id)
            ->get();
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
