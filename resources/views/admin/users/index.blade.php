@extends('layouts.app')

@section('content')
<h1>Gestion des Utilisateurs</h1>

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
                        <span class="status-badge" style="color: {{ $user->role == 'invite' ? 'grey' : 'blue' }};">
                        {{ $user->role }}
                        </span>
                    </td>
                    <td>
                        {{-- Si c'est inviter bouton pour le valider --}}
                        @if($user->role === 'invite')
                            <form action="{{route('users.promote', $user->id)}}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success" style="padding: 5px 10px; font-size:12px;">Valider</button>
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
