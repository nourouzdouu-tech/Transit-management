@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f6ff;
        font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 400px;
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

<div class="login-card">
    <img src="{{ asset('images/logo.png') }}" alt="IGT Logo" class="logo">
    <h4 class="igt-title">IPSEN Group Transit</h4>
    <p class="text-center text-muted">
        Commissionnaire en transport international & transit - Casablanca
    </p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role">Type d'utilisateur</label>
            <select id="role" name="role" class="form-control" required>
                <option value="">Sélectionner</option>
                <option value="client">Client</option>
                <option value="agent">Agent</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
</div>
@endsection
