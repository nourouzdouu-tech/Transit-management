@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<style>
    /* Arrière-plan avec dégradé animé */
    .login-page {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(90deg, #0f172a, #1e3a8a, #2563eb, #14b8a6);
        background-size: 300% 300%;
        animation: gradientBG 10s ease infinite;
        padding: 20px;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Conteneur global */
    .login-container {
        display: flex;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
        max-width: 950px;
        width: 100%;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Section image */
    .login-image {
        flex: 1;
        background-size: cover;
        background-position: center;
        min-height: 400px;
    }

    /* Carte de connexion */
    .login-card {
        flex: 1;
        padding: 2rem;
        color: white;
    }

    .login-card h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .login-card p {
        font-size: 0.9rem;
        color: #d1d5db;
        margin-bottom: 2rem;
    }

    /* Champs */
    .form-control {
        background: rgba(255, 255, 255, 0.12);
        border: none;
        border-radius: 10px;
        padding: 0.9rem;
        margin-bottom: 1rem;
        color: white;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 2px #93c5fd;
    }

    /* Bouton */
    .btn-submit {
        background: linear-gradient(90deg, #2563eb, #14b8a6);
        border: none;
        padding: 0.9rem;
        border-radius: 10px;
        width: 100%;
        font-weight: 600;
        color: white;
        transition: transform 0.2s ease, background 0.3s;
    }

    .btn-submit:hover {
        transform: scale(1.02);
        background: linear-gradient(90deg, #1e40af, #0d9488);
    }

    /* Lien inscription */
    .register-link {
        color: #a5b4fc;
        text-decoration: none;
        display: inline-block;
        margin-top: 1.2rem;
    }

    .register-link:hover {
        text-decoration: underline;
    }

    /* Alertes */
    .alert {
        background: rgba(239, 68, 68, 0.2);
        border: none;
        color: #fee2e2;
        border-radius: 10px;
        padding: 0.8rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-container {
            flex-direction: column;
        }
        .login-image {
            height: 200px;
        }
    }
</style>

<div class="login-page">
    <div class="login-container">
        <!-- Image à gauche -->
        <div class="login-image" style="background-image: url('https://images.unsplash.com/photo-1600440186563-9889b9e4a9b2?auto=format&fit=crop&w=1200&q=80');">
        </div>

        <!-- Formulaire -->
        <div class="login-card">
            <h2>Bienvenue 👋</h2>
            <p>Connectez-vous pour accéder à votre tableau de bord</p>

            @if ($errors->any())
                <div class="alert mb-3">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" class="form-control" placeholder="Adresse email" value="{{ old('email') }}" required>
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt me-1"></i> Se connecter
                </button>
            </form>

            <a href="{{ route('register') }}" class="register-link">
                Pas encore de compte ? Inscrivez-vous
            </a>
        </div>
    </div>
</div>
@endsection
