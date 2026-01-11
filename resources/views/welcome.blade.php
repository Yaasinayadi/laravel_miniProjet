<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Center Manager</title>
        <!-- On connecte ton CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        <nav class="navbar">
            <a href="#" class="brand">DC Manager</a>
            <ul>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/dashboard') }}">Mon Tableau de Bord</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Inscription</a></li>
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
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Accéder à mon espace</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                @endauth
            </div>
        </div>
    </body>
</html>
