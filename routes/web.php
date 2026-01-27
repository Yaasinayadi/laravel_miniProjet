<?php

use Illuminate\Support\Facades\Route;

// Import des contrôleurs
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\RegistrationRequestController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// ROUTES VISITEUR (Sans authentification)
Route::prefix('visitor')->name('visitor.')->group(function () {
    Route::get('/', [VisitorController::class, 'index'])->name('index');
    Route::get('/resources', [VisitorController::class, 'resources'])->name('resources');
    Route::get('/resource/{id}', [VisitorController::class, 'showResource'])->name('resource.show');
    Route::get('/request-account', [RegistrationRequestController::class, 'create'])->name('request-account');
    Route::post('/request-account', [RegistrationRequestController::class, 'store'])->name('request-account.store');
});

require __DIR__.'/auth.php';

// --- TABLEAU DE BORD ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === ESPACE ADMIN (Gestion complète) ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {
    // Gestion des utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/promote', [UserController::class, 'promote'])->name('users.promote');
    Route::post('/users/{id}/ban', [UserController::class, 'toggleBan'])->name('users.ban');
    
    // Gestion des demandes d'inscription
    Route::get('/registration-requests', [RegistrationRequestController::class, 'index'])->name('registration-requests');
    Route::post('/registration-requests/{id}/approve', [RegistrationRequestController::class, 'approve'])->name('registration-requests.approve');
    Route::post('/registration-requests/{id}/reject', [RegistrationRequestController::class, 'reject'])->name('registration-requests.reject');
});

// === ESPACE ADMIN + RESPONSABLE (Gestion ressources) ===
Route::middleware(['auth', 'role:admin,responsable'])->group(function() {
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

    // Validation des réservations
    Route::put('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::put('/reservations/{id}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
});

// === SYSTEME DE RESERVATION (Tout le monde connecté) ===
Route::middleware(['auth'])->group(function () {
    // Création d'une demande
    Route::get('/reserve/{resource_id}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reserve', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/resource/{id}', [ResourceController::class, 'show'])->name('resources.show');
});
