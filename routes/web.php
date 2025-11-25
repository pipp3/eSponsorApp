<?php

use App\Http\Controllers\Creator\ProfileController as CreatorProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Creator\LinkController;
use App\Http\Controllers\Creator\SupportController;

/* ============================================
   PÁGINA DE INICIO (PÚBLICA)
   ============================================ */
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/* ============================================
   RUTAS DEL DASHBOARD (REQUIEREN LOGIN)
   Middleware: auth + verified
   ============================================ */
Route::middleware(['auth', 'verified'])->group(function () {

    /* ------ PERFIL DEL CREADOR ------ */
    // GET: Mostrar formulario de edición del perfil de creador
    Route::get('/dashboard/profile', [CreatorProfileController::class, 'edit'])
        ->name('dashboard.profile');

    // PUT: Guardar cambios del perfil de creador (slug, public_name, bio, avatar)
    Route::put('/dashboard/profile', [CreatorProfileController::class, 'update'])
        ->name('dashboard.profile.update');

    /* ------ GESTIÓN DE ENLACES ------ */
    // PUT: Reordenar enlaces con drag & drop
    Route::put('/dashboard/links/reorder', [LinkController::class, 'reorder'])
        ->name('links.reorder');
    
    // CRUD de enlaces: index, create, store, edit, update, destroy
    // Excluye 'show' porque no necesitamos ver enlaces individuales
    Route::resource('/dashboard/links', LinkController::class)->except(['show']);

    /* ------ APOYOS RECIBIDOS ------ */
    // GET: Ver lista de apoyos/donaciones recibidos
    Route::get('/dashboard/supports', [SupportController::class, 'index'])
        ->name('supports.index');
});

/* ============================================
   RUTAS PÚBLICAS DEL CREADOR
   No requieren autenticación
   ============================================ */
// GET: Perfil público del creador (ej: /@juanperez)
Route::get('/@{slug}', [CreatorProfileController::class, 'showPublic'])->name('creator.show');

// POST: Enviar apoyo/donación a un creador (desde su página pública)
Route::post('/@{slug}/support', [SupportController::class, 'storePublic'])->name('support.store');

/* ============================================
   AUTENTICACIÓN (LOGIN, REGISTRO, LOGOUT)
   Definidas en routes/auth.php
   ============================================ */
require __DIR__.'/auth.php';
