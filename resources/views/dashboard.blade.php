@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Bonjour, {{ Auth::user()->name }} 👋</h1>
    <p>Rôle : <span class="status-badge" style="background:#4f46e5;">{{ Auth::user()->role }}</span></p>
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

    <h2>Dernières demandes de réservation</h2>
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
                            <form action="{{ route('reservations.validate', $resa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary" style="font-size: 0.8rem;">Valider</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@else
<!-- VUE ETUDIANT / UTILISATEUR -->

    <h2>📅 Mes Réservations</h2>
    <div class="card">
        @if($myReservations->isEmpty())
            <p>Vous n'avez aucune réservation.</p>
        @else
            <ul>
                @foreach($myReservations as $resa)
                    <li style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <strong>{{ $resa->resource->name }}</strong> :
                        Du {{ \Carbon\Carbon::parse($resa->start_date)->format('d/m H:i') }}
                        au {{ \Carbon\Carbon::parse($resa->end_date)->format('d/m H:i') }}
                        <span class="status-badge" style="background: grey;">{{ $resa->status }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <h2>💻 Catalogue Matériel (Réserver)</h2>
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
