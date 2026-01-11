@extends('layouts.app')

@section('content')
<h1>Ajouter un nouvel équipement</h1>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('resources.store') }}" method="POST">
        @csrf <!-- Sécurité obligatoire -->

        <div style="margin-bottom: 15px;">
            <label>Nom de l'équipement :</label>
            <input type="text" name="name" placeholder="Ex: Serveur Dell PowerEdge" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Catégorie :</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Description :</label>
            <textarea name="description" placeholder="Description générale..." rows="3"></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Caractéristiques Techniques (Specs) :</label>
            <textarea name="specs" placeholder="Ex: CPU i7, 32GB RAM..." rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer le matériel</button>
        <a href="{{ route('resources.index') }}" class="btn btn-danger">Annuler</a>
    </form>
</div>
@endsection
