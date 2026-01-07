@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f6ff;
        font-family: 'Segoe UI', sans-serif;
    }
    .register-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 450px;
        margin: auto;
        margin-top: 50px;
    }
    .logo {
        width: 100px;
        display: block;
        margin: auto;
        margin-bottom: 15px;
    }
    .btn-primary {
        background-color: #0056b3;
        border: none;
    }
    .btn-primary:hover {
        background-color: #003d80;
    }
    .igt-title {
        color: #0056b3;
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="register-card">
    <img src="{{ asset('images/logo.png') }}" alt="IGT Logo" class="logo">
    <h4 class="igt-title">IPSEN Group Transit</h4>
    <p class="text-center text-muted">Créer un compte pour accéder à votre espace</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <div class="mb-3">
            <label for="name">Nom complet</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone">Téléphone</label>
            <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

         <div class="mb-3">
            <label for="name">Ville</label>
            <input id="name" type="text" name="ville" class="form-control" value="{{ old('ville') }}" required >
        </div>

        <div class="mb-3">
            <label for="role">Rôle</label>
            <select name="role" id="role" class="form-control" required>
                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
    </form>

    <p class="text-center mt-3">
        Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
    </p>
</div>
@endsection
