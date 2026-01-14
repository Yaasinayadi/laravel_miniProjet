@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="rass">Gestion du Matériel</h1>
    <a href="{{ route('resources.create') }}" class="btn btn-primary">Ajouter un équipement</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Catégorie</th>
                <th>Nom</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->id }}</td>
                <td>{{ $resource->category->name }}</td>
                <td>{{ $resource->name }}</td>
                <td>
                    <form action="{{ route('resources.toggle', $resource->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" 
                            style="border: none; cursor: pointer; border-radius: 12px; padding: 5px 10px; font-weight: bold; font-size: 12px; color: white;
                            background-color: {{ $resource->state === 'active' ? '#10b981' : '#ef4444' }};">
                            {{ ucfirst($resource->state) }}
                        </button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('resources.edit', $resource->id) }}" class="btn btn-primary" style="font-size: 12px;">Modifier</a>
                    
                    <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="font-size: 12px; margin-left: 5px;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($resources->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center; color: gray;">Aucun matériel enregistré.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
