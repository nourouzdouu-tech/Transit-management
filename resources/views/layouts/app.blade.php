<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IGT Transit')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0f6ff;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background-color: #0056b3;
        }
        .navbar .nav-link, .navbar-brand {
            color: white !important;
            font-weight: 500;
        }
        .navbar .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">IPSEN Group Transit</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <span class="nav-link">Bonjour, {{ Auth::user()->name }}</span>
                        </li>
                       <!--  <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
                        </li>-->
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="color: white;">Déconnexion</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container py-4">
        @yield('content')
    </main>

</body>
</html>
