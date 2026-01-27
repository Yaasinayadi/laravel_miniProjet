<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Incident;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\NewIncident;

class IncidentController extends Controller
{
    /**
     * Affiche la liste des incidents (User: ses incidents / Admin: tous les incidents)
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'responsable') {
            $incidents = Incident::with(['user', 'resource'])->orderBy('created_at', 'desc')->get();
        } else {
            $incidents = Incident::where('user_id', $user->id)->with(['resource'])->orderBy('created_at', 'desc')->get();
        }

        return view('incidents.index', compact('incidents'));
    }

    /**
     * Affiche le formulaire de signalement
     */
    public function create()
    {
        $user = Auth::user();
        // Optionnel : Passer les ressources réservées par l'utilisateur pour pré-remplir
        $myReservations = Reservation::where('user_id', $user->id)->with('resource')->get();
        $resources = Resource::all();

        return view('incidents.create', compact('myReservations', 'resources'));
    }

    /**
     * Enregistre le nouvel incident
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'priority' => 'required|in:low,medium,high',
            'resource_id' => 'nullable|exists:resources,id',
            'reservation_id' => 'nullable|exists:reservations,id',
        ]);

        $incident = Incident::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'resource_id' => $request->resource_id,
            'reservation_id' => $request->reservation_id,
            'status' => 'open'
        ]);

        // Notifier les admins et responsables
        $admins = User::whereIn('role', ['admin', 'responsable'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewIncident($incident));
        }

        return redirect()->route('incidents.index')->with('success', 'Incident signalé avec succès.');
    }

    /**
     * Marquer un incident comme résolu (Admin/Respo uniquement)
     */
    public function resolve($id)
    {
        $incident = Incident::findOrFail($id);
        $incident->update(['status' => 'resolved']); // ou 'closed'

        // Supprimer la notification associée pour les admins (si désiré)
        // DB::table('notifications')->where('data->incident_id', $id)->delete();

        return redirect()->back()->with('success', 'Incident marqué comme résolu.');
    }

    /**
     * Supprimer une notification (lue/traitée)
     */
    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }
}
