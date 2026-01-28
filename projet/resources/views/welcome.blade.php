<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Center Manager</title>
        <!-- CDN RemixIcon -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
        <!-- On connecte ton CSS -->
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
                        <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><i class="ri-user-add-line"></i> Inscription</a>
                        @endif
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
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary"><i class="ri-arrow-right-line"></i> Accéder à mon espace</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary"><i class="ri-login-circle-line"></i> Se connecter</a>
                @endauth
            </div>
        </div>
    </body>
</html>
