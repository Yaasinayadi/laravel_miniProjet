@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Bonjour, {{ Auth::user()->name }} <i class="ri-hand-heart-line" style="color: #f59e0b;"></i></h1>
    <p>Rôle : <span style="color:#4f46e5; font-weight: bold; padding: 0;">{{ Auth::user()->role }}</span></p>
</div>

<!-- VUE ADMIN -->
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'responsable')
    
    <!-- Statistiques Principales -->
    <h2 class="rass"><i class="ri-bar-chart-line" style="vertical-align: middle;"></i> Statistiques Globales</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <div class="card" style="border-left: 4px solid #10b981;">
            <h3 style="margin: 0; font-size: 0.9rem; color: grey;">Utilisateurs</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['total_users'] }}</p>
            <small style="color: #10b981;">{{ $stats['active_users'] }} actifs</small>
        </div>

        <div class="card" style="border-left: 4px solid #f59e0b;">
            <h3 style="margin: 0; font-size: 0.9rem; color: grey;">Matériels</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['total_resources'] }}</p>
            <small style="color: #ef4444;">{{ $stats['inactive_resources'] }} inactifs</small>
        </div>

        <div class="card" style="border-left: 4px solid #3b82f6;">
            <h3 style="margin: 0; font-size: 0.9rem; color: grey;">Réservations Totales</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['total_reservations'] }}</p>
            <small style="color: #3b82f6;">{{ $recentReservations }} cette semaine</small>
        </div>

        <div class="card" style="border-left: 4px solid #8b5cf6;">
            <h3 style="margin: 0; font-size: 0.9rem; color: grey;">Taux d'Occupation</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['occupation_rate'] }}%</p>
            <small style="color: grey;">Approuvées / Total</small>
        </div>
    </div>

    <!-- Statistiques par Statut -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <div class="card" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white;">
            <h3 style="margin: 0; font-size: 0.9rem; opacity: 0.9;">En Attente</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['pending_reservations'] }}</p>
            <div style="width: 100%; background: rgba(255,255,255,0.3); height: 8px; border-radius: 4px; overflow: hidden;">
                <div style="width: {{ $stats['total_reservations'] > 0 ? ($stats['pending_reservations'] / $stats['total_reservations'] * 100) : 0 }}%; background: white; height: 100%;"></div>
            </div>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
            <h3 style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Approuvées</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['approved_reservations'] }}</p>
            <div style="width: 100%; background: rgba(255,255,255,0.3); height: 8px; border-radius: 4px; overflow: hidden;">
                <div style="width: {{ $stats['total_reservations'] > 0 ? ($stats['approved_reservations'] / $stats['total_reservations'] * 100) : 0 }}%; background: white; height: 100%;"></div>
            </div>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
            <h3 style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Refusées</h3>
            <p style="font-size: 2.5rem; margin: 10px 0; font-weight: bold;">{{ $stats['rejected_reservations'] }}</p>
            <div style="width: 100%; background: rgba(255,255,255,0.3); height: 8px; border-radius: 4px; overflow: hidden;">
                <div style="width: {{ $stats['total_reservations'] > 0 ? ($stats['rejected_reservations'] / $stats['total_reservations'] * 100) : 0 }}%; background: white; height: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Top 3 Ressources -->
    <h2 class="rass"><i class="ri-trophy-line" style="vertical-align: middle;"></i> Top 3 Ressources Populaires</h2>
    <div class="card" style="margin-bottom: 30px;">
        @if($topResources->isEmpty())
            <p style="text-align: center; color: grey;">Aucune réservation encore effectuée.</p>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                @foreach($topResources as $index => $item)
                    <div style="padding: 20px; border: 2px solid {{ $index === 0 ? '#fbbf24' : ($index === 1 ? '#d1d5db' : '#cd7f32') }}; border-radius: 8px; text-align: center; position: relative;">
                        <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: {{ $index === 0 ? '#fbbf24' : ($index === 1 ? '#d1d5db' : '#cd7f32') }}; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold;">
                            #{{ $index + 1 }}
                        </div>
                        <h3 style="margin-top: 20px;">{{ $item->resource->name }}</h3>
                        <p style="color: grey; margin: 5px 0;">{{ $item->resource->category->name }}</p>
                        <p style="font-size: 2rem; font-weight: bold; color: #3b82f6; margin: 10px 0;">{{ $item->total }}</p>
                        <small style="color: grey;">réservation(s)</small>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Demandes en Attente -->
    <h2 class="rass"><i class="ri-time-line" style="vertical-align: middle;"></i> Dernières demandes de réservation</h2>
    <div class="card">
        @if($pendingReservations->isEmpty())
            <p>Aucune demande en attente.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Matériel</th>
                        <th>Dates</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingReservations as $resa)
                    <tr>
                        <td>{{ $resa->user->name }}</td>
                        <td>{{ $resa->resource->name }}</td>
                        <td>
                            Du {{ \Carbon\Carbon::parse($resa->start_date)->format('d/m H:i') }}<br>
                            Au {{ \Carbon\Carbon::parse($resa->end_date)->format('d/m H:i') }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <form action="{{ route('reservations.validate', $resa->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary" style="font-size: 0.8rem;">Valider</button>
                                </form>

                                <form action="{{ route('reservations.reject', $resa->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.8rem; color: white; border:none;">Refuser</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@else
<!-- VUE ETUDIANT / UTILISATEUR -->

    <h2 class="rass"><i class="ri-calendar-check-line" style="vertical-align: middle;"></i> Mes Réservations</h2>
    <div class="card">
        @if($myReservations->isEmpty())
            <p>Vous n'avez aucune réservation.</p>
        @else
            <ul>
                @foreach($myReservations as $resa)
                    @php
                        $isExpired = \Carbon\Carbon::parse($resa->end_date)->isPast();
                    @endphp
                    <li style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px; {{ $isExpired ? 'opacity: 0.6;' : '' }}">
                        @if($isExpired) <s> @endif
                        <strong>{{ $resa->resource->name }}</strong> :
                        Du {{ \Carbon\Carbon::parse($resa->start_date)->format('d/m H:i') }}
                        au {{ \Carbon\Carbon::parse($resa->end_date)->format('d/m H:i') }}
                        @if($isExpired) </s> <span style="font-size: 0.8em; color: red;">(Terminé)</span> @endif
                        
                        @php
                            $textColor = 'grey';
                            if($resa->status === 'confirmed') $textColor = '#10b981';
                            if($resa->status === 'rejected') $textColor = '#ef4444';
                        @endphp
                        <span style="color: {{ $textColor }}; font-weight: bold; padding: 0;">{{ $resa->status }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <h2 class="rass"><i class="ri-macbook-line" style="vertical-align: middle;"></i> Catalogue Matériel (Réserver)</h2>
    
    <!-- Filtres -->
    <div class="card" style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('dashboard') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;" class="anoInp">
                <input type="text" name="search" placeholder="🔍 Rechercher un matériel..." value="{{ request('search') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            
            <div style="flex: 1; min-width: 200px;" class="anoInp">
                <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgb(99, 98, 98); color: white;">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Filtrer</button>
            @if(request('search') || request('category_id'))
                <a href="{{ route('dashboard') }}" style="color: #ef4444; text-decoration: underline; white-space: nowrap;">Réinitialiser</a>
            @endif
        </form>
    </div>

    <div class="card">
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: flex-start;">
            @foreach($resources as $resource)
                <div style="
                    flex: 1 1 250px; 
                    max-width: 350px; 
                    border: 1px solid #ddd; 
                    padding: 20px; 
                    border-radius: 8px; 
                    text-align: center; 
                    display: flex; 
                    flex-direction: column; 
                    justify-content: space-between; 
                    height: 100%; 
                    background: #2D333B;
                    color: white;
                    margin: 0 auto;
                ">
                    <div>
                        <h3 style="margin-bottom: 5px;">{{ $resource->name }}</h3>
                        <p style="color: grey; margin-top: 0;">{{ $resource->category->name }}</p>
                    </div>
                    
                    <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
                        <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-info" style="display: block; width: 100%; box-sizing: border-box; border-radius: 15px;text-align: center; background-color: #3b82f6; color: white; border: none;">Voir détails</a>

                        <a href="{{ route('reservations.create', $resource->id) }}" class="btn btn-success" style="display: block; width: 100%; box-sizing: border-box; text-align: center;">Réserver</a>
                    </div>                
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection