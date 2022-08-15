<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Bills;
use App\Models\Diskon;
use App\Models\Diskon_prestasi;
use App\Models\Invoice;
use App\Models\Invoice_header;
use App\Models\Payment;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    protected $title = 'dharmawidya';
    protected $sid = 'SID';
    protected $menu = 'pembayaran';

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
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'data ' . $this->menu,
            'invoice' => $invoice
        ];
        return view('invoice.index')->with($data);
    }

    public function list_invoice(Request $request)
    {
        $invoice = Invoice_header::all();
        return DataTables::of($invoice)
            ->addColumn('nik', function ($invoice) {
                return $invoice->siswa->nis;
            })
            ->addColumn('siswa', function ($invoice) {
                return $invoice->siswa->nama_lengkap;
            })
            ->addColumn('tanggal', function ($invoice) {
                return $invoice->date_header;
            })
            ->addColumn('pembayaran', function ($invoice) {
                return $invoice->formulir + $invoice->uang_pangkal + $invoice->uang_spp + $invoice->uang_kegiatan;
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
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'tambah ' . $this->menu,
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
        } elseif ($request->nik or $request->nisn or $request->nis) {
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
            if ($request->nis) {
                $nis = array('nis' => str_replace("-", "", $request->nis));
                array_push($where, $nis);
            } else {
                $nis = array();
            }
            $where = $nik + $nisn + $nis;
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
        $siswaId = Crypt::decryptString($siswa_id);
        $student = Siswa::findorfail($siswaId);
        // cek histori uang formulir
        $invoice_tahunan = DB::table('invoice')
            ->selectRaw("sum(CASE WHEN bills = 'Uang Formulir' THEN amount ELSE 0 END) AS formulir, sum(CASE WHEN bills = 'Uang Pangkal' THEN amount ELSE 0 END) AS pangkal")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', $siswaId)
            ->first();
        $diskon = Diskon::where('type_diskon', '=', 1)->get();
        $prestasi = Diskon_prestasi::where('siswa_id', $siswaId)->where('end_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'DESC')->first();
        if ($prestasi != null and $prestasi->invoice_prestasi != null) {
            if ($prestasi->diskon->diskon_bln == $prestasi->invoice_prestasi->wherenotnull('prestasi_id')->count()) {
                $prestasi = [];
            }
        }
        if ($student->spp) {
            // cek histori uang spp
            $invoice_bulanan = DB::table('invoice')
                ->selectRaw("group_concat(DISTINCT `month` separator ',') AS bulan, count(DISTINCT month) count_bulan")
                ->selectRaw("sum(CASE WHEN bills = 'SPP' THEN amount ELSE 0 END) AS uang_spp")
                ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
                ->whereNull('invoice.deleted_at')
                ->where('siswa_id', $siswaId)
                ->where(function ($query) use ($student) {
                    $query->where('payment_id', '=', $student->spp_id);
                })
                ->where('year', $student->spp->year)
                ->where('year_end', $student->spp->year_end)
                ->first();
            // cek histori uang kegiatan
            $invoice_kegiatan = DB::table('invoice')
                ->selectRaw("group_concat(DISTINCT `month` separator ',') AS kegiatan, count(DISTINCT month) count_kegiatan")
                ->selectRaw("sum(CASE WHEN bills = 'Uang Kegiatan' THEN amount ELSE 0 END) AS uang_kegiatan")
                ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
                ->whereNull('invoice.deleted_at')
                ->where('siswa_id', $siswaId)
                ->where(function ($query) use ($student) {
                    $query->Where('payment_id', '=', $student->kegiatan_id);
                })
                ->where('year', $student->spp->year)
                ->where('year_end', $student->spp->year_end)
                ->first();
        } else {
            AlertHelper::alertDinamis(false, 'Siswa belum disetting pembayaran');
            return redirect('invoice/create');
        }
        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => 'tambah ' . $this->menu,
            'students' => $student,
            'invoice_tahunan' => $invoice_tahunan,
            'invoice_bulanan' => $invoice_bulanan,
            'invoice_kegiatan' => $invoice_kegiatan,
            'prestasi' => $prestasi,
            'diskon' => $diskon,
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
        // dd($request);
        $registration_number = Invoice_header::pluck('no_invoice')->last();
        $no_date = Carbon::now()->format('ymd');
        if (!$registration_number) {
            $no_invoice = "INV" . $no_date . sprintf('%04d', 1);
        } else {
            $last_number = (int)substr($registration_number, 9);
            $day = (int)substr($registration_number, 7, 2);
            $day_now = Carbon::now()->format('d');
            if ($day != $day_now) {
                $no_invoice = "INV" . $no_date . sprintf('%04d', 1);
            } else {
                $no_invoice = "INV" . $no_date . sprintf('%04d', $last_number + 1);
            }
        }
        $total = $request->hiddenPangkal + $request->hiddenFormulir + $request->hiddenSpp + $request->hiddenKegiatan - $request->hiddendiskonPembayaran;
        if ($total <= 0) {
            AlertHelper::nullValidation(false);
            return back();
        }
        DB::beginTransaction();
        try {
            $date_transaksi = Carbon::now();

            $Invoice_header = new Invoice_header();
            $Invoice_header->no_invoice = $no_invoice;
            $Invoice_header->date_header = $date_transaksi;
            $Invoice_header->uang_formulir = $request->hiddenFormulir;
            $Invoice_header->uang_pangkal = $request->hiddenPangkal;
            $Invoice_header->spp_id = $request->SPP_id;
            $Invoice_header->uang_spp = $request->hiddenSpp;
            $Invoice_header->kegiatan_id = $request->Kegiatan_id;
            $Invoice_header->uang_kegiatan = $request->hiddenKegiatan;
            $Invoice_header->diskon_id = ($request->hiddendiskonPembayaran) ? $request->formRadios : null;
            $Invoice_header->diskon_pembayaran = $request->hiddendiskonPembayaran;
            $Invoice_header->prestasi_id = $request->idPrestasi;
            $Invoice_header->diskon_prestasi = $request->valueDiskonPrestasi;
            $Invoice_header->grand_total = $request->grand_total;
            $Invoice_header->siswa_id = Crypt::decryptString($request->studentsId);
            $Invoice_header->user_created =  Auth::user()->id;
            $Invoice_header->save();
            $invoice_header_id = $Invoice_header->id;

            // pembayaran uang formulir
            if ($request->hiddenFormulir) {
                $payment = Payment::findorfail($request->PaymentIdFormulir);
                $cek_invoice_formulir = Invoice::where('siswa_id', Crypt::decryptString($request->studentsId))->where('bills_id', $payment->bills_id)->sum('amount');
                if (($cek_invoice_formulir + $request->hiddenFormulir) > $request->UangFormulir) {
                    AlertHelper::paymentValidation(false);
                    return back();
                }
                Invoice::create([
                    'year' => $payment->year,
                    'year_end' => $payment->year_end,
                    'amount' => $request->hiddenFormulir,
                    'payment_id' => $request->PaymentIdFormulir,
                    'bills_id' => $payment->bills_id,
                    'siswa_id' => Crypt::decryptString($request->studentsId),
                    'class_id' => Crypt::decryptString($request->classId),
                    'user_created' => Auth::user()->id,
                    'date_transaksi' => $date_transaksi,
                    'invoice_header_id' => $invoice_header_id,
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
                    'year' => $payment->year,
                    'year_end' => $payment->year_end,
                    'amount' => $request->hiddenPangkal,
                    'payment_id' => $request->PaymentIdPangkal,
                    'bills_id' => $payment->bills_id,
                    'siswa_id' => Crypt::decryptString($request->studentsId),
                    'class_id' => Crypt::decryptString($request->classId),
                    'user_created' => Auth::user()->id,
                    'date_transaksi' => $date_transaksi,
                    'invoice_header_id' => $invoice_header_id,
                ]);
            }
            // pembayaran bulanan
            if ($request->bulan != null) {
                for ($i = 0; $i < count($request->bulan); $i++) {
                    if ($request->hiddendiskonPembayaran and $i == 0) {
                        $diskon_id = $request->formRadios;
                        $hiddendiskonPembayaran = $request->hiddendiskonPembayaran;
                    } else {
                        $diskon_id = null;
                        $hiddendiskonPembayaran = null;
                    }
                    $prestasi_id = $request->idPrestasi;
                    if ($request->valueDiskonPrestasi and $i == 0) {
                        $amount_diskon_prestasi = $request->valueDiskonPrestasi;
                    } else {
                        $amount_diskon_prestasi = null;
                    }
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
                        'user_created' => Auth::user()->id,
                        'diskon_id' => $diskon_id,
                        'amount_diskon_pembayaran' => $hiddendiskonPembayaran,
                        'prestasi_id' => $prestasi_id,
                        'amount_diskon_prestasi' => $amount_diskon_prestasi,
                        'date_transaksi' => $date_transaksi,
                        'invoice_header_id' => $invoice_header_id,
                    ]);
                }
            }
            // pembayaran kegiatan
            if ($request->kegiatan != null) {
                for ($i = 0; $i < count($request->kegiatan); $i++) {
                    $kegiatan = Payment::findorfail($request->Kegiatan_id);
                    Invoice::create([
                        'year' => $request->tahun_ajaran_start,
                        'year_end' => $request->tahun_ajaran_end,
                        'month' => $request->kegiatan[$i],
                        'amount' => $request->UangKegiatan,
                        'payment_id' => $request->Kegiatan_id,
                        'bills_id' => $kegiatan->bills_id,
                        'siswa_id' => Crypt::decryptString($request->studentsId),
                        'class_id' => Crypt::decryptString($request->classId),
                        'user_created' => Auth::user()->id,
                        'date_transaksi' => $date_transaksi,
                        'invoice_header_id' => $invoice_header_id,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invHeader = Invoice_header::findorfail(Crypt::decryptString($id));
        $siswaId = $invHeader->siswa_id;

        $student = Siswa::findorfail($siswaId);

        // cek histori uang formulir
        $invoice_tahunan = DB::table('invoice')
            ->selectRaw("sum(CASE WHEN bills = 'Uang Formulir' THEN amount ELSE 0 END) AS formulir, sum(CASE WHEN bills = 'Uang Pangkal' THEN amount ELSE 0 END) AS pangkal")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', $siswaId)
            ->first();
        $diskon = Diskon::where('type_diskon', '=', 1)->get();
        $prestasi = Diskon_prestasi::where('siswa_id', $siswaId)->where('id', $invHeader->prestasi_id)->first();

        // cek histori uang spp
        $invoice_bulanan = DB::table('invoice')
            ->selectRaw("group_concat(DISTINCT `month` separator ',') AS bulan, count(DISTINCT month) count_bulan")
            ->selectRaw("sum(CASE WHEN bills = 'SPP' THEN amount ELSE 0 END) AS uang_spp")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', $siswaId)
            ->where('invoice_header_id', $invHeader->id)
            ->where('payment_id', $invHeader->spp_id)
            ->first();

        // cek histori uang kegiatan
        $invoice_kegiatan = DB::table('invoice')
            ->selectRaw("group_concat(DISTINCT `month` separator ',') AS kegiatan, count(DISTINCT month) count_kegiatan")
            ->selectRaw("sum(CASE WHEN bills = 'Uang Kegiatan' THEN amount ELSE 0 END) AS uang_kegiatan")
            ->Join('bills', 'bills.id', '=', 'invoice.bills_id')
            ->whereNull('invoice.deleted_at')
            ->where('siswa_id', $siswaId)
            ->where('invoice_header_id', $invHeader->id)
            ->where('payment_id', $invHeader->kegiatan_id)
            ->first();

        $data = [
            'title' => $this->title,
            'menu' => $this->sid,
            'submenu' => $this->menu,
            'label' => $this->menu,
            'invoice' => $invHeader,
            'students' => $student,
            'invoice_tahunan' => $invoice_tahunan,
            'prestasi' => $prestasi,
            'diskon' => $diskon,
            'invoice_bulanan' => $invoice_bulanan,
            'invoice_kegiatan' => $invoice_kegiatan,
        ];

        return view('invoice.show')->with($data);
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
            $datetime = Carbon::now();

            Invoice::where('invoice_header_id', Crypt::decryptString($id))->update(['user_deleted' => Auth::user()->id, 'deleted_at' => $datetime]);
            Invoice_header::where('id', Crypt::decryptString($id))->update(['user_deleted' => Auth::user()->id, 'deleted_at' => $datetime]);

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
