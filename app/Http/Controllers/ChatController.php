<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Models\Chat_converstations;
use App\Models\Chat_message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'setting';
    protected $submenu = 'Tagihan';

    public function index()
    {
        $session_menu = explode(',', Auth::user()->akses_submenu);
        if (in_array('57', $session_menu)) {
            $data = [
                'title' => $this->title,
                'menu' => $this->menu,
                'submenu' => $this->submenu,
                'label' => 'data Tagihan',
            ];
            return view('chat.index')->with($data);
        } else {
            return view('not_found');
        }
    }

    // API
    public function contact($userOne)
    {
        $userOne = Crypt::decryptString($userOne);
        $data = User::with('employee')->where('aktif', 1)->whereNull('email_verified_at')->where('id', '!=', $userOne)
            ->where(function ($q) {
                $q->where('roles', 'Admin')
                    ->orWhere('roles', 'Karyawan')
                    ->orWhere('roles', 'Tu')
                    // ->orWhere('roles', 'Siswa')
                    ->orWhere('roles', 'Administrator');
            })->orderBy('name', 'ASC')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $data = User::with('employee')->findorfail($id);
        return response()->json($data);
    }

    public function show_description($id)
    {
        $data = User::with('employee')->findorfail($id);
        return response()->json($data);
    }

    public function converstation($id)
    {
        $id = Crypt::decryptString($id);
        $data = Chat_converstations::with('user_one', 'user_two')
            ->where(function ($q) use ($id) {
                $q->where('user_one', $id)
                    ->orWhere('user_two', $id);
            })->orderBy('last_chat', 'DESC')->get();
        // return response()->json($data);
        return response()->json(['data' => $data, 'userId' => $id]);
    }

    public function message_converstation($id_converstation, $me)
    {
        $me = Crypt::decryptString($me);
        $converstation = Chat_converstations::findorfail($id_converstation);
        if ($converstation->user_one == $me) {
            $userTwo = $converstation->user_two;
        } elseif ($converstation->user_two == $me) {
            $userTwo = $converstation->user_one;
        }
        $user = User::findorfail($userTwo);
        $message = Chat_message::with('user')->where('conversations_id', $converstation->id)->get();
        return response()->json(['user' => $user, 'message' => $message]);
    }

    public function store(Request $request, $conversations_id, $me)
    {
        if ($request->body == '' or $conversations_id == '' or $me == '') {
            return response()->json(['code' => 404, 'message' => 'filed']);
        }

        DB::beginTransaction();
        try {
            $me_decrypt = Crypt::decryptString($me);
            $message = Chat_message::create([
                'conversations_id' => $conversations_id,
                'body' => $request->body,
                'user_id' => $me_decrypt,
                'user_encrypt' => $me,
            ]);

            Chat_converstations::where("id", $conversations_id)
                ->update(["last_chat" => Carbon::now()]);

            DB::commit();

            MessageCreated::dispatch($message);

            return response()->json(['code' => 200, 'message' => "success"]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json(['code' => 404, 'message' => $err]);
        }
    }

    public function add_converstation($userTwo, $me)
    {
        $me = Crypt::decryptString($me);
        $cek_converstation = Chat_converstations::where(function ($q) use ($userTwo, $me) {
            $q->where('user_one', $userTwo)
                ->where('user_two', $me);
        })->orWhere(function ($w) use ($userTwo, $me) {
            $w->where('user_one', $me)
                ->where('user_two', $userTwo);
        })->get();

        if ($cek_converstation->count() > 0) {
            return response()->json($cek_converstation[0]->id);
        } else {
            DB::beginTransaction();
            try {
                $conver = new Chat_converstations();
                $conver->user_one = $me;
                $conver->user_two = $userTwo;
                $conver->save();
                DB::commit();
                return response()->json($conver->id);
            } catch (\Throwable $err) {
                DB::rollBack();
                throw $err;
                return response()->json(null);
            }
        }
    }

    public function destroy_message($id)
    {
        DB::beginTransaction();
        try {
            $delete = Chat_message::findOrFail($id);
            $delete->delete();

            DB::commit();

            MessageCreated::dispatch(["id" => $id, "body" => "delete message"]);

            return response()->json(['code' => 200, 'message' => "success"]);
        } catch (\Throwable $err) {
            DB::rollBack();
            throw $err;
            return response()->json(['code' => 404, 'message' => $err]);
        }
    }

    public function name($name)
    {
        $data = User::where('name', 'like', '%' . $name . '%')->get();
        return response()->json($data);
    }
    // API
}
