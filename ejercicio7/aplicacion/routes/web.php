<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TipoLavadoController;
use App\Http\Controllers\GoogleController;

Route::get('/',[CitasController::class, 'landing'])->name('citas.landing');
Route::get('/citas/index',[CitasController::class, 'index'])->name('citas.index');

Route::get('/citas/create',[CitasController::class, 'create'])->name('citas.create');
Route::post('/citas/store',[CitasController::class, 'store'])->name('citas.store');

Route::get('/citas/landing',[CitasController::class, 'landing'])->name('citas.landing');

Route::get('/tipoLavado/regLavado',[TipoLavadoController::class, 'regLavado'])->name('tipoLavado.regLavado');
Route::get('/tipoLavado/listLavado',[TipoLavadoController::class, 'listLavado'])->name('tipoLavado.listLavado');
Route::post('/tipoLavado/getListado',[TipoLavadoController::class, 'getListado'])->name('tipoLavado.getListado');

Route::get('/usuarios/login',[UsuariosController::class, 'login'])->name('usuarios.login');
Route::post('/usuarios/authenticate',[UsuariosController::class, 'authenticate'])->name('usuarios.authenticate');

Route::get('/usuarios/logout',[UsuariosController::class, 'logout'])->name('usuarios.logout');

Route::get('/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
