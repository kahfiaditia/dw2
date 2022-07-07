<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Bills;
use App\Models\Classes;
use App\Models\Invoice;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'pembayaran';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::orderBy('id', 'DESC')->get();
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data ' . $this->submenu,
            'invoice' => $invoice
        ];
        return view('invoice.index')->with($data);
    }

    public function list_invoice(Request $request)
    {
        $invoice = DB::table('invoice')
            ->select('invoice.id', 'year', 'month', 'invoice.amount', 'bills', 'nama_lengkap', 'classes.*')
            ->leftjoin('bills', 'bills.id', '=', 'invoice.bills_id')
            ->leftjoin('classes', 'classes.id', '=', 'invoice.class_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'invoice.siswa_id')
            ->whereNull('invoice.deleted_at')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        return DataTables::of($invoice)
            ->addColumn('tahun', function ($invoice) {
                return $invoice->year;
            })
            ->addColumn('bulan', function ($invoice) {
                return date('F', mktime(0, 0, 0, $invoice->month, 10));
            })
            ->addColumn('pembayaran', function ($invoice) {
                return $invoice->bills;
            })
            ->addColumn('biaya', function ($invoice) {
                return $invoice->amount;
            })
            ->addColumn('siswa', function ($invoice) {
                return $invoice->nama_lengkap;
            })
            ->addColumn('jenjang', function ($invoice) {
                return $invoice->jenjang;
            })
            ->addColumn('kelas', function ($invoice) {
                if ($invoice->type) {
                    $kelas = $invoice->class . ' - [ ' . $invoice->type . ' ]';
                } else {
                    $kelas = $invoice->class;
                }
                return $kelas;
            })
            ->addColumn('action', 'invoice.button')
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
            'bills' => Bills::orderBY('bills', 'ASC')->get(),
        ];
        return view('invoice.create')->with($data);
    }

    public function get_jenjang(Request $request)
    {
        $kelas = DB::table('classes')
            ->select('classes.id', 'level', 'school_class.classes', 'jurusan', 'type')
            ->join('school_class', 'school_class.id', '=', 'classes.class_id')
            ->join('school_level', 'school_level.id', '=', 'school_class.school_level_id')
            ->get();
        if (count($kelas) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $kelas,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function get_siswa(Request $request)
    {
        $siswa = DB::table('siswa')
            ->select('siswa.id', 'siswa.nama_lengkap')
            ->join('classes', 'classes.id', '=', 'siswa.class_id')
            ->where('classes.id', '=', $request->class_jenjang)
            ->get();
        if (count($siswa) > 0) {
            return response()->json([
                'code' => 200,
                'data' => $siswa,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => null,
            ]);
        }
    }

    public function cek_siswa_manual(Request $request)
    {
        return redirect('search/' . Crypt::encryptString($request->siswa_id) . '/' . $request->year . '/' . $request->month . '/' . $request->bills_id);
    }

    public function search($siswa_id = null, $year = null, $month = null, $payment = null)
    {
        $student = Siswa::findorfail(Crypt::decryptString($siswa_id));
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'tambah ' . $this->submenu,
            'students' => $student,
            'invoice' => Invoice::where('siswa_id', $student->id)->get(),
        ];
        return view('invoice.search')->with($data);
    }

    // -----------------------------------------------------------------------------------------------------------------------------------------------------






















    public function get_class(Request $request)
    {
        $class = DB::table('siswa')
            ->select('classes.*', 'siswa.class_id')
            ->join('classes', 'classes.id', '=', 'siswa.class_id')
            ->where('siswa.id', '=', $request->siswa_id)
            ->where('classes.jenjang', '=', $request->jenjang)
            ->get();
        return $class;
    }

    public function get_payment(Request $request)
    {
        $payment = DB::table('payment')
            ->select('payment.amount')
            ->join('bills', 'bills.id', '=', 'payment.bills_id')
            ->join('classes', 'classes.id', '=', 'payment.class_id')
            ->where('payment.year', '=', $request->year)
            ->where('bills.id', '=', $request->bills_id)
            ->where('classes.jenjang', '=', $request->jenjang)
            ->get();
        if (count($payment) > 0) {
            return $payment[0]->amount;
        } else {
            return null;
        }
    }

    public function cek_payment(Request $request)
    {
        if ($request->payment_value == 'SPP') {
            $invoice = DB::table('invoice')
                ->select('invoice.id')
                ->join('bills', 'bills.id', '=', 'invoice.bills_id')
                ->join('classes', 'classes.id', '=', 'invoice.class_id')
                ->where('invoice.year', '=', $request->year)
                ->where('invoice.month', '=', $request->month)
                ->where('invoice.bills_id', '=', $request->bills_id)
                ->where('invoice.siswa_id', '=', $request->siswa_id)
                ->where('classes.jenjang', '=', $request->jenjang)
                ->get();
        } else {
            $invoice = DB::table('invoice')
                ->select('invoice.id')
                ->join('bills', 'bills.id', '=', 'invoice.bills_id')
                ->join('classes', 'classes.id', '=', 'invoice.class_id')
                ->where('invoice.year', '=', $request->year)
                ->where('invoice.bills_id', '=', $request->bills_id)
                ->where('invoice.siswa_id', '=', $request->siswa_id)
                ->where('classes.jenjang', '=', $request->jenjang)
                ->get();
        }
        return response()->json([
            'code' => 402,
            'count' => count($invoice),
        ]);
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
            'year' => 'required',
            'month' => 'required',
            'bills_id' => 'required',
            'class_id' => 'required',
            'siswa_id' => 'required',
            'class_siswa' => 'required',
            'amount' => 'required',
            'jenjang' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Invoice::create([
                'year' => $validated['year'],
                'month' => $validated['month'],
                'bills_id' => $validated['bills_id'],
                'class_id' => $validated['class_id'],
                'siswa_id' => $validated['siswa_id'],
                'amount' => str_replace(",", "", $validated['amount']),
            ]);
            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('invoice');
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
        $invoice = Invoice::findOrFail(Crypt::decryptString($id));
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'Edit ' . $this->submenu,
            'invoice' => $invoice,
            'bills' => Bills::orderBY('bills', 'ASC')->get(),
            'students' => Siswa::all(),
            'classes' => Classes::groupBY('jenjang')->orderByRaw("FIELD(jenjang, 'TK', 'SD', 'SMP', 'SMA', 'SMK')")->get(),
        ];
        return view('invoice.edit')->with($data);
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
            'year' => 'required',
            'month' => 'required',
            'amount' => 'required',
            'bills_id' => 'required',
            'siswa_id' => 'required',
            'class_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($decrypted_id);
            $invoice->year = $validated['year'];
            $invoice->month = $validated['month'];
            $invoice->bills_id = $validated['bills_id'];
            $invoice->siswa_id = $validated['siswa_id'];
            $invoice->class_id = $validated['class_id'];
            $invoice->amount = str_replace(",", "", $validated['amount']);
            $invoice->save();
            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('invoice');
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
            $delete = Invoice::findOrFail(Crypt::decryptString($id));
            $delete->delete();
            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }
}
