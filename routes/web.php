<?php

use Illuminate\Support\Facades\Route;

// Import propre des contrôleurs
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

// --- TABLEAU DE BORD ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === ESPACE ADMIN (Membre 1 & 2) ===
Route::middleware(['auth', 'role:admin'])->group(function() {

    // Gestion Matériel
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');

    // Modification & Suppression
    Route::get('/resources/{id}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{id}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{id}', [ResourceController::class, 'destroy'])->name('resources.destroy');

    // Activer/Désactiver
    Route::put('/resources/{id}/toggle', [ResourceController::class, 'toggleState'])->name('resources.toggle');

    // Gestion des Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/promote', [UserController::class, 'promote'])->name('users.promote');
    Route::post('/users/{id}/ban', [UserController::class, 'toggleBan'])->name('users.ban');

    // Validation des réservations (Route PUT demandée)
    Route::put('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::put('/reservations/{id}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
});

// === SYSTEME DE RESERVATION (Membre 3) ===
Route::middleware(['auth'])->group(function () {
    // Création d'une demande
    Route::get('/reserve/{resource_id}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reserve', [ReservationController::class, 'store'])->name('reservations.store');
});
