<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Center Manager</title>
    <!-- IMPORTANT : On lie notre CSS manuel -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" style="font-weight:bold; font-size:1.2rem;">DC Manager</a>
        <div>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <!-- Bouton de déconnexion -->
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}">Connexion</a>
                <a href="{{ route('register') }}">Inscription</a>
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
