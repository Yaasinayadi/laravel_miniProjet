<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // 1. Afficher le formulaire de réservation
    // On reçoit l'ID de la ressource qu'on veut réserver
    public function create($resource_id)
    {
        $resource = Resource::findOrFail($resource_id);
        return view('reservations.create', compact('resource'));
    }

    // 2. Traitement de la réservation (LE GROS MORCEAU)
    public function store(Request $request)
    {
        // A. Validation basique
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date'  => 'required|date|after:now',     // Pas dans le passé
            'end_date'    => 'required|date|after:start_date', // Fin après début
            'reason'      => 'required|string|max:500',
        ]);


        // On cherche s'il existe UNE réservation pour CETTE ressource

        $conflit = Reservation::where('resource_id', $request->resource_id)
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($request) {

            
                $query->where('start_date', '<', $request->end_date)
                      ->where('end_date', '>', $request->start_date);
            })
            ->exists(); // Renvoie VRAI si un conflit est trouvé

        // Si conflit, on arrête tout !
        if ($conflit) {
            return back()->with('error', 'Impossible ! Cette ressource est déjà réservée sur ce créneau.');
        }

        // C. Tout est bon, on enregistre
        Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $request->resource_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending' // En attente de validation
        ]);

        return redirect()->route('dashboard')->with('success', 'Votre demande est envoyée ! Attendez la validation.');
    }

    // 3. Validation par l'ADMIN
    public function validateReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // On change le statut
        $reservation->status = 'confirmed'; // "confirmed" = officiellement réservé
        $reservation->save();

        return redirect()->back()->with('success', 'Réservation validée avec succès !');
    }
}
