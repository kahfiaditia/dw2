<?php

namespace App\Http\Controllers;

use App\Exports\BukuExport;
use App\Helper\AlertHelper;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class BukuController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'perpustakaan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('70', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'buku',
                'label' => 'data buku',
                'lists' => Buku::orderBy('id', 'ASC')->get(),
            ];
            return view('buku.list_buku')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function data_ajax(Request $request)
    {
        // querynya
        $buku = DB::table('perpus_buku')
            ->select(
                'perpus_buku.*',
                'kategori',
                'nama_penerbit',
                'rak',
                'tingkatan',
            )
            ->Join('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->Join('perpus_penerbit', 'perpus_penerbit.id', 'perpus_buku.penerbit_id')
            ->leftJoin('perpus_rak', 'perpus_rak.id', 'perpus_buku.rak_id')
            ->whereNull('perpus_buku.deleted_at')
            ->orderBy('perpus_buku.id', 'DESC');

        if ($request->get('search_manual') != null) {
            $search = $request->get('search_manual');
            $buku->where(function ($where) use ($search) {
                $where
                    ->orWhere('kode_buku', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('nama_penerbit', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('rak', 'like', '%' . $search . '%')
                    ->orWhere('jml_buku', 'like', '%' . $search . '%')
                    ->orWhere('stock_master', 'like', '%' . $search . '%');
            });

            $search = $request->get('search');
            if ($search != null) {
                $buku->where(function ($where) use ($search) {
                    $where
                        ->orWhere('kode_buku', 'like', '%' . $search . '%')
                        ->orWhere('judul', 'like', '%' . $search . '%')
                        ->orWhere('pengarang', 'like', '%' . $search . '%')
                        ->orWhere('nama_penerbit', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('rak', 'like', '%' . $search . '%')
                        ->orWhere('jml_buku', 'like', '%' . $search . '%')
                        ->orWhere('stock_master', 'like', '%' . $search . '%');
                });
            }
        } else {
            if ($request->get('kode') != null) {
                $kode = $request->get('kode');
                $buku->where('kode_buku', '=', $kode);
            }
            if ($request->get('judul') != null) {
                $judul = $request->get('judul');
                $buku->where('judul', '=', $judul);
            }
            if ($request->get('pengarang') != null) {
                $pengarang = $request->get('pengarang');
                $buku->where('pengarang', '=', $pengarang);
            }
            if ($request->get('penerbit') != null) {
                $penerbit = $request->get('penerbit');
                $buku->where('nama_penerbit', '=', $penerbit);
            }
            if ($request->get('penerbit') != null) {
                $penerbit = $request->get('penerbit');
                $buku->where('nama_penerbit', '=', $penerbit);
            }
            if ($request->get('kategori') != null) {
                $kategori = $request->get('kategori');
                $buku->where('kategori', '=', $kategori);
            }
            if ($request->get('rak') != null) {
                $rak = $request->get('rak');
                $buku->where('rak', '=', $rak);
            }
            if ($request->get('jml_end') != null) {
                $jml_start = $request->get('jml_start');
                $jml_end = $request->get('jml_end');
                $buku->whereRaw('jml_buku BETWEEN ' . $jml_start . ' AND ' . $jml_end . '');
            }
            if ($request->get('stock_end') != null) {
                $stock_start = $request->get('stock_start');
                $stock_end = $request->get('stock_end');
                $buku->whereRaw('stock_master BETWEEN ' . $stock_start . ' AND ' . $stock_end . '');
            }
            // stock master
            if ($request->get('search') != null) {
                $search = $request->get('search');
                $replaced = str_replace(' ', '', $search);
                $buku->where(function ($where) use ($search, $replaced) {
                    $where
                        ->orWhere('kode_buku', 'like', '%' . $search . '%')
                        ->orWhere('judul', 'like', '%' . $search . '%')
                        ->orWhere('pengarang', 'like', '%' . $search . '%')
                        ->orWhere('nama_penerbit', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('rak', 'like', '%' . $search . '%')
                        ->orWhere('jml_buku', 'like', '%' . $search . '%')
                        ->orWhere('stock_master', 'like', '%' . $search . '%');
                });
            }
        }

        return DataTables::of($buku)
            ->addColumn('judul', function ($model) {
                if (strlen($model->judul) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->judul . '">' . substr($model->judul, 0, 30) . $titik . '</label>';
            })
            ->addColumn('pengarang', function ($model) {
                if (strlen($model->pengarang) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->pengarang . '">' . substr($model->pengarang, 0, 30) . $titik . '</label>';
            })
            ->addColumn('penerbit', function ($model) {
                if (strlen($model->nama_penerbit) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->nama_penerbit . '">' . substr($model->nama_penerbit, 0, 30) . $titik . '</label>';
            })
            ->addColumn('kategori', function ($model) {
                return $model->kategori;
            })
            ->addColumn('rak', function ($model) {
                if ($model->rak) {
                    $rak = $model->rak . ' - ' . $model->tingkatan;
                } else {
                    $rak = null;
                }
                return $rak;
            })
            ->addColumn('action', 'buku.button')
            ->rawColumns(['action', 'judul', 'penerbit', 'pengarang'])
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
            'submenu' => 'buku',
            'label' => 'tambah buku',
            'kategori' => Kategori::all(),
            'penerbit' => Penerbit::all(),
            'rak' => Rak::all(),
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('71', $session_menu)) {
            return view('buku.add_buku')->with($data);
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('71', $session_menu)) {
            $request->validate([
                'judul' => 'required|max:128',
                'pengarang' => 'required|max:128',
                'penerbit_id' => 'required',
                'thn_terbitan' => 'max:4',
                'tgl_masuk' => 'required|max:10',
                'kategori_id' => 'required',
                'rak_id' => 'required',
                'jml_buku' => 'numeric',
                'foto' => 'mimes:png,jpeg,jpg|max:2048',
            ]);

            // $barcode = Buku::limit(1)->orderBy('id', 'desc')->get();
            // if (count($barcode) > 0) {
            //     $thn = substr($barcode[0]->barcode, 0, 2);
            //     if ($thn == Carbon::now()->format('y')) {
            //         $date = $thn . Carbon::now()->format('md');
            //         $nomor = (int) substr($barcode[0]->barcode, 6, 4) + 1;

            //         $Nol = "";
            //         $nilai = 4 - strlen($nomor);
            //         for ($i = 1; $i <= $nilai; $i++) {
            //             $Nol = $Nol . "0";
            //         }
            //         $barcode   = $date . $Nol .  $nomor;
            //     } else {
            //         $barcode   = Carbon::now()->format('ymd') . "0001";
            //     }
            // } else {
            //     $barcode   = Carbon::now()->format('ymd') . "0001";
            // }

            DB::beginTransaction();
            try {
                $kode_buku = DB::table('perpus_buku')
                    ->select("kode_buku")
                    ->where('kode_buku', 'like', "%{$request->kode_kategori}%")
                    ->limit(1)->orderBy('id', 'desc')->get();

                if (count($kode_buku) > 0) {
                    $bar = explode('-', $kode_buku[0]->kode_buku);
                    $nomor = (int)$bar[1] + 1;
                    $Nol = "";
                    $nilai = 4 - strlen($nomor);
                    for ($i = 1; $i <= $nilai; $i++) {
                        $Nol = $Nol . "0";
                    }
                    $kode_buku   = $request->kode_kategori . '-' . $Nol .  $nomor;
                } else {
                    $kode_buku = $request->kode_kategori . '-0001';
                }

                $buku = new buku();
                $buku->judul = $request['judul'];
                $buku->pengarang = $request['pengarang'];
                $buku->penerbit_id = $request['penerbit_id'];
                $buku->thn_terbitan = $request['thn_terbitan'];
                $buku->tgl_masuk = $request['tgl_masuk'];
                $buku->kategori_id = $request['kategori_id'];
                $buku->jml_buku = $request['jml_buku'];
                $buku->stock_master = $request['jml_buku'];
                $buku->rak_id = $request['rak_id'];
                $buku->kode_buku = $kode_buku;
                if ($request->sama == 'on') {
                    $buku->barcode = $kode_buku;
                } else {
                    $buku->barcode = $request->barcode;
                }
                // dokumen foto
                if ($request->foto) {
                    $fileNameFoto = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->foto->extension();
                    $buku->foto = $fileNameFoto;
                    $request->file('foto')->storeAs('public/buku', $fileNameFoto);
                }
                $buku->user_created = Auth::user()->id;
                $buku->save();

                DB::commit();
                AlertHelper::addAlert(true);
                return redirect('buku');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('70', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => 'buku',
                'label' => 'ubah buku',
                'buku' => Buku::findorfail($id_decrypted),
                'kategori' => Kategori::all(),
                'penerbit' => Penerbit::all(),
                'rak' => Rak::all(),
            ];
            return view('buku.view')->with($data);
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
        $id_decrypted = Crypt::decryptString($id);
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'buku',
            'label' => 'ubah buku',
            'buku' => Buku::findorfail($id_decrypted),
            'kategori' => Kategori::all(),
            'penerbit' => Penerbit::all(),
            'rak' => Rak::all(),
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('72', $session_menu)) {
            return view('buku.edit_buku')->with($data);
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
        if (in_array('72', $session_menu)) {
            $id = Crypt::decryptString($id);
            $request->validate([
                'judul' => 'required|max:128',
                'pengarang' => 'required|max:128',
                'penerbit_id' => 'required',
                'thn_terbitan' => 'max:4',
                'tgl_masuk' => 'required|max:10',
                'kategori_id' => 'required',
                'rak_id' => 'required',
                'barcode' => 'required',
                'stock_master' => 'numeric',
                'foto' => 'mimes:png,jpeg,jpg|max:2048',
            ]);

            DB::beginTransaction();
            try {
                $buku = Buku::findOrFail($id);
                $buku->judul = $request['judul'];
                $buku->pengarang = $request['pengarang'];
                $buku->penerbit_id = $request['penerbit_id'];
                $buku->thn_terbitan = $request['thn_terbitan'];
                $buku->tgl_masuk = $request['tgl_masuk'];
                $buku->kategori_id = $request['kategori_id'];
                if ($request['stock_master'] > $request['stock_master_old']) {
                    $selisih = $request['stock_master'] - $request['stock_master_old'];
                    $buku->jml_buku = $request['jml_buku'] + $selisih;
                    $buku->stock_master = $request['stock_master'];
                } elseif ($request['stock_master'] < $request['stock_master_old']) {
                    $selisih = $request['stock_master_old'] - $request['stock_master'];
                    $jml_buku = $request['jml_buku'] - $selisih;
                    if ($jml_buku < 0) {
                        AlertHelper::alertDinamis(false, 'Beberapa Buku masih di siswa');
                        return back();
                    }
                    $buku->jml_buku = $jml_buku;
                    $buku->stock_master = $request['stock_master'];
                }
                $buku->rak_id = $request['rak_id'];
                $buku->barcode = $request['barcode'];
                // dokumen foto
                if ($request->foto) {
                    $fileNameFoto = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->foto->extension();
                    $buku->foto = $fileNameFoto;
                    $request->file('foto')->storeAs('public/buku', $fileNameFoto);
                    Storage::delete('public/buku/' . $request->foto_old);
                }
                if ($request->kode_kategori_old != $request->kode_kategori) {
                    $barcode = DB::table('perpus_buku')
                        ->select("barcode")
                        ->where('barcode', 'like', "%{$request->kode_kategori}%")
                        ->limit(1)->orderBy('id', 'desc')->get();

                    if (count($barcode) > 0) {
                        $bar = explode('-', $barcode[0]->barcode);
                        $nomor = (int)$bar[1] + 1;
                        $Nol = "";
                        $nilai = 4 - strlen($nomor);
                        for ($i = 1; $i <= $nilai; $i++) {
                            $Nol = $Nol . "0";
                        }
                        $barcode   = $request->kode_kategori . '-' . $Nol .  $nomor;
                    } else {
                        $barcode = $request->kode_kategori . '-0001';
                    }
                    $buku->kode_buku = $barcode;
                }
                $buku->user_updated = Auth::user()->id;
                $buku->save();

                DB::commit();
                AlertHelper::updateAlert(true);
                return redirect('buku');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('73', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $buku = Buku::findorfail($id_decrypted);
                $buku->user_deleted = Auth::user()->id;
                $buku->deleted_at = Carbon::now();
                $buku->save();

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
        $buku = DB::table('perpus_buku')
            ->select(
                'perpus_buku.id',
                'kode_kategori',
                'judul',
            )
            ->Join('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->whereNull('perpus_buku.deleted_at')
            ->where('stock_master', '>', '0')
            ->orderBy('kode_kategori', 'ASC')
            ->orderBy('judul', 'ASC')
            ->get();
        return $buku;
    }

    public function print($id)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'barcode',
            'label' => 'print barcode',
            'item' => Buku::findorfail(Crypt::decryptString($id)),
            'id' => $id,
        ];
        return view('buku.print_jml')->with($data);
    }

    public function print_barcode(Request $request)
    {
        $item = [];
        $buku = Buku::findorfail(Crypt::decryptString($request->id));
        for ($i = 0; $i < $request->jml; $i++) {
            $push = $buku->barcode . '|--|' . $buku->judul;
            array_push($item, $push);
        }
        $data = [
            'items' => array_chunk($item, 4, true),
        ];
        return view('buku.print_barcode')->with($data);
    }

    public function book()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'barcode',
            'label' => 'print barcode',
        ];
        return view('buku.book')->with($data);
    }

    public function get_book(Request $request)
    {
        // querynya
        $buku = DB::table('perpus_buku')
            ->select(
                'kode_buku',
                'judul',
                'pengarang',
                'nama_penerbit',
                'kategori',
                'jml_buku',
                'rak',
                'tingkatan',
            )
            ->leftJoin('perpus_penerbit', 'perpus_penerbit.id', 'perpus_buku.penerbit_id')
            ->leftJoin('perpus_kategori_buku', 'perpus_kategori_buku.id', 'perpus_buku.kategori_id')
            ->leftJoin('perpus_rak', 'perpus_rak.id', 'perpus_buku.rak_id')
            ->whereNull('perpus_buku.deleted_at')
            ->orderBy('kode_buku', 'DESC');

        if ($request->get('kode') != null) {
            $kode = $request->get('kode');
            $buku->where('kode_buku', '=', $kode);
        }
        if ($request->get('judul') != null) {
            $judul = $request->get('judul');
            $buku->Where('judul', 'like', '%' . $judul . '%');
        }
        if ($request->get('pengarang') != null) {
            $pengarang = $request->get('pengarang');
            $buku->Where('pengarang', 'like', '%' . $pengarang . '%');
        }
        if ($request->get('penerbit') != null) {
            $penerbit = $request->get('penerbit');
            $buku->Where('nama_penerbit', 'like', '%' . $penerbit . '%');
        }
        if ($request->get('kategori') != null) {
            $kategori = $request->get('kategori');
            $buku->Where('kategori', 'like', '%' . $kategori . '%');
        }
        if ($request->get('jml_end') != null) {
            $start = $request->get('jml_start');
            $end = $request->get('jml_end');
            $buku->whereBetween('jml_buku', [$start, $end]);
        }
        if ($request->get('rak') != null) {
            $rak = $request->get('rak');
            $buku->Where('rak', 'like', '%' . $rak . '%');
        }
        if ($request->get('search') != null) {
            $search = $request->get('search');
            $buku->where(function ($where) use ($search) {
                $where
                    ->orWhere('kode_buku', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('nama_penerbit', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('jml_buku', 'like', '%' . $search . '%')
                    ->orWhere('rak', 'like', '%' . $search . '%');
            });
        }

        return DataTables::of($buku)
            ->addColumn('judul', function ($model) {
                if (strlen($model->judul) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->judul . '">' . substr($model->judul, 0, 30) . $titik . '</label>';
            })
            ->addColumn('pengarang', function ($model) {
                if (strlen($model->pengarang) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->pengarang . '">' . substr($model->pengarang, 0, 30) . $titik . '</label>';
            })
            ->addColumn('penerbit', function ($model) {
                if (strlen($model->nama_penerbit) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->nama_penerbit . '">' . substr($model->nama_penerbit, 0, 30) . $titik . '</label>';
            })
            ->addColumn('kategori', function ($model) {
                return $model->kategori;
            })
            ->addColumn('rak', function ($model) {
                return $model->rak . ' - ' . $model->tingkatan;
            })
            ->rawColumns(['action', 'judul', 'penerbit', 'pengarang'])
            ->make(true);
    }

    public function export_buku(Request $request)
    {
        $data = [
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'kategori' => $request->kategori,
            'jml_start' => $request->jml_start,
            'jml_end' => $request->jml_end,
            'stock_start' => $request->stock_start,
            'stock_end' => $request->stock_end,
            'rak' => $request->rak,
            'search_manual' => $request->search_manual,
            'like' => $request->like,
        ];
        return Excel::download(new BukuExport($data), 'buku.xlsx');
    }
}
