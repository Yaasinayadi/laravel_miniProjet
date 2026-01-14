@extends('layouts.app')

@section('content')
<h1 class="rass">Modifier l'équipement : {{ $resource->name }}</h1>

<div class="card anoInp" style="max-width: 600px;">
    <form action="{{ route('resources.update', $resource->id) }}" method="POST">
        @csrf 
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Nom de l'équipement :</label>
            <input type="text" name="name" value="{{ old('name', $resource->name) }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Catégorie :</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $resource->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Description :</label>
            <textarea name="description" rows="3">{{ old('description', $resource->description) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Caractéristiques Techniques (Specs) :</label>
            <textarea name="specs" rows="2">{{ old('specs', $resource->specs) }}</textarea>
        </div>

        <div class="level">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('resources.index') }}" class="btn btn-danger" style="padding: 3px 100px;">Annuler</a>
        </div>
    </form>
</div>
@endsection
