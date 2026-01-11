<?php

use Illuminate\Support\Facades\Route;
// On importe les Contrôleurs ici pour que ce soit plus propre
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;

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

    // CORRECTION ICI : Le crochet ] se met APRES 'store'
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');

});

// === SYSTEME DE RESERVATION (MEMBRE 3) ===
Route::middleware(['auth'])->group(function(){

    Route::get('/reserve/{resource_id}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reserve', [ReservationController::class, 'store'])->name('reservations.store');

});
