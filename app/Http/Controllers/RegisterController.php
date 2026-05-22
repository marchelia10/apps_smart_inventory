<?php

//Lama
// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;

// class RegisterController extends Controller
// {
//     public function register(Request $request)
//     {
//         $request->validate([
//             'username' => 'required|string|max:255|unique:users',
//             'email' => 'required|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//         ], [
//             'username.required' => 'Nama pengguna harus diisi',
//             'username.unique' => 'Nama pengguna sudah digunakan',
//             'email.required' => 'Email harus diisi',
//             'email.unique' => 'Email sudah terdaftar',
//             'password.required' => 'Kata sandi harus diisi',
//             'password.min' => 'Kata sandi harus minimal 8 karakter',
//             'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
//         ]);

//         User::create([
//             'username' => $request->username,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'role' => 'pengguna',
//         ]);

//         return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk');
//     }
// }


//BARU
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Debug: Log data yang masuk
        Log::info('Register attempt:', $request->all());

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',  // Ubah dari 'username' ke 'nama_lengkap'
            'email' => 'required|email|max:255|unique:users',
            'no badge' => 'nullable|string|max:255',  // Optional field
            'No Telephone' => 'nullable|string|max:15',  // Optional field
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Kata sandi harus diisi',
            'password.min' => 'Kata sandi harus minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok',
        ]);

        try {
            $user = User::create([
                'username' => $request->nama_lengkap,  // Simpan nama_lengkap ke field username
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pengguna',  // Default role
            ]);

            Log::info('User registered successfully:', ['user' => $user]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk.');
        } catch (\Exception $e) {
            Log::error('Registration failed:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }
}
