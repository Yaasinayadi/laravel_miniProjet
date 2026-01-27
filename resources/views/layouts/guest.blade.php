<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Ton CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body style="background-color: #2D333B; display: flex; justify-content: center; align-items: center; height: 100vh;">

        <div class="card" style="width: 100%; max-width: 400px; ">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="color: white;">Connexion</h2>
            </div>

            <!-- Contenu du formulaire -->
            {{ $slot }}
        </div>

    </body>
</html>
