@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Bonjour, {{ Auth::user()->name }} <i class="ri-hand-heart-line" style="color: #f59e0b;"></i></h1>
        <p>Rôle : <span style="color:#4f46e5; font-weight: bold; padding: 0;">{{ Auth::user()->role }}</span></p>
    </div>

    <!-- VUE ADMIN -->
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'responsable')
        <!-- Statistiques Globales -->
        <h3 style="color: #cbd5e1; margin-bottom: 30px;"><i class="ri-bar-chart-grouped-line"></i> Statistiques Globales</h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <!-- Card Utilisateurs -->
            <div class="card" style="background-color: #1f2937; border: 1px solid #374151; padding: 25px; border-left: 5px solid #10b981; border-radius: 8px;">
                <p style="color: grey; font-size: 0.9rem; margin-bottom: 10px;">Utilisateurs</p>
                <h2 style="font-size: 2.5rem; margin: 0; font-weight: bold; color: white;">{{ $stats['total_users'] }}</h2>
                <p style="color: #10b981; font-size: 0.8rem; margin-top: 5px;">{{ $stats['active_users'] }} actifs</p>
            </div>

            <!-- Card Matériels -->
            <div class="card" style="background-color: #1f2937; border: 1px solid #374151; padding: 25px; border-left: 5px solid #f59e0b; border-radius: 8px;">
                <p style="color: grey; font-size: 0.9rem; margin-bottom: 10px;">Matériels</p>
                <h2 style="font-size: 2.5rem; margin: 0; font-weight: bold; color: white;">{{ $stats['total_resources'] }}</h2>
                <p style="color: #ef4444; font-size: 0.8rem; margin-top: 5px;">{{ $stats['inactive_resources'] }} inactifs</p>
            </div>

            <!-- Card Réservations -->
            <div class="card" style="background-color: #1f2937; border: 1px solid #374151; padding: 25px; border-left: 5px solid #3b82f6; border-radius: 8px;">
                <p style="color: grey; font-size: 0.9rem; margin-bottom: 10px;">Réservations Totales</p>
                <h2 style="font-size: 2.5rem; margin: 0; font-weight: bold; color: white;">{{ $stats['total_reservations'] }}</h2>
                <p style="color: #3b82f6; font-size: 0.8rem; margin-top: 5px;">{{ $stats['week_reservations'] }} cette semaine</p>
            </div>

            <!-- Card Taux d'Occupation -->
            <div class="card" style="background-color: #1f2937; border: 1px solid #374151; padding: 25px; border-left: 5px solid #8b5cf6; border-radius: 8px;">
                <p style="color: grey; font-size: 0.9rem; margin-bottom: 10px;">Taux d'Occupation</p>
                <h2 style="font-size: 2.5rem; margin: 0; font-weight: bold; color: white;">{{ $stats['occupancy_rate'] }}%</h2>
                <p style="color: grey; font-size: 0.8rem; margin-top: 5px;">Approuvées / Total</p>
            </div>
        </div>

        <!-- Status des Réservations -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <!-- En Attente -->
            <div class="card" style="background-color: #f59e0b; color: white; padding: 25px; border-radius: 8px;">
                <h4 style="margin: 0 0 10px 0; font-size: 1rem;">En Attente</h4>
                <h2 style="font-size: 2.5rem; margin: 0;">{{ $stats['pending_count'] }}</h2>
                <div style="height: 4px; background: rgba(255,255,255,0.3); margin-top: 15px; border-radius: 2px;"></div>
            </div>

            <!-- Approuvées -->
            <div class="card" style="background-color: #10b981; color: white; padding: 25px; border-radius: 8px;">
                <h4 style="margin: 0 0 10px 0; font-size: 1rem;">Approuvées</h4>
                <h2 style="font-size: 2.5rem; margin: 0;">{{ $stats['approved_count'] }}</h2>
                <div style="height: 4px; background: rgba(255,255,255,0.3); margin-top: 15px; border-radius: 2px;">
                    <div style="width: {{ $stats['total_reservations'] > 0 ? ($stats['approved_count'] / $stats['total_reservations']) * 100 : 0 }}%; height: 100%; background: white; border-radius: 2px;"></div>
                </div>
            </div>

            <!-- Refusées -->
            <div class="card" style="background-color: #ef4444; color: white; padding: 25px; border-radius: 8px;">
                <h4 style="margin: 0 0 10px 0; font-size: 1rem;">Refusées</h4>
                <h2 style="font-size: 2.5rem; margin: 0;">{{ $stats['rejected_count'] }}</h2>
                <div style="height: 4px; background: rgba(255,255,255,0.3); margin-top: 15px; border-radius: 2px;">
                    <div style="width: {{ $stats['total_reservations'] > 0 ? ($stats['rejected_count'] / $stats['total_reservations']) * 100 : 0 }}%; height: 100%; background: white; border-radius: 2px;"></div>
                </div>
            </div>
        </div>

        <!-- Top 3 Ressources Populaires -->
        <h3 style="color: #cbd5e1; margin-top: 40px; margin-bottom: 20px;"><i class="ri-trophy-line"></i> Top 3 Ressources Populaires</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
            @foreach($topResources as $resource)
                <div class="card" style="background-color: #1f2937; border: 1px solid #374151; padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 15px;">
                    <div style="background-color: #374151; padding: 15px; border-radius: 50%;">
                        <i class="ri-macbook-line" style="font-size: 1.5rem; color: #60a5fa;"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; color: white; font-size: 1.1rem;">{{ $resource->name }}</h4>
                        <p style="margin: 5px 0 0; color: grey; font-size: 0.9rem;">{{ $resource->reservations_count }} réservations</p>
                    </div>
                </div>
            @endforeach
        </div>

        <h2 class="rass">Dernières demandes de réservation</h2>
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
                        <tr id="reservation-{{ $resa->id }}">
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
        <!-- ============================== -->
        <!-- VUE ETUDIANT / UTILISATEUR     -->
        <!-- ============================== -->

        <h2 class="rass"><i class="ri-calendar-check-line" style="vertical-align: middle;"></i> Mes Réservations</h2>
        <div class="card">
            @if($myReservations->isEmpty())
                <p>Vous n'avez aucune réservation.</p>
            @else
                <ul style="padding: 0; list-style: none;">
                    @foreach($myReservations as $resa)
                        @php
                            $isExpired = \Carbon\Carbon::parse($resa->end_date)->isPast();
                        @endphp
                        
                        <!-- ICI LA MISE A JOUR "PROFESSIONNELLE" AVEC FLEXBOX -->
                        <li id="reservation-{{ $resa->id }}" 
                            style="
                                display: flex; 
                                justify-content: space-between; 
                                align-items: center; 
                                margin-bottom: 10px; 
                                border-bottom: 1px solid #eee; 
                                padding-bottom: 10px; 
                                {{ $isExpired ? 'opacity: 0.6;' : '' }}
                            ">
                            
                            <!-- Bloc Gauche : Informations -->
                            <div>
                                @if($isExpired) <s> @endif
                                <strong>{{ $resa->resource->name }}</strong> :
                                Du {{ \Carbon\Carbon::parse($resa->start_date)->format('d/m H:i') }}
                                au {{ \Carbon\Carbon::parse($resa->end_date)->format('d/m H:i') }}
                                @if($isExpired) </s> <span style="font-size: 0.8em; color: red;">(Terminé)</span> @endif
                            </div>
                            
                            <!-- Bloc Droite : Statut avec Largeur Fixe -->
                            <div style="width: 120px; text-align: right;">
                                @php
                                    $textColor = 'grey';
                                    if($resa->status === 'confirmed') $textColor = '#10b981'; // Vert
                                    if($resa->status === 'rejected') $textColor = '#ef4444'; // Rouge
                                @endphp
                                <span style="color: {{ $textColor }}; font-weight: bold;">
                                    {{ ucfirst($resa->status) }}
                                </span>
                            </div>
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
                    <div style="flex: 1 1 250px; max-width: 350px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; height: 100%; background: #2D333B; color: white; margin: 0 auto;">
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