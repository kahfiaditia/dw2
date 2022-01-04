<?php

namespace App\Http\Controllers;

use App\Mail\KirimEmail;
use App\Mail\ResetPassword as MailResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    protected $title = 'dharmawidya';
    protected $menu = 'login';

    public function index()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'login',
            'label' => 'login',
        ];
        return view('login.login')->with($data);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
            'status' => 'A',
        ]);
        // login password harus bcrpt baru bisa masuk auth::attempt
        if (Auth::attempt($credentials)) {
            if (Auth::user()->status === 'A') {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('loginError', 'Login Fail!');
            }
        }
        return back()->with('loginError', 'Login Fail!');
    }

    public function register()
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'register',
            'label' => 'register',
        ];
        return view('login.register')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'roles' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $pin_verified = sprintf("%04d", rand(0, 9999));
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->roles = $request->roles;
            $user->pin_verified = $pin_verified;
            $user->pin_verified_at = Carbon::now();
            $user->password = bcrypt($request->password);
            $user->save();

            $details = [
                'subject' => 'Verifikasi Email',
                'email' => $request->email,
                'pin_verified' => $pin_verified,
            ];
            Mail::to($request->email)->send(new KirimEmail($details));

            DB::commit();
            return redirect('notifikasi');
        } catch (\Exception $e) {
            dd($e);
            DB::back()->with('registerError', 'Login Fail!');
        }
    }

    public function notifikasi(Request $request)
    {
        if (session()->get('type') === 'reset') {
            $body = 'Thanks For Reset Akun';
            $type = 'recovery';
        } else if (session()->get('type') === 'verify') {
            $body = 'Thanks For Verify Akun';
            $type = 'verify';
        } else {
            $body = 'Thanks For Register Akun';
            $type = 'else';
        }
        $data = [
            'title' => $this->title,
            'icon' => 'bx bx-mail-send',
            'header' => 'Success',
            'body' => $body,
            'type' => $type,
        ];
        return view('notifikasi.notifikasi')->with($data);
    }

    public function verifikasi($id)
    {
        $decrypted = Crypt::decryptString($id);
        $data = explode('|', $decrypted);
        $email = $data[0];
        $pin_verified = $data[1];
        $user = User::select('pin_verified_at')->where('email', $email)->where('pin_verified', $pin_verified)->get();

        $date_val = Carbon::parse($user[0]->pin_verified_at)->addMinutes(30);
        if ($date_val >= Carbon::now()) {
            $data = [
                'title' => $this->title,
                'submenu' => 'Step Verifikasi',
                'email' => $email,
            ];
            return view('login.step_verifikasi')->with($data);
        } else {
            $data = [
                'title' => $this->title,
                'icon' => 'bx bxs-hourglass-bottom',
                'header' => 'Expired',
                'body' => 'Please re-verify',
                'type' => 'verify',
            ];
            return view('notifikasi.notifikasi')->with($data);
        }
    }

    public function confirmasi(Request $request)
    {
        $request->validate([
            'satu' => 'required',
            'dua' => 'required',
            'tiga' => 'required',
            'empat' => 'required',
        ]);
        $code = $request->satu . $request->dua . $request->tiga . $request->empat;
        $hasil = User::where(['email' => $request->email, 'pin_verified' => $code])->count();
        if ($hasil > 0) {
            DB::beginTransaction();
            try {
                User::where(['email' => $request->email, 'pin_verified' => $code])->update(['email_verified_at' => Carbon::now()]);
                DB::commit();
                return redirect('notifikasi')->with(['type' => 'verify']);
            } catch (\Exception $e) {
                dd($e);
                DB::back()->with('Error', 'Verifikasi Fail!');
            }
        } else {
            return back()->with('Error', 'Verifikasi Fail!');
        }
    }

    public function reverify(Request $request)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'reverify',
            'type' => 'reverify',
            'subject' => 'Reverify Email',
            'p' => 'DHARMAWIDYA',
            'submit' => 'Reverify',
        ];
        return view('login.recovery')->with($data);
    }

    public function reverifycode(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'type' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $pin_verified = sprintf("%04d", rand(0, 9999));
            User::where(['email' => $request->email])->update([
                'pin_verified' => $pin_verified,
                'pin_verified_at' => Carbon::now(),
                'email_verified_at' => NULL
            ]);
            $details = [
                'subject' => 'Verifikasi Email',
                'email' => $request->email,
                'pin_verified' => $pin_verified,
            ];
            Mail::to($request->email)->send(new KirimEmail($details));

            DB::commit();
            return redirect('notifikasi');
        } catch (\Exception $e) {
            dd($e);
            DB::back()->with('registerError', 'Reverify Email Fail!');
        }
    }

    public function recovery(Request $request)
    {
        $data = [
            'title' => $this->title,
            'menu' => $this->menu,
            'submenu' => 'recovery',
            'type' => 'recovery',
            'subject' => 'Reset Password',
            'p' => 'DHARMAWIDYA',
            'submit' => 'Reset',
        ];
        return view('login.recovery')->with($data);
    }

    public function resetcode(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'type' => 'required',
        ]);
        $cek = User::where('email', $request->email)->whereNotNull('pin_verified_at')->count();
        if ($cek > 0) {
            DB::beginTransaction();
            try {
                $details = [
                    'subject' => 'Reset Password',
                    'email' => $request->email,
                ];
                Mail::to($request->email)->send(new MailResetPassword($details));
                User::where(['email' => $request->email])->update(['password_reset_at' => Carbon::now()]);
                DB::commit();
                return redirect('notifikasi')->with(['type' => 'reset']);
            } catch (\Exception $e) {
                dd($e);
                DB::back()->with('Error', 'Reset Email Fail!');
            }
        } else {
            return back()->with('Error', 'Reset Fail, Please Verifikasi Email!');
        }
    }

    public function reset($id)
    {
        $email = Crypt::decryptString($id);
        $user = User::where('email', $email)->get();
        $date_val = Carbon::parse($user[0]->password_reset_at)->addMinutes(30);
        if ($date_val >= Carbon::now()) {
            $data = [
                'title' => $this->title,
                'submenu' => 'Step Verifikasi',
                'subject' => 'Reset Password',
                'p' => 'Reset Password',
                'email' => $user[0]->email,
            ];
            return view('login.reset')->with($data);
        } else {
            $data = [
                'title' => $this->title,
                'icon' => 'bx bxs-hourglass-bottom',
                'header' => 'Expired',
                'body' => 'Please re-verify',
                'type' => 'verify',
            ];
            return view('notifikasi.notifikasi')->with($data);
        }
    }

    public function newpassword(Request $request)
    {
        $cek = User::where('email', $request->email)->count();
        if ($cek > 0) {
            DB::beginTransaction();
            try {
                User::where(['email' => $request->email])->update(['password' => bcrypt($request->password)]);
                DB::commit();
                return redirect('notifikasi')->with(['type' => 'reset']);
            } catch (\Exception $e) {
                dd($e);
                DB::back()->with('Error', 'Reset Email Fail!');
            }
        } else {
            return back()->with('Error', 'Reset Fail!');
        }
    }
}
