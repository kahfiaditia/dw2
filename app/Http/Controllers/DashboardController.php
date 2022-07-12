<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'login';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->student != null) {
            $invoice = Invoice::where('siswa_id', Auth::user()->student->id)->get();
        } else {
            $invoice = null;
        }
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'dashboard',
            'label' => 'dashboard',
            'invoice' => $invoice,
        ];
        return view('dashboard.dashboard')->with($data);
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

    public function phpinfo()
    {
        echo phpinfo();
    }
}
