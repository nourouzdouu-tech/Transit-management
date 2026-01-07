@extends('layouts.app')

@section('title', 'Tableau de bord - Agent')

@section('content')
<!-- Bootstrap CSS (si non inclus dans layouts.app) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-blue: #003d80;
        --secondary-blue: #0052a6;
        --light-blue: #e6f2ff;
        --accent-blue: #0066cc;
        --dark-blue: #002b5c;
        --gradient-primary: linear-gradient(135deg, #003d80 0%, #0052a6 100%);
        --gradient-secondary: linear-gradient(135deg, #0066cc 0%, #003d80 100%);
        --gradient-light: linear-gradient(135deg, #e6f2ff 0%, #cce6ff 100%);
        --shadow-primary: 0 10px 40px rgba(0, 61, 128, 0.15);
        --shadow-hover: 0 15px 50px rgba(0, 61, 128, 0.25);
        --border-radius: 20px;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        --sidebar-width: 280px;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f8fbff 0%, #e6f2ff 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: var(--sidebar-width);
        background: var(--gradient-primary);
        color: white;
        position: fixed;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 1000;
        overflow-y: auto;
        box-shadow: var(--shadow-primary);
        transition: var(--transition);
    }

    .sidebar-header {
        padding: 2rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
    }

    .sidebar-header h3 {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 0.5rem;
    }

    .sidebar-header p {
        opacity: 0.8;
        font-size: 0.9rem;
        margin: 0;
    }

    .sidebar-nav {
        padding: 1rem 0;
    }

    .nav-item {
        margin: 0.5rem 1rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 15px;
        transition: var(--transition);
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: var(--transition);
    }

    .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .nav-link:hover::before {
        left: 0;
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .nav-link i {
        margin-right: 1rem;
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .nav-badge {
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: auto;
        animation: pulse 2s infinite;
    }

    /* Main Content */
    .main-content {
        margin-left: var(--sidebar-width);
        flex: 1;
        min-height: 100vh;
        padding: 2rem;
        transition: var(--transition);
    }

    .content-section {
        display: none;
        animation: fadeInUp 0.6s ease-out;
    }

    .content-section.active {
        display: block;
    }

    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Welcome Header */
    .welcome-header {
        background: var(--gradient-primary);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-primary);
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }

    .welcome-header h2 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .welcome-header p {
        opacity: 0.9;
        font-size: 1.1rem;
        position: relative;
        z-index: 2;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--border-radius);
        padding: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-primary);
        transition: var(--transition);
        cursor: pointer;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: var(--transition);
        transform-origin: left;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-hover);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card .icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 8px 25px rgba(0, 61, 128, 0.3);
    }

    .stat-card.en-cours .icon {
        background: linear-gradient(135deg, #0066cc, #003d80);
    }

    .stat-card.retard .icon {
        background: linear-gradient(135deg, #ff6b35, #f7931e);
    }

    .stat-card.termine .icon {
        background: linear-gradient(135deg, #00b894, #00cec9);
    }

    .stat-card h3 {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-card p {
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0;
    }

    /* Cards principales */
    .main-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-primary);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: var(--transition);
    }

    .main-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .card-header-custom {
        background: var(--gradient-primary);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-custom h5 {
        font-weight: 600;
        font-size: 1.3rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        transition: var(--transition);
        backdrop-filter: blur(10px);
    }

    .btn-add:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .card-body-custom {
        padding: 2rem;
    }

    /* Search et filtres */
    .search-filter-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .search-input, .filter-select {
        border: 2px solid transparent;
        border-radius: 50px;
        padding: 0.8rem 1.5rem;
        background: var(--light-blue);
        transition: var(--transition);
        font-weight: 500;
    }

    .search-input:focus, .filter-select:focus {
        border-color: var(--accent-blue);
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        outline: none;
    }

    .search-input {
        flex: 1;
        min-width: 250px;
    }

    .filter-select {
        min-width: 200px;
    }

    /* Tables */
    .table-container {
        border-radius: 15px;
        overflow: hidden;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 61, 128, 0.08);
    }

    .table-custom {
        margin: 0;
        font-size: 0.95rem;
    }

    .table-custom thead th {
        background: var(--gradient-light);
        border: none;
        padding: 1.2rem 1rem;
        font-weight: 600;
        color: var(--primary-blue);
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        transition: var(--transition);
        border: none;
    }

    .table-custom tbody tr:hover {
        background: var(--light-blue);
        transform: scale(1.01);
    }

    .table-custom tbody td {
        padding: 1.2rem 1rem;
        border: none;
        border-bottom: 1px solid rgba(0, 61, 128, 0.08);
        vertical-align: middle;
    }

    /* Boutons d'action */
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 500;
        border: none;
        transition: var(--transition);
        margin: 0 0.2rem;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ffa726, #fb8c00);
        color: white;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #fb8c00, #f57c00);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 167, 38, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef5350, #e53935);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #e53935, #d32f2f);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 83, 80, 0.4);
    }

    /* Charts */
    .chart-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-primary);
        margin-bottom: 2rem;
        max-width: 100%;
    }

    .chart-container h3 {
        color: var(--primary-blue);
        font-weight: 700;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-wrapper {
        position: relative;
        height: 400px;
        width: 100%;
    }

    #dossiersChart {
        max-height: 400px !important;
    }

    /* Modals */
    .modal-content-custom {
        border: none;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-hover);
    }

    .modal-header-custom {
        background: var(--gradient-primary);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .modal-header-custom h5 {
        font-weight: 600;
        margin: 0;
    }

    .modal-body-custom {
        padding: 2rem;
    }

    .modal-footer-custom {
        padding: 1rem 2rem;
        background: #f8fbff;
        border: none;
    }

    .form-control-custom {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        transition: var(--transition);
        margin-bottom: 1rem;
    }

    .form-control-custom:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    }

    .btn-primary-custom {
        background: var(--gradient-primary);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-primary-custom:hover {
        background: var(--gradient-secondary);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 61, 128, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .search-filter-row {
            flex-direction: column;
        }
    }

    /* Toggle button pour mobile */
    .sidebar-toggle {
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1001;
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        box-shadow: var(--shadow-primary);
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }

    /* Animations */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
</style>

<div class="dashboard-wrapper">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
             <h3>IPSEN Group Transit</h3>
            <p>Agent {{ Auth::user()->name }}</p>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="#" class="nav-link active" data-section="overview">
                    <i class="fas fa-home"></i>
                    Vue d'ensemble
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="clients">
                    <i class="fas fa-users"></i>
                    Gestion des Clients
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="colis">
                    <i class="fas fa-box"></i>
                    Gestion des Colis
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="charts">
                    <i class="fas fa-chart-bar"></i>
                    Colis traités par mois
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link" data-section="messages">
                    <i class="fas fa-envelope"></i>
                    Messages
                    @if($nouveauxMessages > 0)
                        <span class="nav-badge">{{ $nouveauxMessages }}</span>
                    @endif
                </a>
            </div>
        </nav>
    </div>

    <!-- Toggle Button pour mobile -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Vue d'ensemble -->
        <div class="content-section active" id="overview-section">
            <div class="welcome-header">
                <h2><i class="fas fa-tachometer-alt me-3"></i></h2>
                <p>Gérez efficacement vos clients et colis depuis votre tableau de bord</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card en-cours">
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>{{ $enCours ?? 0 }}</h3>
                    <p>Colis en cours</p>
                </div>
                <div class="stat-card retard">
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>{{ $retard ?? 0 }}</h3>
                    <p>Colis en retard</p>
                </div>
                <div class="stat-card termine">
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>{{ $termine ?? 0 }}</h3>
                    <p>Terminés aujourd'hui</p>
                </div>
            </div>
        </div>

        <!-- Gestion Clients -->
        <div class="content-section" id="clients-section">
            <div class="main-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-users"></i>Gestion des Clients</h5>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addClientModal">
                        <i class="fas fa-plus me-2"></i>Ajouter un client
                    </button>
                </div>
                <div class="card-body-custom">
                    <div class="search-filter-row">
                        <input type="text" id="searchClient" class="search-input" placeholder="🔍 Rechercher un client...">
                    </div>
                    <div class="table-container">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user me-2"></i>Nom</th>
                                    <th><i class="fas fa-envelope me-2"></i>Email</th>
                                    <th><i class="fas fa-phone me-2"></i>Téléphone</th>
                                    <th><i class="fas fa-map-marker-alt me-2"></i>Ville</th>
                                    <th><i class="fas fa-folder me-2"></i>Colis actifs</th>
                                    <th><i class="fas fa-cogs me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="clientTable">
                                @foreach($clients as $client)
                                <tr>
                                    <td><strong>{{ $client->name }}</strong></td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->ville ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">{{ $client->dossiers_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editClientModal{{ $client->id }}">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <form action="{{ route('agent.clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-delete" onclick="return confirm('Supprimer ce client ?')">
                                                <i class="fas fa-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <a href="{{ route('agent.clients.pdf') }}" class="btn btn-success mb-2">
                            📥 Liste Clients PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestion Colis -->
        <div class="content-section" id="colis-section">
            <div class="main-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-box"></i>Gestion des Colis</h5>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addDossierModal">
                        <i class="fas fa-plus me-2"></i>Créer un colis
                    </button>
                </div>
                <div class="card-body-custom">
                    <div class="search-filter-row">
                        <select id="filterStatus" class="filter-select">
                            <option value="">🔍 Tous les statuts</option>
                            <option value="En cours">En cours</option>
                            <option value="En retard">En retard</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    </div>
                    <div class="table-container">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>Réf</th>
                                    <th><i class="fas fa-user me-2"></i>Client</th>
                                    <th><i class="fas fa-folder me-2"></i>Titre</th>
                                    <th><i class="fas fa-info-circle me-2"></i>Statut</th>
                                    <th>Date création</th>
                                    <th>Date d'échéance</th>
                                    <th><i class="fas fa-cogs me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="dossierTable">
                                @foreach($dossiers as $dossier)
                                <tr>
                                    <td><strong>#{{ $dossier->id }}</strong></td>
                                    <td>{{ $dossier->client->name ?? '-' }}</td>
                                    <td>{{ $dossier->description }}</td>
                                    <td>
                                        <span class="badge bg-info rounded-pill">{{ $dossier->status }}</span>
                                    </td>
                                    <td>{{ $dossier->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $dossier->date_echeance->format('d/m/Y') }}</td>
                                    <td>
                                        <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editDossierModal{{ $dossier->id }}">
                                            <i class="fas fa-edit"></i> 
                                        </button>
                                        <form action="{{ route('agent.dossiers.destroy', $dossier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce dossier ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-delete">
                                                <i class="fas fa-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <a href="{{ route('agent.dossiers.pdf') }}" class="btn btn-success mb-2">📥 Liste Colis PDF</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="content-section" id="charts-section">
            <div class="chart-container">
                <h3><i class="fas fa-chart-bar me-2"></i>Colis traités par mois</h3>
                <div class="chart-wrapper">
                    <canvas id="dossiersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="content-section" id="messages-section">
            <div class="main-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-envelope"></i>Messages</h5>
                  <div class="dropdown">
                         <!-- <button class="btn btn-add dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-comments me-2"></i>
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('messages.index', 1) }}"><i class="fas fa-list me-2"></i>Voir tous les messages</a></li>
                        </ul>  -->
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="d-flex align-items-center justify-content-center py-5">
                        <div class="text-center">
                            <i class="fas fa-envelope fa-4x text-primary mb-3"></i>
                            <h4 class="text-primary">Messages</h4>
                            <p class="text-muted">Restez connecté avec vos clients</p>
                            @if($nouveauxMessages > 0)
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Vous avez {{ $nouveauxMessages }} nouveau(x) message(s)
                                </div>
                            @endif
                            <a href="{{ route('messages.index', 1) }}" class="btn btn-primary-custom">
                                <i class="fas fa-envelope me-2"></i>Accéder aux messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Client -->
<div class="modal fade" id="addClientModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('agent.clients.store') }}" method="POST" class="modal-content modal-content-custom">
            @csrf
            <div class="modal-header-custom">
             <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
             <h5><i class="fas fa-user-plus me-2"></i>Ajouter un Client</h5>
            </div>
            <div class="modal-body-custom">
                <input type="text" name="name" class="form-control form-control-custom" placeholder="👤 Nom complet" required>
                <input type="email" name="email" class="form-control form-control-custom" placeholder="📧 Email" required>
                <input type="text" name="phone" class="form-control form-control-custom" placeholder="📱 Téléphone" required>
                <input type="text" name="ville" class="form-control form-control-custom" placeholder="🏙️ Ville">
                <input type="password" name="password" class="form-control form-control-custom" placeholder="🔒 Mot de passe" required>
                <input type="password" name="password_confirmation" class="form-control form-control-custom" placeholder="🔒 Confirmer mot de passe" required>
            </div>
            <div class="modal-footer-custom">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Modifier Client -->
@foreach($clients as $client)
<div class="modal fade" id="editClientModal{{ $client->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('agent.clients.update', $client->id) }}" method="POST" class="modal-content modal-content-custom">
            @csrf
            @method('PUT')
            <div class="modal-header-custom">
             <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            <h5><i class="fas fa-user-edit me-2"></i>Modifier Client</h5>
            </div>
            <div class="modal-body-custom">
                <input type="text" name="name" class="form-control form-control-custom" value="{{ $client->name }}" required>
                <input type="email" name="email" class="form-control form-control-custom" value="{{ $client->email }}" required>
                <input type="text" name="phone" class="form-control form-control-custom" value="{{ $client->phone }}" required>
                <input type="text" name="ville" class="form-control form-control-custom" value="{{ $client->ville }}" placeholder="🏙️ Ville">
                <input type="password" name="password" class="form-control form-control-custom" placeholder="🔒 Nouveau mot de passe (optionnel)">
                <input type="password" name="password_confirmation" class="form-control form-control-custom" placeholder="🔒 Confirmer le mot de passe">
            </div>
            <div class="modal-footer-custom">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-save me-2"></i>Modifier
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Ajouter Dossier -->
<div class="modal fade" id="addDossierModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('agent.dossiers.store') }}" class="modal-content modal-content-custom">
            @csrf
            <div class="modal-header-custom">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                <h5><i class="fas fa-folder-plus me-2"></i>Créer un colis</h5>
            </div>
            <div class="modal-body-custom">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">📋 Numéro du colis</label>
                        <input type="text" name="numero" class="form-control form-control-custom" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">👤 Client</label>
                        <select name="client_id" class="form-control form-control-custom" required>
                            <option value="">Sélectionner un client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->ville }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">👨‍💼 Agent</label>
                        <select name="agent_id" class="form-control form-control-custom" required>
                            <option value="">Sélectionner un agent</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">📊 Statut</label>
                        <select name="status" class="form-control form-control-custom" required>
                            <option value="En attente">En attente</option>
                            <option value="En cours">En cours</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    </div>
                </div>

                <label class="form-label">📝 Description</label>
                <textarea name="description" class="form-control form-control-custom" rows="3" required></textarea>

                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">📅 Date de création</label>
                        <input type="date" name="date_creation" class="form-control form-control-custom" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">⏰ Date d'échéance</label>
                        <input type="date" name="date_echeance" class="form-control form-control-custom" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🚨 Priorité</label>
                        <select name="priorite" class="form-control form-control-custom" required>
                            <option value="Basse">Basse</option>
                            <option value="Normale">Normale</option>
                            <option value="Haute">Haute</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-2"></i>Ajouter un colis
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal modifier Dossier -->
@foreach($dossiers as $dossier)
<div class="modal fade" id="editDossierModal{{ $dossier->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('agent.dossiers.update', $dossier->id) }}" method="POST" class="modal-content modal-content-custom">
            @csrf
            @method('PUT')
            <div class="modal-header-custom">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            <h5><i class="fas fa-folder-edit me-2"></i>Modifier Colis {{ $dossier->id }}</h5>
            </div>
            <div class="modal-body-custom">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">📋 Numéro du colis</label>
                        <input type="text" name="numero" class="form-control form-control-custom" value="{{ $dossier->numero }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">👤 Client</label>
                        <select name="client_id" class="form-control form-control-custom" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $client->id == $dossier->client_id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">📊 Statut</label>
                        <select name="status" class="form-control form-control-custom" required>
                            <option value="En attente" {{ $dossier->status == 'En attente' ? 'selected' : '' }}>En attente</option>
                            <option value="En cours" {{ $dossier->status == 'En cours' ? 'selected' : '' }}>En cours</option>
                            <option value="En retard" {{ $dossier->status == 'En retard' ? 'selected' : '' }}>En retard</option>
                            <option value="Terminé" {{ $dossier->status == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="Bloqué" {{ $dossier->status == 'Bloqué' ? 'selected' : '' }}>Bloqué</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">🚨 Priorité</label>
                        <select name="priorite" class="form-control form-control-custom" required>
                            <option value="Basse" {{ $dossier->priorite == 'Basse' ? 'selected' : '' }}>Basse</option>
                            <option value="Moyenne" {{ $dossier->priorite == 'Moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="Haute" {{ $dossier->priorite == 'Haute' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>
                </div>

                <label class="form-label">📝 Description</label>
                <textarea name="description" class="form-control form-control-custom" rows="3">{{ $dossier->description }}</textarea>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">📅 Date de création</label>
                        <input type="date" name="date_creation" class="form-control form-control-custom" value="{{ $dossier->date_creation }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">⏰ Date d'échéance</label>
                        <input type="date" name="date_echeance" class="form-control form-control-custom" value="{{ $dossier->date_echeance }}" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-save me-2"></i>Modifier
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    // Navigation entre les sections
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.content-section');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        // Navigation
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Retirer la classe active de tous les liens
                navLinks.forEach(l => l.classList.remove('active'));
                // Ajouter la classe active au lien cliqué
                this.classList.add('active');
                
                // Masquer toutes les sections
                sections.forEach(s => s.classList.remove('active'));
                
                // Afficher la section correspondante
                const targetSection = this.getAttribute('data-section');
                const targetElement = document.getElementById(targetSection + '-section');
                if (targetElement) {
                    targetElement.classList.add('active');
                }

                // Fermer le sidebar sur mobile après sélection
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('open');
                }
            });
        });

        // Toggle sidebar sur mobile
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
        }

        // Fermer le sidebar en cliquant à l'extérieur sur mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Animation des compteurs
        const counters = document.querySelectorAll('.stat-card h3');
        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current);
                }
            }, 50);
        });
    });

    // Recherche Clients
    document.getElementById('searchClient').addEventListener('keyup', function(){
        let value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#clientTable tr');
        
        rows.forEach(row => {
            const isVisible = row.innerText.toLowerCase().includes(value);
            row.style.transition = 'all 0.3s ease';
            
            if (isVisible) {
                row.style.display = '';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            } else {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    if (row.style.opacity === '0') {
                        row.style.display = 'none';
                    }
                }, 300);
            }
        });
    });

    // Filtre Dossiers
    document.getElementById('filterStatus').addEventListener('change', function() {
        let value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dossierTable tr');

        rows.forEach(row => {
            const statusCell = row.cells[3];
            if (statusCell) {
                const cellText = statusCell.innerText.toLowerCase();
                const isVisible = cellText.includes(value) || value === '';

                if (isVisible) {
                    row.style.display = '';
                    setTimeout(() => {
                        row.style.opacity = '1';
                        row.style.transform = 'scale(1)';
                        row.style.transition = 'all 0.3s ease';
                    }, 10);
                } else {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        row.style.display = 'none';
                    }, 300);
                }
            }
        });
    });

    // Effet de particules sur les cartes stats
    function createParticleEffect(card) {
        for (let i = 0; i < 8; i++) {
            const particle = document.createElement('div');
            particle.style.position = 'absolute';
            particle.style.width = Math.random() * 3 + 1 + 'px';
            particle.style.height = particle.style.width;
            particle.style.backgroundColor = 'rgba(255, 255, 255, 0.4)';
            particle.style.borderRadius = '50%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animation = `floatParticle ${Math.random() * 2 + 1}s ease-in-out infinite`;
            particle.style.animationDelay = Math.random() * 1 + 's';
            card.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 3000);
        }
    }

    // Effet hover sur les cartes stats
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            createParticleEffect(this);
        });
    });

    // Animation des particules
    const style = document.createElement('style');
    style.textContent = `
        @keyframes floatParticle {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg); 
                opacity: 0.7;
            }
            25% { 
                transform: translateY(-15px) translateX(8px) rotate(90deg); 
                opacity: 1;
            }
            50% { 
                transform: translateY(-8px) translateX(-4px) rotate(180deg); 
                opacity: 0.4;
            }
            75% { 
                transform: translateY(-12px) translateX(12px) rotate(270deg); 
                opacity: 0.8;
            }
        }
    `;
    document.head.appendChild(style);

    // Notification toast
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // CSS pour les toasts
    const toastStyle = document.createElement('style');
    toastStyle.textContent = `
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .toast-notification.show {
            transform: translateX(0);
        }
        
        .toast-success {
            background: linear-gradient(135deg, #00b894, #00cec9);
        }
        
        .toast-error {
            background: linear-gradient(135deg, #ef5350, #e53935);
        }
    `;
    document.head.appendChild(toastStyle);
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js - uniquement chargé quand la section charts est visible
    let chartLoaded = false;
    
    function loadChart() {
        if (chartLoaded) return;
        
        const ctx = document.getElementById('dossiersChart');
        if (!ctx) return;
        
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($labels ?? []),
                datasets: [
                    {
                        label: 'Terminé',
                        data: @json($dataTermine ?? []),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        borderRadius: 8
                    },
                    {
                        label: 'En cours',
                        data: @json($dataEnCours ?? []),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        borderRadius: 8
                    },
                    {
                        label: 'En retard',
                        data: @json($dataRetard ?? []),
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        borderRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Évolution mensuelle des colis',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        color: '#003d80'
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        grid: {
                            color: 'rgba(0, 61, 128, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 61, 128, 0.1)'
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });
        
        chartLoaded = true;
    }

    // Observer pour charger le chart quand la section est visible
    const chartObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.target.id === 'charts-section') {
                loadChart();
            }
        });
    });

    // Observer la section charts
    const chartsSection = document.getElementById('charts-section');
    if (chartsSection) {
        chartObserver.observe(chartsSection);
    }

    // Charger le chart si la section est déjà visible
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const chartsSection = document.getElementById('charts-section');
            if (chartsSection && chartsSection.classList.contains('active')) {
                loadChart();
            }
        }, 100);
    });
</script>

@endsection