@extends('layouts.app')

@section('content')

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="color: white; font-weight: bold; font-size: 1.5rem;">
            <i class="ri-alarm-warning-line" style="margin-right: 10px;"></i>
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'responsable')
                Gestion des Incidents
            @else
                Mes Incidents Signalés
            @endif
        </h2>
        @if(Auth::user()->role !== 'admin')
            <a href="{{ route('incidents.create') }}" class="btn btn-primary"
                style="padding: 10px 20px; border-radius: 20px; font-weight: bold; border:none;"> +
                Signaler un incident</a>
        @endif
    </div>

    @if(session('success'))
        <div style="background-color: #10b981; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="background-color: transparent; padding: 0; box-shadow: none;">
        @if($incidents->isEmpty())
            <div style="text-align: center; padding: 50px; background-color: #2D333B; border-radius: 8px; color: white;">
                <i class="ri-checkbox-circle-line" style="font-size: 3rem; color: #10b981; margin-bottom: 20px;"></i>
                <h3>Aucun incident à signaler</h3>
                <p style="color: grey;">Tout semble fonctionner correctement.</p>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($incidents as $incident)
                    <div
                        style="box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);background-color: #2D333B; padding: 25px; border-radius: 8px; border-left: 5px solid {{ $incident->priority === 'high' ? '#ef4444' : ($incident->priority === 'medium' ? '#f59e0b' : '#3b82f6') }}; display: flex; flex-wrap: wrap; gap: 20px; align-items: center; color: white;">

                        <div style="flex: 1;">
                            <h3 style="margin: 0 0 10px 0; font-size: 1.2rem; text-transform: uppercase;">{{ $incident->title }}
                            </h3>

                            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                <span
                                    style="background-color: {{ $incident->priority === 'high' ? '#ef4444' : ($incident->priority === 'medium' ? '#f59e0b' : '#3b82f6') }}; color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">
                                    {{ $incident->priority }}
                                </span>
                                <span
                                    style="background-color: {{ $incident->status === 'open' ? '#f59e0b' : '#10b981' }}; color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                                    {{ $incident->status === 'open' ? 'En attente' : 'Résolu' }}
                                </span>
                            </div>

                            <p style="color: #9ca3af; margin-bottom: 15px;">{{ $incident->description }}</p>

                            @if($incident->resource)
                                <p style="font-size: 0.9rem; margin: 0;"><i class="ri-macbook-line"></i> <strong>Ressource :</strong>
                                    {{ $incident->resource->name }}</p>
                            @endif
                            <p style="font-size: 0.8rem; color: #6b7280; margin-top: 5px;">
                                <i class="ri-calendar-line"></i> Signalé le {{ $incident->created_at->format('d/m/Y à H:i') }}
                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'responsable')
                                    par <strong>{{ $incident->user->name }}</strong>
                                @endif
                            </p>
                        </div>

                        <div>
                            @if((Auth::user()->role === 'admin' || Auth::user()->role === 'responsable') && $incident->status === 'open')
                                <form action="{{ route('incidents.resolve', $incident->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #10b981; border: none; padding: 10px 20px; border-radius: 6px;">
                                        <i class="ri-check-double-line"></i> Marquer comme résolu
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                    
                @endforeach
            </div>
        @endif
    </div>

@endsection