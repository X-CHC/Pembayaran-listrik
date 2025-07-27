<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Login form admin
    public function showAdminLogin()
    {
        return view('auth.login_admin');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = DB::table('user')->where('username', $request->input('username'))->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            Session::put('admin', [
                'id_user' => $user->id_user,
                'username' => $user->username,
                'nama_admin' => $user->nama_admin,
                'id_level' => $user->id_level,
            ]);
            DB::table('user')->where('id_user', $user->id_user)->update(['last_login' => now()]);
            return redirect('/dashboard-admin');
        }
        return back()->with('error', 'Username atau password salah!');
    }

    public function adminLogout()
    {
        Session::forget('admin');
        return redirect()->route('login.admin');
    }

    // Login form pelanggan
    public function showPelangganLogin()
    {
        return view('auth.login_pelanggan');
    }

    public function pelangganLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $pelanggan = DB::table('pelanggan')->where('username', $request->input('username'))->first();
        if ($pelanggan && Hash::check($request->input('password'), $pelanggan->password)) {
            Session::put('pelanggan', [
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'username' => $pelanggan->username,
                'nama_pelanggan' => $pelanggan->nama_pelanggan,
            ]);
            return redirect('/dashboard-pelanggan');
        }
        return back()->with('error', 'Username atau password salah!');
    }

    public function pelangganLogout()
    {
        Session::forget('pelanggan');
        return redirect()->route('login.pelanggan');
    }
}
