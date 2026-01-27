@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes Réservations</h1>
    
    <table>
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Période</th>
                <th>Statut</th>
                <th>Date de demande</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->resource->name }}</td>
                <td>{{ $reservation->start_date }} → {{ $reservation->end_date }}</td>
                <td>
                    <span class="badge badge-{{ $reservation->status }}">
                        {{ $reservation->status }}
                    </span>
                </td>
                <td>{{ $reservation->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
