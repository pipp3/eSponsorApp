<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Creator\ProfileController as CreatorProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Creator\LinkController;
use App\Http\Controllers\Creator\SupportController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard/profile', [CreatorProfileController::class, 'edit'])
        ->name('dashboard.profile');

    Route::put('/dashboard/profile', [CreatorProfileController::class, 'update'])
        ->name('dashboard.profile.update');

    Route::put('/dashboard/links/reorder', [LinkController::class, 'reorder'])
        ->name('links.reorder');
    
    Route::resource('/dashboard/links', LinkController::class)->except(['show']);

    Route::get('/dashboard/supports', [SupportController::class, 'index'])
        ->name('supports.index');
});

// Rutas públicas del creador
Route::get('/@{slug}', [CreatorProfileController::class, 'showPublic'])->name('creator.show');
Route::post('/@{slug}/support', [SupportController::class, 'storePublic'])->name('support.store');

require __DIR__.'/auth.php';
