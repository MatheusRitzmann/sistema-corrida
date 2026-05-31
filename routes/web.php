<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;

/*=============== AREA DO LOGIN ===============*/

// Página inicial
Route::get('/', function () {
    return view('inicio.index');
});

// Página de login
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Processar login
Route::post('/login', [LoginController::class, 'login']);

// Página de cadastro
Route::get('/cadastro', [LoginController::class, 'cadastroView'])->name('cadastro');

// Processar cadastro
Route::post('/cadastro', [LoginController::class, 'cadastro']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*=============== ÁREA ADMINISTRATIVA ===============*/

// Dashboard — acessível por admin e master
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');
});

// Área exclusiva do master
Route::middleware(['auth', 'master'])->prefix('master')->group(function () {
    Route::get('/', [AdminController::class, 'master'])->name('master.index');
    Route::get('/criar-admin', [AdminController::class, 'criarAdminView'])->name('master.criarAdmin');
    Route::post('/criar-admin', [AdminController::class, 'criarAdmin'])->name('master.criarAdmin.store');
});

/*=============== USUÁRIOS ADM ===============*/

// Listagem — admin e master podem ver
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
});

// Editar e deletar — apenas master
Route::middleware(['auth', 'master'])->group(function () {
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar'])->name('usuarios.editar');
    Route::post('/usuarios/{id}/editar', [UsuarioController::class, 'atualizar'])->name('usuarios.atualizar');
    Route::post('/usuarios/{id}/deletar', [UsuarioController::class, 'deletar'])->name('usuarios.deletar');
});

/*=============== MASTERS ===============*/

// Listagem — admin e master podem ver
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/masters', [UsuarioController::class, 'masters'])->name('masters.index');
});

// Editar e deletar — apenas master
Route::middleware(['auth', 'master'])->group(function () {
    Route::get('/masters/{id}/editar', [UsuarioController::class, 'editarMaster'])->name('masters.editar');
    Route::post('/masters/{id}/editar', [UsuarioController::class, 'atualizarMaster'])->name('masters.atualizar');
    Route::post('/masters/{id}/deletar', [UsuarioController::class, 'deletarMaster'])->name('masters.deletar');
});

/*=============== ÁREA DO USUÁRIO ===============*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('usuario.dashboard');
    Route::post('/dashboard/publicar', [DashboardController::class, 'publicar'])->name('usuario.publicar');
    Route::post('/dashboard/like/{postId}', [DashboardController::class, 'like'])->name('usuario.like');
    Route::post('/dashboard/comentar/{postId}', [DashboardController::class, 'comentar'])->name('usuario.comentar');
});