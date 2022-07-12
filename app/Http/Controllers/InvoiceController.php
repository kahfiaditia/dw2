<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Bills;
use App\Models\Classes;
use App\Models\Invoice;
use App\Models\Payment;
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
            ->select('invoice.id', 'invoice.created_at', 'year', 'year_end', 'month', 'invoice.amount', 'bills', 'nama_lengkap', 'level', 'classes', 'jurusan', 'type', 'nisn', 'nik')
            ->leftjoin('bills', 'bills.id', '=', 'invoice.bills_id')
            ->leftjoin('classes', 'classes.id', '=', 'invoice.class_id')
            ->leftjoin('school_level', 'school_level.id', '=', 'classes.id_school_level')
            ->leftjoin('school_class', 'school_class.id', '=', 'classes.class_id')
            ->leftjoin('siswa', 'siswa.id', '=', 'invoice.siswa_id')
            ->whereNull('invoice.deleted_at')
            ->orderBy('invoice.id', 'desc')
            ->get();
        return DataTables::of($invoice)
            ->addColumn('tahun', function ($invoice) {
                return $invoice->year . '/' . $invoice->year_end;
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
            ->addColumn('nik', function ($invoice) {
                return $invoice->nisn . '/' . $invoice->nik;
            })
            ->addColumn('siswa', function ($invoice) {
                return $invoice->nama_lengkap;
            })
            ->addColumn('tanggal', function ($invoice) {
                return $invoice->created_at;
            })
            ->addColumn('jenjang', function ($invoice) {
                return $invoice->level . ' ' . $invoice->classes . ' ' . $invoice->jurusan . '.' . $invoice->type;
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

    public function pencarian_siswa(Request $request)
    {
        if ($request->siswa_id) {
            $siswa_id = Crypt::encryptString($request->siswa_id);
        } elseif ($request->nik or $request->nisn) {
            $where = [];
            if ($request->nik) {
                $nik = array('nik' => $request->nik);
                array_push($where, $nik);
            } else {
                $nik = array();
            }
            if ($request->nisn) {
                $nisn = array('nisn' => $request->nisn);
                array_push($where, $nisn);
            } else {
                $nisn = array();
            }
            $where = $nik + $nisn;
            $siswa = Siswa::where($where)->first();
            if ($siswa) {
                $siswa_id = Crypt::encryptString($siswa->id);
            } else {
                return back()->with('logError', 'Pencarian data tidak ditemukan.');
            }
        } else {
            return back()->with('logError', "Salah satu data pencarian Siswa/NISN/NIK/NIS wajib diisi.");
        }
        return redirect('search/' . $siswa_id);
    }

    public function search($siswa_id)
    {
        $student = Siswa::findorfail(Crypt::decryptString($siswa_id));
        // cek histori uang formulir
        $invoice_tahunan = DB::table('invoice')
            ->selectRaw("sum(CASE WHEN bills = 'Uang Formulir' THEN amount ELSE 0 END) AS formulir, sum(CASE WHEN bills = 'Uang Pangkal' THEN amount ELSE 0 END) AS pangkal")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', Crypt::decryptString($siswa_id))
            ->first();
        // cek histori uang pangkal
        $invoice_bulanan = DB::table('invoice')
            ->selectRaw("group_concat(DISTINCT `month` separator ',') AS bulan, count(DISTINCT month) count_bulan")
            ->selectRaw("sum(CASE WHEN bills = 'SPP' THEN amount ELSE 0 END) AS uang_spp, sum(CASE WHEN bills = 'Uang Kegiatan' THEN amount ELSE 0 END) AS uang_kegiatan")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', Crypt::decryptString($siswa_id))
            ->where(function ($query) use ($student) {
                $query->where('payment_id', '=', $student->spp_id)
                    ->orWhere('payment_id', '=', $student->kegiatan_id);
            })
            ->where('year', $student->spp->year)
            ->where('year_end', $student->spp->year_end)
            ->first();
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'tambah ' . $this->submenu,
            'students' => $student,
            'invoice_tahunan' => $invoice_tahunan,
            'invoice_bulanan' => $invoice_bulanan,
        ];
        return view('invoice.search')->with($data);
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
            'nik' => 'required',
            'siswa' => 'required',
            'tahun_ajaran_start' => 'required',
            'tahun_ajaran_end' => 'required',
        ]);
        $total = $request->hiddenPangkal + $request->hiddenFormulir + $request->hiddenSpp + $request->hiddenKegiatan;
        if ($total <= 0) {
            AlertHelper::nullValidation(false);
            return back();
        }
        DB::beginTransaction();
        try {
            // pembayaran uang formulir
            if ($request->hiddenFormulir) {
                $payment = Payment::findorfail($request->PaymentIdFormulir);
                $cek_invoice_formulir = Invoice::where('siswa_id', Crypt::decryptString($request->studentsId))->where('bills_id', $payment->bills_id)->sum('amount');
                if (($cek_invoice_formulir + $request->hiddenFormulir) > $request->UangFormulir) {
                    AlertHelper::paymentValidation(false);
                    return back();
                }
                Invoice::create([
                    'year' => $request->tahun_ajaran_start,
                    'year_end' => $request->tahun_ajaran_end,
                    'amount' => $request->hiddenFormulir,
                    'payment_id' => $request->PaymentIdFormulir,
                    'bills_id' => $payment->bills_id,
                    'siswa_id' => Crypt::decryptString($request->studentsId),
                    'class_id' => Crypt::decryptString($request->classId),
                ]);
            }
            // pembayaran uang pangkal
            if ($request->hiddenPangkal) {
                $payment = Payment::findorfail($request->PaymentIdPangkal);
                $cek_invoice_pangkal = Invoice::where('siswa_id', Crypt::decryptString($request->studentsId))->where('bills_id', $payment->bills_id)->sum('amount');
                if (($cek_invoice_pangkal + $request->hiddenPangkal) > $request->UangPangkal) {
                    AlertHelper::paymentValidation(false);
                    return back();
                }
                Invoice::create([
                    'year' => $request->tahun_ajaran_start,
                    'year_end' => $request->tahun_ajaran_end,
                    'amount' => $request->hiddenPangkal,
                    'payment_id' => $request->PaymentIdPangkal,
                    'bills_id' => $payment->bills_id,
                    'siswa_id' => Crypt::decryptString($request->studentsId),
                    'class_id' => Crypt::decryptString($request->classId),
                ]);
            }
            // pembayaran bulanan
            if ($request->bulan != null) {
                for ($i = 0; $i < count($request->bulan); $i++) {
                    $spp = Payment::findorfail($request->SPP_id);
                    Invoice::create([
                        'year' => $request->tahun_ajaran_start,
                        'year_end' => $request->tahun_ajaran_end,
                        'month' => $request->bulan[$i],
                        'amount' => $request->SPP,
                        'payment_id' => $request->SPP_id,
                        'bills_id' => $spp->bills_id,
                        'siswa_id' => Crypt::decryptString($request->studentsId),
                        'class_id' => Crypt::decryptString($request->classId),
                    ]);
                    $kegiatan = Payment::findorfail($request->Kegiatan_id);
                    Invoice::create([
                        'year' => $request->tahun_ajaran_start,
                        'year_end' => $request->tahun_ajaran_end,
                        'month' => $request->bulan[$i],
                        'amount' => $request->UangKegiatan,
                        'payment_id' => $request->Kegiatan_id,
                        'bills_id' => $kegiatan->bills_id,
                        'siswa_id' => Crypt::decryptString($request->studentsId),
                        'class_id' => Crypt::decryptString($request->classId),
                    ]);
                }
            }
            DB::commit();
            AlertHelper::addAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
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
}
