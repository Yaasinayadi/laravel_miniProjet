
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mode Visiteur - DC Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="brand"><i class="ri-server-fill"></i> DC Manager</a>
        <ul>
            <a href="{{ route('visitor.resources') }}"><i class="ri-hard-drive-2-line"></i> Ressources</a>
            <a href="{{ route('visitor.request-account') }}"><i class="ri-user-add-line"></i> Demander un compte</a>
            <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Se connecter</a>
        </ul>
    </nav>

    <div class="container" style="margin-top: 50px;">
        @if(session('success'))
            <div class="card" style="background:#d1fae5; color:#065f46; margin-bottom:20px;">
                <i class="ri-check-line"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <h1><i class="ri-eye-line"></i> Bienvenue en mode Visiteur</h1>
            <p>Vous pouvez consulter les ressources disponibles dans notre Data Center sans avoir de compte.</p>
            <br>
            
            <h2>Que pouvez-vous faire ?</h2>
            <ul style="text-align: left; line-height: 2;">
                <li><i class="ri-check-line" style="color: green;"></i> Consulter la liste des ressources disponibles</li>
                <li><i class="ri-check-line" style="color: green;"></i> Voir les détails techniques de chaque ressource</li>
                <li><i class="ri-check-line" style="color: green;"></i> Comprendre les services offerts</li>
                <li><i class="ri-close-line" style="color: red;"></i> Réserver des ressources (nécessite un compte)</li>
            </ul>
            <br>

            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('visitor.resources') }}" class="btn btn-primary">
                    <i class="ri-hard-drive-2-line"></i> Explorer les ressources
                </a>
                <a href="{{ route('visitor.request-account') }}" class="btn" style="background: #10b981;">
                    <i class="ri-user-add-line"></i> Demander un compte
                </a>
            </div>
        </div>

        <div class="card" style="margin-top: 20px;">
            <h2><i class="ri-information-line"></i> À propos de nos services</h2>
            <p>
                Notre Data Center offre une infrastructure moderne et sécurisée pour héberger vos projets.
                Nous proposons des serveurs physiques, des machines virtuelles, du stockage et des équipements réseau.
            </p>
            <p>
                <strong>Pour obtenir un accès complet :</strong> Cliquez sur "Demander un compte" et remplissez le formulaire.
                Un administrateur examinera votre demande et vous contactera par email.
            </p>
        </div>
    </div>
</body>
</html>