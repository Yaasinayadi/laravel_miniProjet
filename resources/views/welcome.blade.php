<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Center Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="#" class="brand"><i class="ri-server-fill"></i> DC Manager</a>
        <ul>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"><i class="ri-dashboard-3-line"></i> Mon Tableau de Bord</a>
                @else
                    <a href="{{ route('visitor.index') }}"><i class="ri-eye-line"></i> Mode Visiteur</a>
                    <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Connexion</a>
                @endauth
            @endif
        </ul>
    </nav>

    <div class="container" style="text-align: center; margin-top: 100px;">
        <div class="card">
            <h1>Bienvenue dans le Data Center</h1>
            <p>Gérez vos serveurs, switchs et ressources informatiques simplement.</p>
            <br>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                    <i class="ri-arrow-right-line"></i> Accéder à mon espace
                </a>
            @else
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('visitor.index') }}" class="btn" style="background: #6366f1;">
                        <i class="ri-eye-line"></i> Continuer en visiteur
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="ri-login-circle-line"></i> Se connecter
                    </a>
                </div>
                <p style="margin-top: 20px; font-size: 0.9rem; color: #666;">
                    Pas encore de compte ? 
                    <a href="{{ route('visitor.request-account') }}" style="color: #3b82f6;">
                        Demander un accès
                    </a>
                </p>
            @endauth
        </div>
    </div>
</body>
</html>
