@extends('layouts.app')

@section('title', 'Détails du Dossier')

@section('content')
<style>
    :root {
        --blue-primary: #003d80;
        --blue-secondary: #0052a6;
        --blue-light: #e6f2ff;
        --blue-accent: #0066cc;
        --blue-dark: #002b5c;
        --gradient-primary: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
        --gradient-accent: linear-gradient(135deg, var(--blue-accent), var(--blue-primary));
    }

    body {
        background: radial-gradient(ellipse at top, var(--blue-light) 0%, #f0f7ff 50%, #ffffff 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 15px;
        animation: fadeInScale 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Navigation Header - Compact */
    .nav-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px 0;
    }

    .back-button {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--gradient-primary);
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(0, 61, 128, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .back-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .back-button:hover::before {
        left: 100%;
    }

    .back-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 61, 128, 0.4);
        color: white;
        text-decoration: none;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--blue-primary);
        font-weight: 500;
        font-size: 1rem;
    }

    /* Hero Section - Compact */
    .hero-section {
        background: var(--gradient-primary);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 61, 128, 0.2);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: heroFloat 12s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -15%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: heroFloat 15s ease-in-out infinite reverse;
    }

    @keyframes heroFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(20px, -30px) scale(1.1); }
        66% { transform: translate(-10px, 20px) scale(0.9); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    .dossier-number {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 15px;
        background: linear-gradient(45deg, #ffffff, #e6f2ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(255,255,255,0.5);
    }

    .hero-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .hero-info-card {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 15px;
        padding: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .hero-info-card:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
    }

    .info-icon-large {
        font-size: 1.8rem;
        margin-bottom: 8px;
        display: block;
    }

    .info-title {
        font-size: 0.8rem;
        opacity: 0.9;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 700;
    }

    /* Status Badge Compact */
    .status-badge-unique {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .status-badge-unique::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: statusPulse 2s infinite;
        box-shadow: 0 0 8px currentColor;
    }

    .status-badge-unique.bg-secondary { 
        background: linear-gradient(135deg, #6c757d, #495057); 
        color: white;
    }

    .status-badge-unique.bg-warning { 
        background: linear-gradient(135deg, #ffc107, #ff9500); 
        color: #856404; 
    }

    .status-badge-unique.bg-success { 
        background: linear-gradient(135deg, #28a745, #20c997); 
        color: white;
    }

    .status-badge-unique.bg-danger { 
        background: linear-gradient(135deg, #dc3545, #e74c3c); 
        color: white;
    }

    @keyframes statusPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.2); }
    }

    /* Progress Section Compact */
    .progress-section {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0, 61, 128, 0.08);
        border: 1px solid rgba(0, 61, 128, 0.05);
        position: relative;
        overflow: hidden;
    }

    .progress-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-accent);
    }

    .progress-title-unique {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--blue-primary);
        margin-bottom: 15px;
    }

    .progress-container-unique {
        position: relative;
        height: 35px;
        background: var(--blue-light);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 61, 128, 0.1);
    }

    .progress-bar-unique {
        height: 100%;
        background: var(--gradient-accent);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
        transition: width 2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 10px rgba(0, 102, 204, 0.3);
    }

    .progress-bar-unique::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: progressShine 3s infinite;
    }

    @keyframes progressShine {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Single Column Layout */
    .content-section {
        margin-bottom: 20px;
    }

    .main-content-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 61, 128, 0.08);
        border: 1px solid rgba(0, 61, 128, 0.05);
        margin-bottom: 20px;
    }

    .content-header-unique {
        background: var(--gradient-primary);
        color: white;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.3rem;
        font-weight: 700;
        position: relative;
    }

    .content-header-unique::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 25px;
        right: 25px;
        height: 8px;
        background: linear-gradient(180deg, rgba(255,255,255,0.2), transparent);
        border-radius: 8px 8px 0 0;
    }

    .content-body {
        padding: 25px;
    }

    /* History Timeline Compact */
    .timeline-unique {
        position: relative;
        padding-left: 30px;
    }

    .timeline-unique::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--gradient-accent);
        border-radius: 2px;
    }

    .timeline-item-unique {
        position: relative;
        background: linear-gradient(135deg, #ffffff, var(--blue-light));
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 15px;
        margin-left: 20px;
        box-shadow: 0 4px 15px rgba(0, 61, 128, 0.08);
        border: 1px solid rgba(0, 61, 128, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .timeline-item-unique::before {
        content: '';
        position: absolute;
        left: -32px;
        top: 15px;
        width: 14px;
        height: 14px;
        background: var(--blue-accent);
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0, 102, 204, 0.5);
    }

    .timeline-item-unique:hover {
        transform: translateX(8px) translateY(-1px);
        box-shadow: 0 8px 20px rgba(0, 61, 128, 0.15);
    }

    .timeline-status {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--blue-primary);
        margin-bottom: 5px;
    }

    .timeline-date {
        color: var(--blue-accent);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .timeline-description {
        color: var(--blue-dark);
        line-height: 1.5;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .timeline-user {
        font-size: 0.85rem;
        color: var(--blue-secondary);
        font-weight: 500;
    }

    /* Chat Section Compact */
    .chat-section {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 61, 128, 0.1);
        border: 1px solid rgba(0, 61, 128, 0.05);
    }

    .chat-header-unique {
        background: var(--gradient-primary);
        color: white;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .chat-header-unique::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }

    .chat-avatar {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .chat-info h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .chat-info small {
        opacity: 0.9;
        font-size: 0.85rem;
    }

    .chat-messages-unique {
        padding: 20px;
        background: linear-gradient(180deg, #f8faff 0%, var(--blue-light) 100%);
        min-height: 250px;
        max-height: 350px;
        overflow-y: auto;
    }

    .chat-messages-unique::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages-unique::-webkit-scrollbar-track {
        background: rgba(0, 61, 128, 0.1);
        border-radius: 10px;
    }

    .chat-messages-unique::-webkit-scrollbar-thumb {
        background: var(--blue-accent);
        border-radius: 10px;
    }

    .message-unique {
        max-width: 80%;
        margin-bottom: 15px;
        animation: messageSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateY(10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .message-sent-unique {
        margin-left: auto;
        text-align: right;
    }

    .message-received-unique {
        margin-right: auto;
        text-align: left;
    }

    .message-bubble {
        display: inline-block;
        padding: 12px 16px;
        border-radius: 20px;
        position: relative;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        word-wrap: break-word;
        font-size: 0.95rem;
    }

    .message-sent-unique .message-bubble {
        background: var(--gradient-accent);
        color: white;
        border-bottom-right-radius: 6px;
    }

    .message-received-unique .message-bubble {
        background: white;
        color: var(--blue-dark);
        border: 1px solid var(--blue-light);
        border-bottom-left-radius: 6px;
    }

    .message-meta {
        margin-top: 5px;
        font-size: 0.75rem;
        opacity: 0.7;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .message-sent-unique .message-meta {
        justify-content: flex-end;
    }

    .message-received-unique .message-meta {
        justify-content: flex-start;
    }

    /* Chat Input Compact */
    .chat-input-section {
        padding: 20px 25px;
        background: white;
        border-top: 1px solid rgba(0, 61, 128, 0.1);
    }

    .chat-form-unique {
        display: flex;
        gap: 12px;
        align-items: flex-end;
    }

    .chat-input-unique {
        flex: 1;
        border: 2px solid var(--blue-light);
        border-radius: 20px;
        padding: 12px 16px;
        font-size: 0.95rem;
        resize: none;
        min-height: 40px;
        max-height: 100px;
        transition: all 0.3s ease;
        background: var(--blue-light);
        font-family: inherit;
    }

    .chat-input-unique:focus {
        outline: none;
        border-color: var(--blue-accent);
        background: white;
        box-shadow: 0 0 15px rgba(0, 102, 204, 0.2);
    }

    .send-button-unique {
        background: var(--gradient-accent);
        color: white;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
        flex-shrink: 0;
    }

    .send-button-unique:hover {
        transform: scale(1.1) rotate(45deg);
        box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
    }

    /* Empty States Compact */
    .empty-state-unique {
        text-align: center;
        padding: 40px 30px;
        color: var(--blue-primary);
    }

    .empty-state-icon-unique {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.4;
        animation: gentleBounce 3s infinite;
    }

    @keyframes gentleBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .empty-state-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-state-text {
        opacity: 0.7;
        font-size: 1rem;
    }

    /* Alert Success Compact */
    .alert-success-unique {
        background: linear-gradient(135deg, #d4edda, #a8e6cf);
        border: 2px solid #28a745;
        border-radius: 15px;
        color: #155724;
        padding: 15px 20px;
        margin: 15px 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.5s ease-out;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.2);
        font-size: 0.95rem;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .detail-container {
            padding: 10px;
        }
        
        .nav-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        
        .dossier-number {
            font-size: 2rem;
        }
        
        .hero-info-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        
        .hero-section {
            padding: 20px;
        }
        
        .progress-section {
            padding: 15px;
        }
        
        .content-body {
            padding: 20px;
        }
        
        .timeline-unique {
            padding-left: 25px;
        }
        
        .timeline-item-unique {
            margin-left: 15px;
        }
        
        .chat-form-unique {
            flex-direction: column;
            gap: 10px;
        }
        
        .send-button-unique {
            align-self: flex-end;
        }
        
        .chat-messages-unique {
            min-height: 200px;
            max-height: 250px;
        }
    }
</style>

<div class="detail-container">
    <!-- Navigation Header -->
    <div class="nav-header">
        <a href="{{ route('client.dashboard') }}" class="back-button">
            ← Retour au Dashboard
        </a>
        <div class="breadcrumb">
            Dashboard → 📦 Détails du Colis
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="dossier-number">Colis {{ $dossier->numero }}</div>
            <div class="hero-info-grid">
                <div class="hero-info-card">
                    <span class="info-icon-large">📅</span>
                    <div class="info-title">Date de création</div>
                    <div class="info-value">{{ $dossier->date_creation->format('d/m/Y') }}</div>
                </div>
                <div class="hero-info-card">
                    <span class="info-icon-large">📝</span>
                    <div class="info-title">Description</div>
                    <div class="info-value">{{ $dossier->description }}</div>
                </div>
                <div class="hero-info-card">
                    <span class="info-icon-large">🏷️</span>
                    <div class="info-title">Statut actuel</div>
                    <div class="info-value">
                        <span class="status-badge-unique 
                            @if($dossier->status == 'En attente') bg-secondary
                            @elseif($dossier->status == 'En cours') bg-warning
                            @elseif($dossier->status == 'Terminé') bg-success
                            @elseif($dossier->status == 'Bloqué') bg-danger
                            @endif">
                            {{ $dossier->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $progressPercent = match($dossier->status) {
            'En attente' => 0,
            'En retard' => 20,       
            'En cours' => 50,
            'Terminé' => 100,
            default => 0
        };
    @endphp

    <!-- Progress Section -->
    <div class="progress-section">
        <div class="progress-title-unique">
            📊 Progression du traitement
        </div>
        <div class="progress-container-unique">
            <div class="progress-bar-unique" style="width: {{ $progressPercent }}%;">
                {{ round($progressPercent) }}% Complété
            </div>
        </div>
    </div>

    <!-- Historique des statuts -->
    <div class="content-section">
        <div class="main-content-card">
            <div class="content-header-unique">
                📜 Historique des Statuts
            </div>
            <div class="content-body">
                @if($dossier->historiques->count() > 0)
                    <div class="timeline-unique">
                        @foreach($dossier->historiques->sortByDesc('created_at') as $history)
                            <div class="timeline-item-unique">
                                <div class="timeline-status">{{ $history->nouveau_status }}</div>
                                <div class="timeline-date">{{ $history->created_at->format('d/m/Y à H:i') }}</div>
                                <div class="timeline-description">{{ $history->description }}</div>
                                <div class="timeline-user">👤 {{ $history->user->name ?? 'Agent inconnu' }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-unique">
                        <div class="empty-state-icon-unique">📋</div>
                        <div class="empty-state-title">Aucun changement de statut</div>
                        <div class="empty-state-text">Le statut n'a pas encore évolué depuis sa création.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Chat Section -->
    <div class="content-section">
        <div class="chat-section">
            <div class="chat-header-unique">
                <div class="chat-avatar">👨‍💼</div>
                <div class="chat-info">
                    <h4>💬 Messages avec l'agent</h4>
                    <small>Conversation en temps réel</small>
                </div>
            </div>

            @if(session('success'))
                <div class="alert-success-unique">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="chat-messages-unique" id="chatMessages">
                @forelse($dossier->messages as $message)
                    <div class="message-unique {{ $message->expediteur_id == auth()->id() ? 'message-sent-unique' : 'message-received-unique' }}">
                        <div class="message-bubble">
                            {{ $message->contenu }}
                        </div>
                        <div class="message-meta">
                            <strong>{{ $message->expediteur->name }}</strong>
                            <span>•</span>
                            <span>{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state-unique">
                        <div class="empty-state-icon-unique">💬</div>
                        <div class="empty-state-title">Aucun message</div>
                        <div class="empty-state-text">Commencez la conversation avec votre agent</div>
                    </div>
                @endforelse
            </div>

            <div class="chat-input-section">
                <form method="POST" action="{{ route('client.messages.send', $dossier->id) }}" class="chat-form-unique">
                    @csrf
                    <textarea 
                        name="contenu" 
                        class="chat-input-unique" 
                        placeholder="💭 Tapez votre message..." 
                        required 
                        maxlength="1000" 
                        rows="1"
                        onInput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px'"
                    ></textarea>
                    <button type="submit" class="send-button-unique">
                        🚀
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to bottom of chat
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});

// Auto-focus on input and handle Enter key
const chatInput = document.querySelector('.chat-input-unique');
if (chatInput) {
    chatInput.focus();
    
    // Handle Enter key (Shift+Enter for new line, Enter to send)
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });
    
    // Auto-resize textarea
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 100) + 'px';
    });
}

// Animate progress bar on load
window.addEventListener('load', function() {
    const progressBar = document.querySelector('.progress-bar-unique');
    if (progressBar) {
        const width = progressBar.style.width;
        progressBar.style.width = '0%';
        setTimeout(() => {
            progressBar.style.width = width;
        }, 300);
    }
});

// Add smooth scrolling for timeline items
document.querySelectorAll('.timeline-item-unique').forEach((item, index) => {
    item.style.animationDelay = `${index * 0.1}s`;
    item.classList.add('timeline-fade-in');
});

// Add CSS for timeline fade-in animation
const style = document.createElement('style');
style.textContent = `
    .timeline-fade-in {
        animation: fadeInUp 0.6s ease-out both;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

// Enhanced message sending with loading state
document.querySelector('.chat-form-unique').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('.send-button-unique');
    const input = this.querySelector('.chat-input-unique');
    
    // Add loading state
    submitBtn.style.transform = 'scale(0.95)';
    submitBtn.innerHTML = '⏳';
    input.disabled = true;
    
    // Reset after form submission (will be handled by page reload)
    setTimeout(() => {
        submitBtn.innerHTML = '🚀';
        submitBtn.style.transform = '';
        input.disabled = false;
    }, 1000);
});

// Add intersection observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

// Observe timeline items for scroll animations
document.querySelectorAll('.timeline-item-unique').forEach(item => {
    observer.observe(item);
});

// Add animate-in class styles
const animateStyle = document.createElement('style');
animateStyle.textContent = `
    .timeline-item-unique {
        opacity: 0;
        transform: translateX(-20px);
        transition: all 0.5s ease-out;
    }
    
    .timeline-item-unique.animate-in {
        opacity: 1;
        transform: translateX(0);
    }
`;
document.head.appendChild(animateStyle);

// Add subtle parallax effect to hero section (reduced for compact design)
window.addEventListener('scroll', function() {
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.3;
        heroSection.style.transform = `translateY(${rate}px)`;
    }
});

// Smooth scroll to chat when there are new messages
function scrollToChat() {
    const chatSection = document.querySelector('.chat-section');
    if (chatSection) {
        chatSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Auto-refresh chat messages every 30 seconds (optional)
setInterval(function() {
    // This would typically involve an AJAX call to check for new messages
    // For now, we'll just ensure the chat is scrolled to bottom
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages && chatMessages.children.length > 0) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}, 30000);
</script>

@endsection