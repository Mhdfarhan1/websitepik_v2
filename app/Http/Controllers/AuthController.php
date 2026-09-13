<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'anggota', // Default role for public registration
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi Berhasil! Selamat Datang.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists in users table
        $userExists = \App\Models\User::where('email', $request->email)->exists();

        if (!$userExists) {
            // Check if they are in the pending registrations list
            $isPending = \App\Models\MemberRegistration::where('email', $request->email)->exists();
            
            if ($isPending) {
                return back()->withErrors([
                    'email' => 'Akun anda belum diaktifkan. Harap tunggu konfirmasi pendaftaran dari admin.',
                ])->onlyInput('email');
            }

            return back()->withErrors([
                'email' => 'Akun anda belum terdaftar atau belum didaftarkan oleh admin.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Selamat Datang Kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
