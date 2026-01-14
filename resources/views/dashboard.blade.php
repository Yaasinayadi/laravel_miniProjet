@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Bonjour, {{ Auth::user()->name }} <i class="ri-hand-heart-line" style="color: #f59e0b;"></i></h1>
    <p>Rôle : <span style="color:#4f46e5; font-weight: bold; padding: 0;">{{ Auth::user()->role }}</span></p>
</div>

<!-- VUE ADMIN -->
@if(Auth::user()->role === 'admin')
    <div style="display: flex; gap: 20px;">
        <div class="card" style="flex:1; border-left: 4px solid #10b981;">
            <h3>Utilisateurs</h3>
            <p style="font-size: 2rem; margin:0;">{{ $stats['total_users'] }}</p>
        </div>
        <div class="card" style="flex:1; border-left: 4px solid #f59e0b;">
            <h3>Matériels</h3>
            <p style="font-size: 2rem; margin:0;">{{ $stats['total_resources'] }}</p>
        </div>
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
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.8rem; background-color: #ef4444; color: white; border:none;">Refuser</button>
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
                            if($resa->status === 'confirmed') $textColor = '#10b981'; // Vert
                            if($resa->status === 'rejected') $textColor = '#ef4444'; // Rouge
                        @endphp
                        <span style="color: {{ $textColor }}; font-weight: bold; padding: 0;">{{ $resa->status }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <h2 class="rass"><i class="ri-macbook-line" style="vertical-align: middle;"></i> Catalogue Matériel (Réserver)</h2>
    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @foreach($resources as $resource)
                <div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center;">
                    <h3>{{ $resource->name }}</h3>
                    <p style="color: grey;">{{ $resource->category->name }}</p>
                    <a href="{{ route('reservations.create', $resource->id) }}" class="btn btn-success">Réserver</a>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
