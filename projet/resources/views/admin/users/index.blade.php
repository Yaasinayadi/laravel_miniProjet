@extends('layouts.app')

@section('content')
<h1 class="rass">Gestion des Utilisateurs</h1>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Service</th>
                <th>Rôle actuel</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->service ?? '-'}}</td>
                    <td>
                        <span class="status-badge" style="color: {{ $user->role == 'invite' ? 'grey' : 'rgba(36, 103, 142, 1)' }};">
                        {{ $user->role }}
                        </span>
                    </td>
                    <td class="space">
                        {{-- Si c'est inviter bouton pour le valider --}}
                        @if($user->email !== 'admin@gmail.com' && $user->email !== 'respo@gmail.com')
                        {{-- Formulaire de changement de rôle (Remplacer le bouton Valider simple) --}}
                        <form action="{{route('users.promote', $user->id)}}" method="POST" style="display:inline-flex; gap: 5px; align-items: center;">
                            @csrf
                            <select name="role" style="color: white;padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                                <option value="interne" {{ $user->role == 'interne' ? 'selected' : '' }}>Interne</option>
                                <option value="responsable" {{ $user->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button class="btn btn-success" style="padding: 5px 10px; font-size:12px;">valider</button>
                        </form>
                        @endif
                           {{-- si ce n'est pas (admin), bouton banner --}}

                        @if(Auth::id() !== $user->id)
                            <form action="{{ route('users.ban', $user->id)}}" method="POST" style="display: inline">
                                @csrf
                                <button class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }}" style="padding: 5px 10px; font-size:12px;">
                                {{ $user->is_active ? 'Bannir' : 'Réactiver' }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
