<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    // Show Register Form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Register
    public function register(Request $request)
    {

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Enter valid email',
            'password.required' => 'Password is required',
        ]);

        // ✅ Data send to service
        $this->service->register([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 2 // 👈 user role 
        ]);
        return redirect('/login')->with('success', 'Registered');
    }

    // Show Login
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role->name == 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/user/dashboard');
        }

        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = $this->service->login($request->all());

        if (!$user) {
            return back()->with('error', 'Invalid credentials');
        }

        if ($user->role->name == 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out');
    }
}