<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\MetricaController;
use App\Http\Controllers\SubscricaoController;

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

/*=============== ATIVIDADES ===============*/
Route::middleware(['auth'])->group(function () {
    Route::get('/atividades', [AtividadeController::class, 'index'])->name('usuario.atividades');
    Route::get('/atividades/criar', [AtividadeController::class, 'criar'])->name('usuario.atividades.criar');
    Route::post('/atividades/criar', [AtividadeController::class, 'salvar'])->name('usuario.atividades.salvar');
    Route::get('/atividades/{id}', [AtividadeController::class, 'ver'])->name('usuario.atividades.ver');
    Route::post('/atividades/{id}/deletar', [AtividadeController::class, 'deletar'])->name('usuario.atividades.deletar');
});

/*=============== CATEGORIAS — ADMIN ===============*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias');
    Route::get('/admin/categorias/criar', [CategoriaController::class, 'criar'])->name('admin.categorias.criar');
    Route::post('/admin/categorias/criar', [CategoriaController::class, 'salvar'])->name('admin.categorias.salvar');
    Route::get('/admin/categorias/{id}/editar', [CategoriaController::class, 'editar'])->name('admin.categorias.editar');
    Route::post('/admin/categorias/{id}/editar', [CategoriaController::class, 'atualizar'])->name('admin.categorias.atualizar');
    Route::post('/admin/categorias/{id}/deletar', [CategoriaController::class, 'deletar'])->name('admin.categorias.deletar');
});

/*=============== PLANOS — ADMIN ===============*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/planos', [PlanoController::class, 'index'])->name('admin.planos');
    Route::get('/admin/planos/criar', [PlanoController::class, 'criar'])->name('admin.planos.criar');
    Route::post('/admin/planos/criar', [PlanoController::class, 'salvar'])->name('admin.planos.salvar');
    Route::get('/admin/planos/{id}/editar', [PlanoController::class, 'editar'])->name('admin.planos.editar');
    Route::post('/admin/planos/{id}/editar', [PlanoController::class, 'atualizar'])->name('admin.planos.atualizar');
    Route::post('/admin/planos/{id}/deletar', [PlanoController::class, 'deletar'])->name('admin.planos.deletar');
});

/*=============== MÉTRICAS — ADMIN ===============*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/metricas', [MetricaController::class, 'index'])->name('admin.metricas');
    Route::get('/admin/metricas/criar', [MetricaController::class, 'criar'])->name('admin.metricas.criar');
    Route::post('/admin/metricas/criar', [MetricaController::class, 'salvar'])->name('admin.metricas.salvar');
    Route::get('/admin/metricas/{id}/editar', [MetricaController::class, 'editar'])->name('admin.metricas.editar');
    Route::post('/admin/metricas/{id}/editar', [MetricaController::class, 'atualizar'])->name('admin.metricas.atualizar');
    Route::post('/admin/metricas/{id}/deletar', [MetricaController::class, 'deletar'])->name('admin.metricas.deletar');
});

/*=============== SUBSCRIÇÃO — USUÁRIO ===============*/
Route::middleware(['auth'])->group(function () {
    Route::get('/subscricao', [SubscricaoController::class, 'index'])->name('usuario.subscricao');
    Route::post('/subscricao/assinar', [SubscricaoController::class, 'assinar'])->name('usuario.subscricao.assinar');
});