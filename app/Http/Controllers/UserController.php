<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // 1. Hitung ringkasan total per role dari database
        $totalUsers = User::count();$totalAdmin = User::where('role', 'Admin')->count();
        $totalKlien = User::where('role', 'Klien')->count();$totalCrew  = User::where('role', 'Crew')->count();

        // 2. Ambil data user terdaftar 20 per halaman
        $users = User::orderBy('role', 'asc')->paginate(20);

        return view('admin.user', compact('users', 'totalUsers', 'totalAdmin', 'totalKlien', 'totalCrew'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Klien,Crew',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan!');
    }

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $id . ',id_user',
            'role'     => 'required|in:Admin,Klien,Crew',
        ]);

        $data = [
            'username' => $request->username,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus!');
    }
}