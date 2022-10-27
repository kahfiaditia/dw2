<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'buku',
            'label' => 'data buku',
            'lists' => Buku::orderBy('id', 'ASC')->get(),
        ];
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('70', $session_menu)) {
            return view('buku.list_buku')->with($data);
        } else {
            return view('not_found');
        }
    }

    public function data_ajax(Request $request)
    {
        $buku = Buku::all();
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
                if (strlen($model->penerbit->nama_penerbit) > 30) {
                    $titik = '...';
                } else {
                    $titik = null;
                }

                return '<label class="" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $model->penerbit->nama_penerbit . '">' . substr($model->penerbit->nama_penerbit, 0, 30) . $titik . '</label>';
            })
            ->addColumn('kategori', function ($model) {
                return $model->kategori->kode_kategori . ' - ' . $model->kategori->kategori;
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
        $request->validate([
            'judul' => 'required|max:128',
            'pengarang' => 'required|max:128',
            'penerbit_id' => 'required',
            'thn_terbitan' => 'max:4',
            'tgl_masuk' => 'required|max:10',
            'kategori_id' => 'required',
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

        DB::beginTransaction();
        try {
            $buku = new buku();
            $buku->judul = $request['judul'];
            $buku->pengarang = $request['pengarang'];
            $buku->penerbit_id = $request['penerbit_id'];
            $buku->thn_terbitan = $request['thn_terbitan'];
            $buku->tgl_masuk = $request['tgl_masuk'];
            $buku->kategori_id = $request['kategori_id'];
            $buku->jml_buku = $request['jml_buku'];
            $buku->barcode = $barcode;
            // dokumen foto
            if ($request->foto) {
                $fileNameFoto = Carbon::now()->format('ymdhis') . '_' . str::random(25) . '.' . $request->foto->extension();
                $buku->foto = $fileNameFoto;
                $request->file('foto')->storeAs('public/buku', $fileNameFoto);
            }
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        ];
        return view('buku.view')->with($data);
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
        $id = Crypt::decryptString($id);
        $request->validate([
            'judul' => 'required|max:128',
            'pengarang' => 'required|max:128',
            'penerbit_id' => 'required',
            'thn_terbitan' => 'max:4',
            'tgl_masuk' => 'required|max:10',
            'kategori_id' => 'required',
            'jml_buku' => 'numeric',
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
            $buku->jml_buku = $request['jml_buku'];
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
                $buku->barcode = $barcode;
            }
            $buku->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('buku');
        } catch (\Throwable $err) {
            DB::rollback();
            throw $err;
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
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('73', $session_menu)) {
            $id_decrypted = Crypt::decryptString($id);
            DB::beginTransaction();
            try {
                $buku = Buku::findorfail($id_decrypted);
                $buku->delete();

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
        $buku = Buku::all();
        return $buku;
    }
}
