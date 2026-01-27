<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Center Manager</title>
    <!-- RemixIcon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- IMPORTANT : On lie notre CSS manuel -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" style="font-weight:bold; font-size:1.2rem;"><i class="ri-server-fill"></i> DC Manager</a>
        <div>
            @auth
                <a href="{{ route('dashboard') }}"><i class="ri-dashboard-3-line"></i> Dashboard</a>

                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'responsable')
                    <a href="{{ route('resources.index') }}"><i class="ri-hard-drive-2-line"></i> Gestion Matériel</a>
                @endif

                {{-- Menu reserve a l'admin for gestion users --}}

                @if(Auth::user()->role === 'admin')
                    <a href="{{route('admin.users.index')}}"><i class="ri-group-line"></i> Gestion Utilisateurs</a>
                    <a href="{{route('admin.registration-requests')}}"><i class="ri-file-list-3-line"></i> Demandes d'inscription</a>
                @endif

               

                <!-- Bouton de déconnexion -->
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit"><i class="ri-logout-box-r-line"></i> Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Connexion</a>
                <a href="{{ route('register') }}"><i class="ri-user-add-line"></i> Inscription</a>
            @endauth
        </div>
    </nav>

    <main class="container">
        <!-- Zone pour afficher les messages de succès -->
        @if(session('success'))
            <div class="card" style="background:#d1fae5; color:#065f46; margin-bottom:10px;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

        <!-- Compatibilité avec les vues par défaut de Breeze -->
        {{ $slot ?? '' }}
    </main>
</body>
</html>
