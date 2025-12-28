<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }
    
    /**
     * Memproses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Coba melakukan login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();
            
            // Redirect berdasarkan role user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            // Untuk user biasa, redirect ke home
            return redirect()->intended('/');
        }
        
        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    
    /**
     * Menampilkan halaman registrasi
     */
    public function showRegister()
    {
        return view('auth.register');
    }
    
    /**
     * Memproses registrasi
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role adalah 'user'
        ]);
        
        // Login otomatis setelah registrasi
        Auth::login($user);
        
        // Redirect ke home
        return redirect('/');
    }
    
    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}