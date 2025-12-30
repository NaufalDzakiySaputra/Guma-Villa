<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->showAlreadyLoggedIn();
        }
        
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            Log::info('User logged in', [
                'user_id' => Auth::id(),
                'email' => $request->email,
                'role' => Auth::user()->role,
                'ip' => $request->ip()
            ]);
            
            return $this->redirectAfterLogin();
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->showAlreadyLoggedIn();
        }
        
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        
        Log::info('User registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'ip' => $request->ip()
        ]);
        
        Auth::login($user);
        
        return $this->redirectAfterLogin()
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }
    
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Log::info('User logged out', [
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'role' => Auth::user()->role,
                'ip' => $request->ip()
            ]);
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('info', 'Anda telah berhasil logout.');
    }
    
    private function showAlreadyLoggedIn()
    {
        return view('auth.already-logged-in', [
            'user' => Auth::user()
        ]);
    }
    
    private function redirectAfterLogin()
    {
        $user = Auth::user();
        
        // CEK: Jika ada pending reservation
        if (Session::has('pending_reservation')) {
            return redirect()->route('user.reservation.create')
                ->with('success', 'Login berhasil! Silakan lengkapi data reservasi.');
        }
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, Admin ' . $user->name . '!');
        }
        
        return redirect()->route('user.home')
            ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }
}