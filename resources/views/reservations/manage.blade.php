@extends('layouts.app')

@section('content')
<div class="card">
    <h1>🔧 Gestion des Réservations</h1>
    <p>En tant que <strong>{{ Auth::user()->role }}</strong>, vous pouvez approuver ou refuser les demandes.</p>
</div>

@if(session('success'))
    <div style="background: #10b981; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #ef4444; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        ❌ {{ session('error') }}
    </div>
@endif

<div class="card">
    @if($reservations->isEmpty())
        <p style="text-align: center; color: grey; padding: 40px;">
            📭 Aucune réservation dans le système.
        </p>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3f4f6;">
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Utilisateur</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Ressource</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Période</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Raison</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #ddd;">Statut</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #ddd;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">
                        <strong>{{ $reservation->user->name }}</strong><br>
                        <small style="color: grey;">{{ $reservation->user->email }}</small>
                    </td>
                    <td style="padding: 12px;">
                        <strong>{{ $reservation->resource->name }}</strong><br>
                        <small style="color: grey;">{{ $reservation->resource->category->name }}</small>
                    </td>
                    <td style="padding: 12px;">
                        <strong>Du:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}<br>
                        <strong>Au:</strong> {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding: 12px; max-width: 200px;">
                        <small>{{ Str::limit($reservation->reason, 50) }}</small>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        @if($reservation->status === 'pending')
                            <span style="background: #fbbf24; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem;">
                                ⏳ En attente
                            </span>
                        @elseif($reservation->status === 'approved')
                            <span style="background: #10b981; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem;">
                                ✅ Approuvée
                            </span>
                        @elseif($reservation->status === 'rejected')
                            <span style="background: #ef4444; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem;">
                                ❌ Refusée
                            </span>
                        @else
                            <span style="background: grey; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem;">
                                {{ $reservation->status }}
                            </span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        @if($reservation->status === 'pending')
                            <form method="POST" action="{{ route('reservations.approve', $reservation->id) }}" style="display:inline; margin-right: 5px;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-size: 0.9rem;">
                                    ✅ Approuver
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('reservations.reject', $reservation->id) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; font-size: 0.9rem;">
                                    ❌ Refuser
                                </button>
                            </form>
                        @else
                            <em style="color: grey;">Déjà traitée</em>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 12px 24px; background: #6b7280; color: white; text-decoration: none; border-radius: 8px;">
        ← Retour au Dashboard
    </a>
</div>
@endsection
