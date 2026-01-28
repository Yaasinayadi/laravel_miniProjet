<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewReservation;
use App\Notifications\ReservationStatusUpdated;

class ReservationController extends Controller
{
    // 1. Afficher le formulaire de réservation
    // On reçoit l'ID de la ressource qu'on veut réserver
    public function create($resource_id)
    {
        if(Auth::user()->role === 'invite') {
            abort(403, "Votre compte n'est pas encore validé par l'administrateur.");
        }
        $resource = Resource::findOrFail($resource_id);
        return view('reservations.create', compact('resource'));
    }

    // 2. Traitement de la réservation (LE GROS MORCEAU)
    public function store(Request $request)
    {
        //check if the user is invite
        if(Auth::user()->role === 'invite') {
            abort(403, "Votre compte n'est pas encore validé par l'administrateur.");
        }
        // A. Validation basique
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date'  => 'required|date|after:now',     // Pas dans le passé
            'end_date'    => 'required|date|after:start_date', // Fin après début
            'reason'      => 'required|string|max:500',
        ]);


        // On cherche s'il existe UNE réservation pour CETTE ressource

        $existingReservation = Reservation::where('resource_id', $request->resource_id)
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<', $request->end_date)
                      ->where('end_date', '>', $request->start_date);
            })
            ->first();

        if ($existingReservation) {
            $formattedStart = \Carbon\Carbon::parse($existingReservation->start_date)->format('d/m H:i');
            $formattedEnd = \Carbon\Carbon::parse($existingReservation->end_date)->format('d/m H:i');
            
            return back()->with('error', "Impossible ! Cette ressource est déjà réservée du $formattedStart au $formattedEnd.");
        }

        // C. Tout est bon, on enregistre
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $request->resource_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending' // En attente de validation
        ]);

        // Notifier les admins et responsables
        $admins = User::whereIn('role', ['admin', 'responsable'])->get();
        Notification::send($admins, new NewReservation($reservation));

        return redirect()->route('dashboard')->with('success', 'Votre demande est envoyée ! Attendez la validation.');
    }

    // 3. Validation par l'ADMIN
    public function validateReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        // On change le statut
        $reservation->status = 'confirmed'; // "confirmed" = officiellement réservé
        $reservation->save();

        // Notifier l'utilisateur
        $reservation->user->notify(new ReservationStatusUpdated($reservation, 'confirmée'));

        return redirect()->back()->with('success', 'Réservation validée avec succès !');
    }

    // 4. Refus par l'ADMIN
    public function rejectReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'rejected';
        $reservation->save();

        // Notifier l'utilisateur
        $reservation->user->notify(new ReservationStatusUpdated($reservation, 'refusée'));

        return redirect()->back()->with('success', 'Réservation refusée.');
    }
}
