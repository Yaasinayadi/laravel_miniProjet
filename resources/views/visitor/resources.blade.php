
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ressources - Mode Visiteur</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('visitor.index') }}" class="brand"><i class="ri-server-fill"></i> DC Manager</a>
        <ul>
            <a href="{{ route('visitor.index') }}"><i class="ri-home-line"></i> Accueil Visiteur</a>
            <a href="{{ route('visitor.request-account') }}"><i class="ri-user-add-line"></i> Demander un compte</a>
            <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Se connecter</a>
        </ul>
    </nav>

    <div class="container" style="margin-top: 30px;">
        <div class="card" style="background: #fef3c7; color: #92400e; margin-bottom: 20px;">
            <i class="ri-eye-line"></i> <strong>Mode Lecture Seule :</strong> 
            Pour effectuer des réservations, veuillez 
            <a href="{{ route('visitor.request-account') }}" style="color: #b45309; text-decoration: underline;">demander un compte</a>.
        </div>

        <h1><i class="ri-hard-drive-2-line"></i> Ressources Disponibles</h1>

        <!-- Filtres -->
        <div class="card">
            <form method="GET" action="{{ route('visitor.resources') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
                <div style="flex: 1; min-width: 200px;">
                    <label>Rechercher :</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom de la ressource...">
                </div>
                
                <div style="flex: 1; min-width: 200px;">
                    <label>Catégorie :</label>
                    <select name="category_id">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="ri-search-line"></i> Filtrer
                </button>
            </form>
        </div>

        <!-- Liste des ressources -->
        @if($resources->isEmpty())
            <div class="card">
                <p style="text-align: center; color: #666;">
                    <i class="ri-inbox-line" style="font-size: 3rem;"></i><br>
                    Aucune ressource disponible pour le moment.
                </p>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($resources as $resource)
                    <div class="card">
                        <h3>{{ $resource->name }}</h3>
                        <p><strong>Type :</strong> {{ $resource->type }}</p>
                        <p><strong>État :</strong> 
                            <span style="color: {{ $resource->state === 'active' ? 'green' : 'orange' }};">
                                {{ $resource->state === 'active' ? 'Disponible' : 'En maintenance' }}
                            </span>
                        </p>
                        @if($resource->cpu)
                            <p><i class="ri-cpu-line"></i> CPU : {{ $resource->cpu }}</p>
                        @endif
                        @if($resource->ram)
                            <p><i class="ri-server-line"></i> RAM : {{ $resource->ram }} GB</p>
                        @endif
                        
                        <a href="{{ route('visitor.resource.show', $resource->id) }}" class="btn" style="margin-top: 10px; background: #3b82f6;">
                            <i class="ri-eye-line"></i> Voir les détails
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>