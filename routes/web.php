<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

// Página inicial
Route::get('/', function () {
    return view('inicio.index');
});

// Página de login
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Processar login
Route::post('/login', [LoginController::class, 'login']);

// Processar cadastro
Route::post('/cadastro', [LoginController::class, 'cadastro']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Página de cadastro de usuário
Route::get('/cadastro', [LoginController::class, 'cadastroView'])->name('cadastro');

// Área do administrador (admin e master)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
});

// Área exclusiva do master
Route::middleware(['auth', 'master'])->prefix('master')->group(function () {
    Route::get('/', [AdminController::class, 'master'])->name('master.index');
    Route::get('/criar-admin', [AdminController::class, 'criarAdminView'])->name('master.criarAdmin');
    Route::post('/criar-admin', [AdminController::class, 'criarAdmin'])->name('master.criarAdmin.store');
});