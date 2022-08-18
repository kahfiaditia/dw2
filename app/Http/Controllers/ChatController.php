<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Tagihan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        MessageCreated::dispatch('test');

        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data Tagihan',
        ];

        return view('chat.index')->with($data);
    }
}
