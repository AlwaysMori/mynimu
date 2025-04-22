<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required|string|max:255|unique:users', // Validasi untuk username
            'email' => 'required|string|email|max:255|unique:users', // Validasi untuk email
            'password' => 'required|string|min:8|confirmed', // Validasi untuk password
        ]);

        // Simpan data ke tabel users
        User::create([
            'username' => $request->username, // Simpan username
            'email' => $request->email, // Simpan email
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Account created successfully. Please login.');
    }
}
