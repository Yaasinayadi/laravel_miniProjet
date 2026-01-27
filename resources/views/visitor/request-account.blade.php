<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demande de Compte - DC Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('visitor.index') }}" class="brand"><i class="ri-server-fill"></i> DC Manager</a>
        <ul>
            <a href="{{ route('visitor.index') }}"><i class="ri-home-line"></i> Accueil Visiteur</a>
            <a href="{{ route('visitor.resources') }}"><i class="ri-hard-drive-2-line"></i> Ressources</a>
            <a href="{{ route('login') }}"><i class="ri-login-box-line"></i> Se connecter</a>
        </ul>
    </nav>

    <div class="container" style="margin-top: 30px; max-width: 700px;">
        <div class="card">
            <h1><i class="ri-user-add-line"></i> Demande de Compte</h1>
            <p>Remplissez ce formulaire pour demander l'accès au Data Center. Un administrateur examinera votre demande.</p>
        </div>

        @if($errors->any())
            <div class="card" style="background:#fee; color:#c00; margin-top:15px;">
                <strong>Erreurs :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card" style="margin-top: 20px;">
            <form method="POST" action="{{ route('visitor.request-account.store') }}">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label for="name">Nom complet <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="service">Service / Département <span style="color: red;">*</span></label>
                    <input type="text" id="service" name="service" value="{{ old('service') }}" placeholder="Ex: Informatique, Mathématiques..." required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="requested_role">Rôle demandé <span style="color: red;">*</span></label>
                    <select id="requested_role" name="requested_role" required>
                        <option value="">-- Sélectionnez un rôle --</option>
                        <option value="user" {{ old('requested_role') === 'user' ? 'selected' : '' }}>
                            Utilisateur (Ingénieur / Enseignant / Doctorant)
                        </option>
                        <option value="responsable" {{ old('requested_role') === 'responsable' ? 'selected' : '' }}>
                            Responsable Technique
                        </option>
                    </select>
                    <small style="color: #666;">
                        <strong>Utilisateur :</strong> Peut consulter et réserver des ressources.<br>
                        <strong>Responsable :</strong> Peut aussi gérer et valider les réservations.
                    </small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="justification">Justification de la demande <span style="color: red;">*</span></label>
                    <textarea id="justification" name="justification" rows="6" required placeholder="Décrivez votre projet, vos besoins en ressources et pourquoi vous avez besoin d'un accès au Data Center (minimum 50 caractères)">{{ old('justification') }}</textarea>
                    <small style="color: #666;">Minimum 50 caractères</small>
                </div>

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-send-plane-line"></i> Envoyer la demande
                    </button>
                    <a href="{{ route('visitor.index') }}" class="btn" style="background: #6b7280; margin-left: 10px;">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <div class="card" style="margin-top: 20px; background: #eff6ff; color: #1e40af;">
            <p><i class="ri-information-line"></i> <strong>Remarque :</strong></p>
            <ul style="line-height: 1.8;">
                <li>Votre demande sera examinée par un administrateur dans les 24-48 heures.</li>
                <li>Vous recevrez une notification par email une fois votre demande traitée.</li>
                <li>Si votre demande est approuvée, vous recevrez vos identifiants par email.</li>
            </ul>
        </div>
    </div>
</body>
</html>