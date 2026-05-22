<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class KelolaPenggunaController extends Controller
{
    public function index()
    {
        $kelolapengguna = User::all(); // ambil semua user

        return view('kelolapengguna', compact('kelolapengguna'));
    }

    // Method untuk menambah pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,pengguna',
        ], [
            'username.required' => 'Nama pengguna harus diisi',
            'username.unique' => 'Nama pengguna sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi harus diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'role.required' => 'Role harus dipilih',
        ]);

        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Log::info('User added by admin:', [
                'user' => $user,
                'added_by' => Auth::user()->id // Sekarang Auth sudah terimport
            ]);

            return redirect()
                ->route('kelolapengguna.index')
                ->with('success', 'Pengguna baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Failed to add user:', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,pengguna',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('kelolapengguna.index')->with('success', 'Role pengguna diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('kelolapengguna.index')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
