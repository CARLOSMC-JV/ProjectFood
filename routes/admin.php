<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        // Agrega más rutas de administrador según tus necesidades
    });