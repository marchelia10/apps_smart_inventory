<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Method REGISTER
    public function register(Request $request)
    {
        // Debug: Log data yang masuk
        Log::info('Register attempt:', $request->all());

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'no_badge' => 'nullable|string|max:255',
            'no_telephone' => 'nullable|string|max:15',
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
                'username' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pengguna',
            ]);

            Log::info('User registered successfully:', ['user' => $user]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk.');
        } catch (\Exception $e) {
            Log::error('Registration failed:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }

    // Method LOGIN - Mendukung login dengan username ATAU email
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // Ubah dari 'username' ke 'login' untuk menerima username/email
            'password' => 'required|string',
        ], [
            'login.required' => 'Nama pengguna atau email harus diisi',
            'password.required' => 'Kata sandi harus diisi',
        ]);

        // Cek apakah input berupa email atau username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->login,
            'password' => $request->password
        ];

        Log::info('Login attempt:', ['login' => $request->login, 'field' => $loginField]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            Log::info('Login successful:', ['user_id' => $user->id, 'role' => $user->role]);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended(route('dasboard'))->with('success', 'Selamat datang, ' . $user->username . '!');
            } else {
                return redirect()->intended(route('dashboard_pengguna'))->with('success', 'Selamat datang, ' . $user->username . '!');
            }
        }

        Log::warning('Login failed:', ['login' => $request->login]);
        return back()->with('error', 'Nama pengguna/email atau kata sandi salah')->withInput($request->only('login'));
    }

    // Method LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }
}
