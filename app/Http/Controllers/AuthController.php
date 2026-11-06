<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // METHOD UNTUK ME-RENDER HALAMAN FORM REGISTER (Jika ada)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // METHOD REGISTER (PROSES SIMPAN AKUN BARU)
    public function register(Request $request)
    {
        $request->validate([
            'username'    => 'required|unique:users,username',
            'password'    => 'required|min:6',
            'nama_pria'   => 'required|string|max:100',
            'nama_wanita' => 'required|string|max:100',
            'no_hp'       => 'required|string|max:20',
            'alamat'      => 'required|string|max:255',
        ], [
            'username.unique'   => 'Username ini sudah digunakan, silakan pilih username lain!',
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // 1. Simpan Data ke Tabel `users`
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'Klien',
        ]);

        // 2. Simpan Data ke Tabel `klien`
        Klien::create([
            'id_user'     => $user->id_user,
            'nama_pria'   => $request->nama_pria,
            'nama_wanita' => $request->nama_wanita,
            'no_hp'       => $request->no_hp,
            'alamat'      => $request->alamat,
        ]);

        // 3. Otomatis Login setelah Berhasil Register
        Auth::login($user);
        $request->session()->regenerate();

        // 4. Redirect ke Landing Page (Sesuai Alur yang Diinginkan)
        return redirect()->route('landing')->with('success', 'Akun berhasil dibuat! Selamat datang di NOMIMOS.');
    }

    // METHOD LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            if ($user->role === 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'Klien') {
                return redirect()->route('landing')->with('success', 'Selamat datang! Silakan pilih paket acara Anda.');
            } elseif ($user->role === 'Crew') {
                return redirect()->route('crew.dashboard');
            }

            return redirect()->route('landing');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang dimasukkan salah!',
        ])->onlyInput('username');
    }

    // METHOD LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}