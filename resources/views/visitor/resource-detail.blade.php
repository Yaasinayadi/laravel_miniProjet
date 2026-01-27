
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $resource->name }} - Détails</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('visitor.index') }}" class="brand"><i class="ri-server-fill"></i> DC Manager</a>
        <ul>
            <a href="{{ route('visitor.resources') }}"><i class="ri-arrow-left-line"></i> Retour aux ressources</a>
            <a href="{{ route('visitor.request-account') }}"><i class="ri-user-add-line"></i> Demander un compte</a>
            <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Se connecter</a>
        </ul>
    </nav>

    <div class="container" style="margin-top: 30px;">
        <div class="card" style="background: #fef3c7; color: #92400e; margin-bottom: 20px;">
            <i class="ri-lock-line"></i> <strong>Réservation impossible :</strong> 
            Vous devez disposer d'un compte pour réserver cette ressource. 
            <a href="{{ route('visitor.request-account') }}" style="color: #b45309; text-decoration: underline;">Demander un accès</a>
        </div>

        <div class="card">
            <h1><i class="ri-hard-drive-2-line"></i> {{ $resource->name }}</h1>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 20px;">
                <div>
                    <strong>Type :</strong>
                    <p>{{ $resource->type }}</p>
                </div>
                
                <div>
                    <strong>État :</strong>
                    <p style="color: {{ $resource->state === 'active' ? 'green' : 'orange' }};">
                        {{ $resource->state === 'active' ? 'Disponible' : 'En maintenance' }}
                    </p>
                </div>

                @if($resource->cpu)
                    <div>
                        <strong><i class="ri-cpu-line"></i> CPU :</strong>
                        <p>{{ $resource->cpu }}</p>
                    </div>
                @endif

                @if($resource->ram)
                    <div>
                        <strong><i class="ri-server-line"></i> RAM :</strong>
                        <p>{{ $resource->ram }} GB</p>
                    </div>
                @endif

                @if($resource->storage)
                    <div>
                        <strong><i class="ri-database-2-line"></i> Stockage :</strong>
                        <p>{{ $resource->storage }} GB</p>
                    </div>
                @endif

                @if($resource->bandwidth)
                    <div>
                        <strong><i class="ri-speed-line"></i> Bande passante :</strong>
                        <p>{{ $resource->bandwidth }} Mbps</p>
                    </div>
                @endif

                @if($resource->location)
                    <div>
                        <strong><i class="ri-map-pin-line"></i> Emplacement :</strong>
                        <p>{{ $resource->location }}</p>
                    </div>
                @endif

                @if($resource->os)
                    <div>
                        <strong><i class="ri-windows-line"></i> Système d'exploitation :</strong>
                        <p>{{ $resource->os }}</p>
                    </div>
                @endif
            </div>

            @if($resource->description)
                <div style="margin-top: 20px;">
                    <strong>Description :</strong>
                    <p style="line-height: 1.6;">{{ $resource->description }}</p>
                </div>
            @endif

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
                <p style="text-align: center; color: #666;">
                    <i class="ri-information-line"></i> 
                    Pour réserver cette ressource, vous devez créer un compte.
                </p>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('visitor.request-account') }}" class="btn btn-primary">
                        <i class="ri-user-add-line"></i> Demander un compte
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>