<?php

use Illuminate\Support\Facades\Route;

// Import propre des contrôleurs
// Import propre des contrôleurs
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncidentController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

// --- TABLEAU DE BORD ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === ESPACE ADMIN (Membre 1 & 2) and responsable ===
Route::middleware(['auth', 'role:admin,responsable'])->group(function () {

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

    // // Gestion des Users
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Route::post('/users/{id}/promote', [UserController::class, 'promote'])->name('users.promote');
    // Route::post('/users/{id}/ban', [UserController::class, 'toggleBan'])->name('users.ban');

    // Validation des réservations (Route PUT demandée)
    Route::put('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::put('/reservations/{id}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
});

// === ESPACE USER (Membre 3)  seul admin peut acceder a ca ===//
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/promote', [UserController::class, 'promote'])->name('users.promote');
    Route::post('/users/{id}/ban', [UserController::class, 'toggleBan'])->name('users.ban');

});


// === SYSTEME DE RESERVATION (Membre 3)  ESPACE MEMBRE (Tout le monde connecté) ===
Route::middleware(['auth'])->group(function () {
    // Création d'une demande
    Route::get('/reserve/{resource_id}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reserve', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/resource/{id}', [ResourceController::class, 'show'])->name('resources.show');

    // Gestion des Incidents
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    Route::put('/incidents/{id}/resolve', [IncidentController::class, 'resolve'])->name('incidents.resolve');
    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});
