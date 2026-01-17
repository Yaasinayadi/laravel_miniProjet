<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();

        if($user->role === 'admin' || $user->role === 'responsable') {
            // Statistiques de base
            $stats = [
                'total_users' => User::count(),
                'total_resources' => Resource::count(),
                'total_reservations' => Reservation::count(),
                'pending_reservations' => Reservation::where('status', 'pending')->count(),
                'approved_reservations' => Reservation::where('status', 'confirmed')->count(),
                'rejected_reservations' => Reservation::where('status', 'rejected')->count(),
                'active_users' => User::where('is_active', true)->count(),
                'inactive_resources' => Resource::where('state', '!=', 'active')->count(),
            ];

            // Taux d'occupation global (pourcentage de réservations approuvées)
            $stats['occupation_rate'] = $stats['total_reservations'] > 0 
                ? round(($stats['approved_reservations'] / $stats['total_reservations']) * 100, 1)
                : 0;

            // Top 3 ressources les plus réservées
            $topResources = Reservation::select('resource_id', DB::raw('count(*) as total'))
                ->groupBy('resource_id')
                ->orderBy('total', 'desc')
                ->limit(3)
                ->with('resource')
                ->get();

            // Réservations par statut (pour graphique)
            $reservationsByStatus = [
                'pending' => $stats['pending_reservations'],
                'approved' => $stats['approved_reservations'],
                'rejected' => $stats['rejected_reservations'],
            ];

            // Réservations des 7 derniers jours
            $recentReservations = Reservation::where('created_at', '>=', now()->subDays(7))
                ->count();

            // Réservations en attente avec détails
            $pendingReservations = Reservation::where('status', 'pending')
                ->with(['user', 'resource'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('dashboard', compact(
                'pendingReservations', 
                'stats', 
                'topResources', 
                'reservationsByStatus',
                'recentReservations'
            ));
        }
        else {
            // Vue utilisateur (inchangée)
            $query = Resource::where('state', 'active');

            if ($request->has('category_id') && $request->category_id != '') {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('search') && $request->search != '') {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $resources = $query->get();
            $categories = \App\Models\Category::all();

            $myReservations = Reservation::where('user_id', $user->id)
                ->with('resource')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('dashboard', compact('resources', 'myReservations', 'categories'));
        }
    }
}