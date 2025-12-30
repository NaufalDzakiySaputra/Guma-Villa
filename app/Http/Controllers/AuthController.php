<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, tampilkan informasi
        if (Auth::check()) {
            return $this->showAlreadyLoggedIn();
        }
        
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
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();
            
            // Log activity
            Log::info('User logged in', [
                'user_id' => Auth::id(),
                'email' => $request->email,
                'role' => Auth::user()->role,
                'ip' => $request->ip()
            ]);
            
            // Redirect berdasarkan role
            return $this->redirectAfterLogin();
        }
        
        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    /**
     * Menampilkan halaman registrasi
     */
    public function showRegister()
    {
        // Jika sudah login, tampilkan informasi
        if (Auth::check()) {
            return $this->showAlreadyLoggedIn();
        }
        
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
        
        // Log activity
        Log::info('User registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'ip' => $request->ip()
        ]);
        
        // Login otomatis setelah registrasi
        Auth::login($user);
        
        // Redirect setelah registrasi
        return $this->redirectAfterLogin()
            ->with('success', 'Registration successful! Welcome, ' . $user->name . '!');
    }
    
    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        // Log activity sebelum logout
        if (Auth::check()) {
            Log::info('User logged out', [
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'role' => Auth::user()->role,
                'ip' => $request->ip()
            ]);
        }
        
        // Proses logout
        Auth::logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Redirect ke home dengan message
        return redirect('/')
            ->with('info', 'You have been logged out successfully.');
    }
    
    /**
     * Tampilkan halaman "already logged in"
     */
    private function showAlreadyLoggedIn()
    {
        return view('auth.already-logged-in', [
            'user' => Auth::user()
        ]);
    }
    
    /**
     * Helper: Redirect setelah login/registrasi
     */
    private function redirectAfterLogin()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, Admin ' . $user->name . '!');
        }
        
        // User biasa: Redirect ke homepage
        return redirect('/')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }
}