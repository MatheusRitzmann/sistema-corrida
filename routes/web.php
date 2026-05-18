<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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