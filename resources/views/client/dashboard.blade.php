@extends('layouts.app')

@section('title', 'Dashboard Client')

@section('content')
<style>
    :root {
        --blue-primary: #003d80;
        --blue-secondary: #0052a6;
        --blue-light: #e6f2ff;
        --blue-accent: #0066cc;
        --blue-dark: #002b5c;
    }

    body { 
        background: linear-gradient(135deg, var(--blue-light) 0%, #ffffff 100%); 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        margin: 0;
        padding: 0;
    }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
    }

    /* Menu vertical */
    .sidebar {
        width: 280px;
        background: linear-gradient(180deg, var(--blue-primary) 0%, var(--blue-secondary) 100%);
        color: white;
        position: fixed;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 100;
        box-shadow: 4px 0 15px rgba(0,61,128,0.2);
        transition: transform 0.3s ease;
    }

    .sidebar-header {
        padding: 30px 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-header h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .sidebar-menu {
        padding: 20px 0;
    }

    .menu-item {
        display: block;
        padding: 15px 25px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        cursor: pointer;
    }

    .menu-item:hover, .menu-item.active {
        background: rgba(255,255,255,0.1);
        border-left-color: white;
        color: white;
        text-decoration: none;
    }

    .menu-item i {
        width: 20px;
        margin-right: 12px;
    }

    /* Contenu principal */
    .main-content {
        margin-left: 280px;
        flex: 1;
        padding: 30px;
        min-height: 100vh;
    }

    .content-section {
        display: none;
        animation: fadeInUp 0.6s ease-out;
    }

    .content-section.active {
        display: block;
    }

    @keyframes fadeInUp { 
        from {opacity:0; transform:translateY(30px);} 
        to {opacity:1; transform:translateY(0);} 
    }

    .page-header {
        background: white;
        border-radius: 20px;
        padding: 25px 30px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,61,128,0.1);
    }

    .page-header h1 {
        margin: 0;
        color: var(--blue-primary);
        font-weight: 700;
        font-size: 2rem;
    }

    .card { 
        border-radius:20px; 
        border:none; 
        box-shadow:0 10px 30px rgba(0,61,128,0.1); 
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1); 
        overflow:hidden; 
        position:relative;
        background: white;
    }
    
    .card:hover { 
        transform:translateY(-5px); 
        box-shadow:0 15px 30px rgba(0,61,128,0.2); 
    }

    .card.bg-primary { background:linear-gradient(135deg,var(--blue-primary),var(--blue-secondary)) !important; }
    .card.bg-warning { background:linear-gradient(135deg,#ff9500,#ff7b00) !important; }
    .card.bg-success { background:linear-gradient(135deg,#28a745,#20c997) !important; }
    .card.bg-danger { background:linear-gradient(135deg,#dc3545,#e74c3c) !important; }

    .stats-card {
        text-align: center;
        padding: 30px 20px;
        border-radius: 20px;
        margin-bottom: 20px;
    }

    .stats-card h5 {
        margin-bottom: 15px;
        font-weight: 600;
        opacity: 0.9;
    }

    .stats-card h2 {
        font-size: 3rem;
        font-weight: 700;
        margin: 0;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,61,128,0.1);
    }

    .table-header {
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
        color: white;
        padding: 20px 30px;
        margin: 0;
    }

    .table-light th { 
        background:var(--blue-light) !important; 
        color:var(--blue-primary); 
        font-weight:700;
        border: none;
        padding: 15px;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: rgba(0,61,128,0.1);
    }

    .badge { 
        padding:0.5rem 1rem; 
        border-radius:50px; 
        font-weight:600; 
        font-size:0.85rem; 
    }

    .notification-item {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(0,61,128,0.08);
        border-left: 4px solid var(--blue-accent);
        transition: transform 0.3s ease;
    }

    .notification-item:hover {
        transform: translateX(5px);
    }

    /* Avis étoiles */
    .stars { 
        display:flex; 
        gap:5px; 
        cursor:pointer; 
    }
    
    .star { 
        font-size:20px; 
        color:#ccc; 
        transition:color 0.3s ease; 
    }
    
    .star.active, .star.hover { 
        color:gold; 
    }

    /* Chat AI */
    #chat-bubble { 
        position: fixed; 
        bottom:20px; 
        right:20px; 
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary)); 
        color:white; 
        width:60px; 
        height:60px; 
        border-radius:50%; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        cursor:pointer; 
        box-shadow:0 8px 25px rgba(0,61,128,0.3); 
        z-index:1000;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    #chat-bubble:hover {
        transform: scale(1.1);
        box-shadow:0 12px 30px rgba(0,61,128,0.4);
    }
    
    #chat-box { 
        position: fixed; 
        bottom:90px; 
        right:20px; 
        width:350px; 
        max-height:500px; 
        background:#fff; 
        border-radius:20px; 
        box-shadow:0 15px 40px rgba(0,0,0,0.2); 
        display:flex; 
        flex-direction:column; 
        overflow:hidden; 
        z-index:1000; 
        opacity:0; 
        transform:translateY(20px); 
        transition: all 0.3s ease; 
    }
    
    #chat-box.show { 
        opacity:1; 
        transform:translateY(0); 
    }
    
    .chat-header{
        background:linear-gradient(135deg,var(--blue-primary),var(--blue-secondary)); 
        color:white; 
        padding:15px 20px; 
        font-weight:600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .chat-messages{
        flex:1; 
        padding:15px; 
        overflow-y:auto;
        max-height: 300px;
    }
    
    .message{
        margin-bottom:12px; 
        padding:12px 16px; 
        border-radius:18px; 
        max-width:85%;
        line-height: 1.4;
    }
    
    .message.user{
        background:var(--blue-light); 
        margin-left:auto;
        color: var(--blue-primary);
    }
    
    .message.bot{
        background:var(--blue-primary); 
        color:white; 
        margin-right:auto;
    }
    
    .chat-questions{
        padding: 15px;
        border-top: 1px solid #eee;
    }

    .chat-questions button{
        background:var(--blue-accent); 
        color:white; 
        border:none; 
        border-radius:12px; 
        padding:10px 15px; 
        margin:5px 0; 
        cursor:pointer;
        width: 100%;
        text-align: left;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    .chat-questions button:hover {
        background: var(--blue-primary);
    }

    #close-chat {
        cursor: pointer;
        font-size: 18px;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    #close-chat:hover {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .main-content {
            margin-left: 0;
            padding: 20px 15px;
        }
        
        .stats-card h2 {
            font-size: 2rem;
        }
        
        #chat-box {
            width: 300px;
            right: 10px;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Menu vertical -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>IPSEN Group Transit</h3>
            <p>Client {{ Auth::user()->name }}</p>

        </div>
        <nav class="sidebar-menu">
            <a href="#" class="menu-item active" data-section="overview">
                📊 Vue d'ensemble
            </a>
            <a href="#" class="menu-item" data-section="colis">
                📦 Mes Colis
            </a>
            <a href="#" class="menu-item" data-section="notifications">
                🔔 Notifications
            </a>
            <a href="#" class="menu-item" data-section="statistiques">
                📈 Statistiques
            </a>
             
        </nav>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        
        <!-- Section Vue d'ensemble -->
        <div id="overview" class="content-section active">
            <div class="page-header">
                <h1>📊 Vue d'ensemble</h1>
            </div>
            
            <!-- Statistiques rapides -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary stats-card">
                        <h5>Total Dossiers</h5>
                        <h2>{{ $stats['total'] }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning stats-card">
                        <h5>En cours</h5>
                        <h2>{{ $stats['en_cours'] }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success stats-card">
                        <h5>Terminés</h5>
                        <h2>{{ $stats['termines'] }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger stats-card">
                        <h5>Bloqués</h5>
                        <h2>{{ $stats['bloques'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- Dernières notifications -->
            <div class="table-container">
                <h5 class="table-header">🔔 Notifications récentes</h5>
                <div style="padding: 20px;">
                    @forelse($notifications->take(3) as $notif)
                        <div class="notification-item">
                            {{ $notif->contenu }}
                            <br><small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="notification-item">
                            <p class="text-muted mb-0">Aucune notification récente.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Section Mes Colis -->
        <div id="colis" class="content-section">
            <div class="page-header">
                <h1>📦 Mes Colis</h1>
            </div>
            
            <div class="table-container">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Status</th>
                            <th>Prévision Livraison 📅</th>
                            <th>Créé le</th>
                            <th>Action</th>
                            <th>Avis ⭐</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dossiers as $dossier)
                            <tr>
                                <td>{{ $dossier->id }}</td>
                                <td>{{ $dossier->description }}</td>
                                <td>
                                    <span class="badge 
                                        @if($dossier->status == 'En cours') bg-warning 
                                        @elseif($dossier->status == 'Terminé') bg-success
                                        @elseif($dossier->status == 'Bloqué') bg-danger
                                        @else bg-secondary @endif">
                                        {{ $dossier->status }}
                                    </span>
                                </td>
                                <td>
                                    {{ $dossier->date_prevision ? $dossier->date_prevision->format('d/m/Y') : 'En calcul...' }}
                                </td>
                                <td>{{ $dossier->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('client.dossiers.show', $dossier->id) }}" class="btn btn-sm btn-primary">
                                        Voir détails
                                    </a>
                                </td>
                                <td>
                                    @if($dossier->status == 'Terminé' && !$dossier->avis)
                                        <form method="POST" action="{{ route('client.dossiers.avis', $dossier->id) }}" class="avis-form" data-dossier="{{ $dossier->id }}">
                                            @csrf
                                            <div class="stars">
                                                <input type="hidden" name="note" value="0">
                                                <span class="star">★</span>
                                                <span class="star">★</span>
                                                <span class="star">★</span>
                                                <span class="star">★</span>
                                                <span class="star">★</span>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-success mt-2">Envoyer</button>
                                        </form>
                                    @elseif($dossier->avis)
                                        ⭐ {{ $dossier->avis->note }}/5
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">Aucun dossier trouvé.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section Notifications -->
        <div id="notifications" class="content-section">
            <div class="page-header">
                <h1>🔔 Toutes les Notifications</h1>
            </div>
            
            <div style="max-height: 600px; overflow-y: auto;">
                @forelse($notifications as $notif)
                    <div class="notification-item">
                        {{ $notif->contenu }}
                        <br><small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="notification-item">
                        <p class="text-muted mb-0">Aucune notification.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section Statistiques -->
        <div id="statistiques" class="content-section">
            <div class="page-header">
                <h1>📈 Statistiques Détaillées</h1>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card text-white bg-primary stats-card">
                        <h5>Total Dossiers</h5>
                        <h2>{{ $stats['total'] }}</h2>
                        <small>Depuis le début</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-warning stats-card">
                        <h5>En cours</h5>
                        <h2>{{ $stats['en_cours'] }}</h2>
                        <small>Actuellement en traitement</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-success stats-card">
                        <h5>Terminés</h5>
                        <h2>{{ $stats['termines'] }}</h2>
                        <small>Livrés avec succès</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-danger stats-card">
                        <h5>Bloqués</h5>
                        <h2>{{ $stats['bloques'] }}</h2>
                        <small>Nécessitent une intervention</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 💬 Chat AI --}}
<div id="chat-bubble">💬</div>
<div id="chat-box">
    <div class="chat-header">
        Assistant Transport
        <span id="close-chat">✖</span>
    </div>
    <div class="chat-messages" id="chat-messages"></div>
    <div class="chat-questions" id="chat-questions">
        <button data-answer="Le transport international désigne le déplacement de marchandises ou personnes entre deux pays.">Qu'est-ce que le transport international ?</button>
        <button data-answer="Le suivi de colis permet de savoir où se trouve votre colis en temps réel.">Comment suivre mon colis ?</button>
        <button data-answer="Le délai standard pour la livraison internationale est généralement de 5 à 15 jours selon la destination.">Quel est le délai de livraison ?</button>
        <button data-answer="Vous pouvez contacter notre support via le formulaire de contact ou par téléphone.">Comment contacter le support ?</button>
    </div>
</div>


<script>
    // Navigation du menu
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Retirer la classe active de tous les items du menu
            document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
            // Ajouter la classe active à l'item cliqué
            this.classList.add('active');
            
            // Cacher toutes les sections
            document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
            // Afficher la section correspondante
            const sectionId = this.dataset.section;
            document.getElementById(sectionId).classList.add('active');
        });
    });

    // Chat AI
    const bubble = document.getElementById('chat-bubble');
    const chatBox = document.getElementById('chat-box');
    const closeChat = document.getElementById('close-chat');
    const chatMessages = document.getElementById('chat-messages');
    const chatQuestions = document.getElementById('chat-questions');
    let isChatOpen = false;
    
    bubble.addEventListener('click', () => { 
        chatBox.classList.toggle('show'); 
        isChatOpen = !isChatOpen; 
    });
    
    closeChat.addEventListener('click', () => { 
        chatBox.classList.remove('show'); 
        isChatOpen=false; 
    });
    
    chatQuestions.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
            const userMsg = document.createElement('div');
            userMsg.className = "message user"; 
            userMsg.textContent = btn.textContent;
            chatMessages.appendChild(userMsg);
            
            const botMsg = document.createElement('div');
            botMsg.className = "message bot"; 
            botMsg.textContent = btn.dataset.answer;
            chatMessages.appendChild(botMsg);
            
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    });

    // ⭐ Système d'avis
    document.querySelectorAll(".stars").forEach(starContainer => {
        const stars = starContainer.querySelectorAll(".star");
        const input = starContainer.querySelector("input[name='note']");
        
        stars.forEach((star, index) => {
            star.addEventListener("mouseover", () => {
                stars.forEach((s, i) => s.classList.toggle("hover", i <= index));
            });
            
            star.addEventListener("mouseout", () => {
                stars.forEach(s => s.classList.remove("hover"));
            });
            
            star.addEventListener("click", () => {
                input.value = index + 1;
                stars.forEach((s, i) => s.classList.toggle("active", i < input.value));
            });
        });
    });

    // Soumission des avis
    document.querySelectorAll('.avis-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const dossierId = form.dataset.dossier;
            const token = form.querySelector('input[name="_token"]').value;
            const note = form.querySelector("input[name='note']").value;

            if(note < 1){
                alert('Veuillez sélectionner une note avant d\'envoyer votre avis.');
                return;
            }

            fetch(`/client/dossiers/${dossierId}/avis`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ note: note })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.parentElement.innerHTML = `⭐ ${note}/5`;
                } else {
                    alert('Erreur: ' + (data.message || 'Impossible d\'envoyer l\'avis.'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Erreur lors de l\'envoi.');
            });
        });
    });
</script>
@endsection