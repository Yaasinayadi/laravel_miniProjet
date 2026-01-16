@extends('layouts.app')

@section('content')
<style>
    .card{
        padding: 40px 50px;
    }
    #retourne{
        margin:0px 0px 30px 0px; 
        color:white;
        border-radius: 15px;
        padding: 5px 15px;
        text-decoration: none;
        display: inline-block;
        background-color: rgba(255, 255, 255, 0.4);
    }
    #retourne:hover{
        background-color: rgba(0, 0, 0, 0.1);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.4);
    }
    .card2{
        padding: 1px 30px 30px 30px;
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.4);
    }
</style>
<div class="card">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary" id="retourne">
        ← Retourner
    </a>
    <div class="card card2">
    <h1>{{ $resource->name }}</h1>
    <p style="color:{{ $resource->state == 'active' ? '#10b981' : '#ef4444' }}">Catégorie : {{ $resource->category->name }}</p>

    <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
        <h3>Description</h3>
        <p>{{ $resource->description ?? 'Aucune description disponible.' }}</p>

        <h3>Spécifications Techniques</h3>
        <p>{{ $resource->specs ?? 'Non spécifié.' }}</p>

        <h3 style="display: inline;">État actuel : </h3>
        <span style="padding: 5px 10px; border-radius: 5px; color: {{ $resource->state === 'active' ? '#10b981' : '#ef4444' }}; display: inline;margin-left: 10px;">
            <h3 style="display: inline;"><u>{{ $resource->state === 'active' ? 'Disponible' : 'Hors Service' }}</u></h3>
            
        </span>
    </div>
    </div>

    <div style="margin-top: 30px;">
        <a href="{{ route('reservations.create', $resource->id) }}" class="btn btn-success">Réserver ce matériel</a>
    </div>
</div>
@endsection