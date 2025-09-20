<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Role-based Dashboard
Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminController::class,'index']);
    Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');
});

Route::middleware(['auth', RoleMiddleware::class.':user'])->group(function(){
    Route::get('/user/dashboard',[UserController::class,'index']);
    Route::get('/user/logout',[UserController::class,'logout'])->name('user.logout');
});

