<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $service;

    /**
     * Inject AuthService (Repository Pattern)
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * 🔹 Show Register Page
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * 🔹 Handle Registration
     */
    public function register(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // ✅ Send data to service layer
        $this->service->register([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 2 // Default user role
        ]);

        // ✅ Redirect with success message
        return redirect()->route('login')
                         ->with('success', 'Registration successful');
    }

    /**
     * 🔹 Show Login Page
     */
    public function showLogin()
    {
        // If already logged in → redirect
        if (Auth::check()) {

            if (Auth::user()->role->name == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/user/dashboard');
        }

        return view('auth.login');
    }

    /**
     * 🔹 Handle Login
     */
    public function login(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // ✅ Authenticate via service
        $user = $this->service->login($request->all());

        // ❌ Invalid credentials
        if (!$user) {
            return back()->with('error', 'Invalid email or password');
        }

        // ✅ Role-based redirect
        if ($user->role->name == 'admin') {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'Welcome Admin');
        }

        return redirect('/user/dashboard')
                ->with('success', 'Login successful');
    }

    /**
     * 🔹 Logout User
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')
                         ->with('success', 'Logged out successfully');
    }
}