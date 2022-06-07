<?php

namespace App\Http\Controllers;

use App\Models\Kebutuhan_khusus;
use App\Models\Siswa;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';

    public function index()
    {
        //
    }

    public function create()
    {
        $students = Siswa::doesntHave('parents')->orderBy('id', 'DESC')->get();
        $special_needs = Kebutuhan_khusus::orderBy('id', 'DESC')->get();

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'parent',
            'label' => 'tambah orang tua',
            'students' => $students,
            'special_needs' => $special_needs
        ];

        return view('parents.create')->with($data);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
