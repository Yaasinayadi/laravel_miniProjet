<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// === GESTION DU MATERIEL (MEMBRE 2) ===
// Route sécurisée Admin
Route::middleware(['auth', 'role:admin'])->group(function() {

    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');


    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    
    // Modification
    Route::get('/resources/{id}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::put('/resources/{id}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{id}', [ResourceController::class, 'destroy'])->name('resources.destroy');
    
    // Validation des réservations
    Route::put('/reservations/{id}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');

});

// === SYSTEME DE RESERVATION (MEMBRE 3) ===
Route::middleware(['auth'])->group(function () {

    // Afficher le formulaire pour UNE ressource spécifique
    Route::get('/reserve/{resource_id}', [App\Http\Controllers\ReservationController::class, 'create'])
        ->name('reservations.create');

    // Enregistrer la réservation (POST)
    Route::post('/reserve', [App\Http\Controllers\ReservationController::class, 'store'])
        ->name('reservations.store');
});
Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])->name('dashboard');

