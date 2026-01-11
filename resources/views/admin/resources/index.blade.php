@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Gestion du Matériel</h1>
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
                    <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px;">
                        {{ $resource->state }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-primary" style="font-size: 12px;">Modifier</button>
                    <a href="{{route('reservations.create', $resource->id)}}" class="btn btn-success" style="font-size: 12px;margin-left: 5px;">Reserver</a>
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
