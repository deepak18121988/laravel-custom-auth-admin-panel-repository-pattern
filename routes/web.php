<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\User\ProfileController;

/*
|--------------------------------------------------------------------------
| 🌐 Public Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| 🔐 Guest Routes (Login / Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');  
    Route::post('/register', [AuthController::class, 'register'])->name('register.post'); 
});
/*
|--------------------------------------------------------------------------
| 🔒 Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])
    ->prefix('admin')              // URL prefix
    ->name('admin.')               // ⭐ IMPORTANT (route names)
    ->group(function(){

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Resource routes with names like:
        // admin.users.index
        // admin.users.store
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
});

/*
|--------------------------------------------------------------------------
| 👤 User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:user'])->group(function(){

    Route::get('/user/dashboard', [UserDashboardController::class, 'index']);
    Route::get('/user/profile', [ProfileController::class,'index']);
});

/*
|--------------------------------------------------------------------------
| 🚪 Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');