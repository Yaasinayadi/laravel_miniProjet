<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resource;
use App\Models;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'responsable') {
            //voit toutes les demandes en attente
            $pendingReservations = Reservation::where('status', 'pending')->with(['user', 'resource'])->get();

            // --- STATISTIQUES GLOBALES ---
            $totalUsers = \App\Models\User::count();
            $activeUsers = \App\Models\User::where('is_active', true)->count(); // Suppose 'is_active' boolean

            $totalResources = Resource::count();
            $inactiveResources = Resource::where('state', '!=', 'active')->count(); // Suppose 'state' column

            $totalReservations = Reservation::count();
            $weekReservations = Reservation::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

            // Taux d'occupation (Approuvées / Total)
            $approvedReservationsCount = Reservation::where('status', 'confirmed')->count();
            $occupancyRate = $totalReservations > 0 ? round(($approvedReservationsCount / $totalReservations) * 100) : 0;

            // --- STATUS ---
            $pendingCount = Reservation::where('status', 'pending')->count();
            $approvedCount = $approvedReservationsCount;
            $rejectedCount = Reservation::where('status', 'rejected')->count();

            // --- TOP RESSOURCES ---
            $topResources = Resource::withCount('reservations')
                ->orderBy('reservations_count', 'desc')
                ->take(3)
                ->get();

            $stats = [
                'total_users' => $totalUsers,
                'active_users' => $activeUsers,
                'total_resources' => $totalResources,
                'inactive_resources' => $inactiveResources,
                'total_reservations' => $totalReservations,
                'week_reservations' => $weekReservations,
                'occupancy_rate' => $occupancyRate,
                'pending_count' => $pendingCount,
                'approved_count' => $approvedCount,
                'rejected_count' => $rejectedCount,
            ];

            return view('dashboard', compact('pendingReservations', 'stats', 'topResources'));
        } else {
            //voir seulement catalogue + ses reservations
            $query = Resource::where('state', 'active');

            // Filtre par catégorie
            if ($request->has('category_id') && $request->category_id != '') {
                $query->where('category_id', $request->category_id);
            }

            // Barre de recherche
            if ($request->has('search') && $request->search != '') {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $resources = $query->get();
            $categories = \App\Models\Category::all();

            $myReservations = Reservation::where('user_id', $user->id)->with('resource')->orderBy('created_at', 'desc')->get();

            return view('dashboard', compact('resources', 'myReservations', 'categories'));
        }
    }
}
