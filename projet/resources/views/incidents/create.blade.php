@extends('layouts.app')

@section('content')
    <div style="max-width: 800px; margin: 0 auto; padding-top: 20px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: white; font-weight: bold; font-size: 1.5rem;"><i class="ri-alarm-warning-line"
                    style="margin-right: 10px;"></i> Signaler un Incident</h2>
        </div>

        <div class="card" style="background-color: #2D333B; padding: 40px; border-radius: 8px; color: white;">
            <form action="{{ route('incidents.store') }}" method="POST">
                @csrf

                <!-- Titre -->
                <div style="margin-bottom: 20px;">
                    <label for="title" style="display: block; margin-bottom: 8px; font-weight: bold;">Titre du problème
                        <span style="color: red;">*</span></label>
                    <input type="text" name="title" id="title" placeholder="Ex: Serveur inaccessible, Panne réseau..."
                        required
                        style="width: 100%; padding: 12px; background-color: #4b5563; border: 1px solid #6b7280; color: white; border-radius: 6px;">
                </div>

                <!-- Priorité -->
                <div style="margin-bottom: 20px;">
                    <label for="priority" style="display: block; margin-bottom: 8px; font-weight: bold;">Priorité <span
                            style="color: red;">*</span></label>
                    <select name="priority" id="priority" required
                        style="width: 100%; padding: 12px; background-color: #4b5563; border: 1px solid #6b7280; color: white; border-radius: 6px;">
                        <option value="">-- Sélectionnez la priorité --</option>
                        <option value="low">Bas</option>
                        <option value="medium">Moyen</option>
                        <option value="high">Élevé</option>
                    </select>
                </div>

                <!-- Ressource Concernée -->
                <div style="margin-bottom: 20px;">
                    <label for="resource_id" style="display: block; margin-bottom: 8px; font-weight: bold;">Ressource
                        concernée (optionnel)</label>
                    <select name="resource_id" id="resource_id"
                        style="width: 100%; padding: 12px; background-color: #4b5563; border: 1px solid #6b7280; color: white; border-radius: 6px;">
                        <option value="">-- Aucune ressource spécifique --</option>
                        @foreach($resources as $resource)
                            <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Réservation Concernée -->
                <div style="margin-bottom: 20px;">
                    <label for="reservation_id" style="display: block; margin-bottom: 8px; font-weight: bold;">Réservation
                        concernée (optionnel)</label>
                    <select name="reservation_id" id="reservation_id"
                        style="width: 100%; padding: 12px; background-color: #4b5563; border: 1px solid #6b7280; color: white; border-radius: 6px;">
                        <option value="">-- Aucune réservation --</option>
                        @foreach($myReservations as $resa)
                            <option value="{{ $resa->id }}">{{ $resa->resource->name }} ({{ $resa->start_date }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div style="margin-bottom: 30px;">
                    <label for="description" style="display: block; margin-bottom: 8px; font-weight: bold;">Description détaillée <span style="color: red;">*</span></label>
                    <textarea name="description" id="description" rows="5"
                        placeholder="Décrivez le problème rencontré en détail (au moins 20 caractères)..." required
                        style="width: 100%; padding: 12px; background-color: #4b5563; border: 1px solid #6b7280; color: white; border-radius: 6px; font-family: inherit;"></textarea>
                    <p style="font-size: 0.8rem; color: #9ca3af; margin-top: 5px;">Fournissez un maximum d'informations :
                        quand le problème est survenu, les symptômes observés, les messages d'erreur éventuels, etc.</p>
                </div>

                <!-- Boutons -->
                <div style="text-align: center; display: flex; gap: 15px; justify-content: center;">
                    <button type="submit" class="btn btn-primary"
                        style="padding: 12px 30px; font-weight: bold;border: none; border-radius: 25px;">
                        <i class="ri-send-plane-fill"></i> Signaler l'incident</button>
                    <a href="{{ route('incidents.index') }}" class="btn btn-danger"
                        style="padding: 12px 30px; font-weight: bold;color: white; border-radius: 25px; text-decoration: none;">Annuler</a>
                </div>

            </form>
        </div>
    </div>
@endsection