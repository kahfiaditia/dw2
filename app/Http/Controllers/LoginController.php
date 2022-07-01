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
            'aktif' => '0',
        ]);
        // login password harus bcrpt baru bisa masuk auth::attempt
        if (Auth::attempt($credentials)) {
            if (Auth::user()->aktif === '1') {
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
            // set user akses
            if ($request->roles === 'Karyawan') {
                $user->akses_menu = '1,2';
                $user->akses_submenu = '1,2,3,4,6';
            } elseif ($request->roles === 'Admin') {
                $user->akses_menu = '1,2,3,4,5,6,7,8,9,10,11';
                $user->akses_submenu = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42';
            } elseif ($request->roles === 'Siswa') {
                $user->akses_menu = '1,6';
                $user->akses_submenu = '1,19,20,21';
            } elseif ($request->roles === 'Alumni') {
                $user->tahun_lulus = $request->tahun_lulus;
                $user->akses_menu = '1';
                $user->akses_submenu = '1';
            } elseif ($request->roles === 'Ortu') {
            }
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
            $body = 'Terima kasih telah mengatur ulang password';
            $type = 'recovery';
            $header = 'Cek Email untuk atur ulang password';
        } else if (session()->get('type') === 'notif_reset') {
            $body = 'Terima kasih telah mengatur ulang password';
            $type = 'recovery';
            $header = 'Berhasil';
        } else if (session()->get('type') === 'verify') {
            $body = 'Terima kasih untuk verifikasi akun';
            $type = 'verify';
            $header = 'Verifikasi berhasil';
        } else {
            $body = 'Terima kasih telah mendaftarkan akun';
            $type = 'else';
            $header = 'Cek Email untuk Verifikasi akun';
        }
        $data = [
            'title' => $this->title,
            'icon' => 'bx bx-mail-send',
            'header' => $header,
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
                return redirect('notifikasi')->with(['type' => 'notif_reset']);
            } catch (\Exception $e) {
                dd($e);
                DB::back()->with('Error', 'Reset Email Fail!');
            }
        } else {
            return back()->with('Error', 'Reset Fail!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
