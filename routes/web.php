<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

// Home page
Route::get('/', [HomeController::class, 'index']);

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);
});

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth','role:admin'])->group(function(){

    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/roles', RoleController::class);

});

Route::middleware(['auth','role:user'])->group(function(){

    Route::get('/user/profile', [ProfileController::class,'index']);

});


