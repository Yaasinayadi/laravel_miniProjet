@extends('layouts.app')

@section('content')
<h1>Nouvelle Réservation</h1>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2 style="color: #4f46e5;">Réserver : {{ $resource->name }}</h2>
    <p>Catégorie : <strong>{{ $resource->category->name }}</strong></p>

    <!-- Affichage des erreurs (ex: Conflit de date) -->
    @if(session('error'))
        <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- AJOUT : Affichage des erreurs de validation -->
    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Fin AJOUT -->
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <!-- On passe l'ID de la ressource en caché -->
        <input type="hidden" name="resource_id" value="{{ $resource->id }}">

        <div class="form-group">
            <label>Date de début :</label>
            <input type="datetime-local" name="start_date" required>
        </div>

        <div class="form-group">
            <label>Date de fin :</label>
            <input type="datetime-local" name="end_date" required>
        </div>

        <div class="form-group">
            <label>Motif de la demande :</label>
            <textarea name="reason" placeholder="Pour quel projet ? Pourquoi ce matériel ?" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
        <a href="{{ route('dashboard') }}" class="btn" style="color: grey;">Annuler</a>
    </form>
</div>
@endsection
