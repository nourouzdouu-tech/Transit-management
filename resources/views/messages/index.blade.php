@extends('layouts.app')

@section('title', 'Messagerie Moderne')

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
    background: linear-gradient(135deg, var(--blue-light), #f8faff);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
}

/* Container */
.container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

@media(min-width: 768px) {
    .container {
        flex-direction: row;
    }
}

/* Left Panel */
.client-list {
    background: var(--blue-light);
    border-radius: 2rem;
    padding: 1.5rem;
    box-shadow: 0 15px 35px rgba(0,61,128,0.1);
    flex: 1;
}

.client-list h2 {
    color: var(--blue-primary);
    text-align: center;
    margin-bottom: 1rem;
}

.client-list select {
    width: 100%;
    padding: 0.75rem;
    border-radius: 1rem;
    border: 2px solid var(--blue-primary);
    margin-bottom: 1rem;
}

.client-list p {
    text-align: center;
    color: var(--blue-secondary);
    font-weight: 600;
}

/* Chat Panel */
.chat-container {
    background: #ffffff;
    border-radius: 2rem;
    flex: 2;
    display: flex;
    flex-direction: column;
    height: 80vh;
    box-shadow: 0 15px 35px rgba(0,61,128,0.1);
    overflow: hidden;
}

.chat-header {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
    color: white;
    gap: 0.75rem;
}

.chat-header .avatar {
    width: 45px;
    height: 45px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    background: linear-gradient(180deg, #f8faff 0%, var(--blue-light) 100%);
}

.chat-messages::-webkit-scrollbar {
    width: 5px;
}
.chat-messages::-webkit-scrollbar-track {
    background: var(--blue-light);
    border-radius: 10px;
}
.chat-messages::-webkit-scrollbar-thumb {
    background: var(--blue-accent);
    border-radius: 10px;
}

.message {
    max-width: 70%;
    padding: 0.75rem 1rem;
    border-radius: 1.5rem;
    position: relative;
    word-wrap: break-word;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    animation: messageSlide 0.4s ease-out;
}

@keyframes messageSlide {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.message-sent {
    align-self: flex-end;
    background: linear-gradient(135deg, var(--blue-accent), var(--blue-secondary));
    color: white;
    border-bottom-right-radius: 0.2rem;
}

.message-received {
    align-self: flex-start;
    background: #ffffff;
    color: var(--blue-dark);
    border: 1px solid var(--blue-light);
    border-bottom-left-radius: 0.2rem;
}

.message-info {
    font-size: 0.75rem;
    opacity: 0.8;
    margin-top: 0.25rem;
    display: flex;
    gap: 0.3rem;
}

.message-text {
    font-size: 0.95rem;
    line-height: 1.4;
}

/* Input */
.chat-input-container {
    padding: 1rem 1.5rem;
    background: #ffffff;
    border-top: 1px solid var(--blue-light);
}

.chat-input-form {
    display: flex;
    gap: 0.75rem;
}

.chat-input {
    flex: 1;
    border-radius: 2rem;
    border: 2px solid var(--blue-light);
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.chat-input:focus {
    outline: none;
    border-color: var(--blue-accent);
    background: #ffffff;
    box-shadow: 0 0 15px rgba(0,102,204,0.2);
}

.send-button {
    background: linear-gradient(135deg, var(--blue-accent), var(--blue-secondary));
    color: white;
    border: none;
    border-radius: 50%;
    width: 3rem;
    height: 3rem;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
}
.send-button:hover {
    transform: scale(1.1) rotate(360deg);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--blue-primary);
}
.empty-state-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
    animation: bounce 2s infinite;
}
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-8px); }
    60% { transform: translateY(-4px); }
}
.breadcrumb {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--blue-primary);
        font-weight: 500;
        font-size: 1.1rem;
    }
    
         @media (max-width: 768px) {
        .detail-container {
            padding: 15px;
        }
         .nav-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }}
         .detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        animation: fadeInScale 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .back-button {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #003d80;
        color: white;
        text-decoration: none;
        padding: 7px 14px;
        border-radius: 50px;
        font-weight: 300;
        font-size: 1rem;
        box-shadow: 0 8px 25px rgba(0, 61, 128, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

     /* Alert Success */
    .alert-success-unique {
        background: linear-gradient(135deg, #d4edda, #a8e6cf);
        border: 2px solid #28a745;
        border-radius: 20px;
        color: #155724;
        padding: 20px 25px;
        margin: 20px 30px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 15px;
        animation: slideDown 0.5s ease-out;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
    }

</style>
 <div class="detail-container">
        <div class="nav-header">
           <a href="{{ route('agent.dashboard') }}" class="back-button">
            ← Retour au Dashboard
           </a>
     </div>
 </div>
<div class="container mx-auto p-4 h-screen gap-6">
   
    <!-- Section gauche : liste des clients -->
    <div class="client-list md:w-2/3">
        <h2>Messagerie</h2>
        <select name="dossier_id" id="dossier_id">
            <option value="">Sélectionner un client</option>
            @foreach($dossiers as $dossier)
                <option value="{{ $dossier->id }}" 
                        data-client-id="{{ $dossier->client->id }}" 
                        data-client-name="{{ $dossier->client->name }}">
                    {{ $dossier->client->name }}
                </option>
            @endforeach
        </select>
        <p id="destinataireName"></p>
    

    <!-- Section droite : chat -->
    <div class="md:w-2/3">
        <div class="chat-container">
            <div class="chat-header">
                <div class="avatar">👨‍💼</div>
                <div>
                    <h4 style="margin:0; font-size:1.2rem;">💬 Conversation avec le client</h4>
                    <small style="opacity:0.8;">Discussion en temps réel</small>
                </div>
                  @if(session('success'))
                <div class="alert-success-unique">
                    ✅ {{ session('success') }}
                </div>
            @endif
            </div>

            <div class="chat-messages" id="chatMessages">
                <div class="empty-state">
                    <div class="empty-state-icon">💬</div>
                    <h4>Sélectionnez un client pour commencer</h4>
                </div>
            </div>

            <div class="chat-input-container">
                <form id="messageForm" action="{{ route('messages.store') }}" method="POST" class="chat-input-form">
                    @csrf
                    <input type="hidden" name="dossier_id" id="hiddenDossier">
                    <input type="hidden" name="destinataire_id" id="destinataire_id">
                    <input type="text" name="contenu" class="chat-input" placeholder="💭 Tapez votre message..." required maxlength="1000">
                    <button type="submit" class="send-button">🚀</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const selectDossier = document.getElementById('dossier_id');
const chatMessages = document.getElementById('chatMessages');
const hiddenDossier = document.getElementById('hiddenDossier');
const destinataireInput = document.getElementById('destinataire_id');

selectDossier.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const dossierId = selectedOption.value;
    const clientId = selectedOption.getAttribute('data-client-id');
    hiddenDossier.value = dossierId;
    destinataireInput.value = clientId;

    if(dossierId) {
        fetch(`/messages/json/${dossierId}`)
            .then(res => res.json())
            .then(data => {
                chatMessages.innerHTML = '';
                if(data.length === 0){
                    chatMessages.innerHTML = '<div class="empty-state"><div class="empty-state-icon">💬</div><h4>Aucun message pour ce dossier</h4></div>';
                } else {
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = `message ${msg.expediteur_id === {{ Auth::id() }} ? 'message-sent' : 'message-received'}`;

                        const content = document.createElement('div');
                        content.className = 'message-text';
                        content.textContent = msg.contenu;

                        const info = document.createElement('div');
                        info.className = 'message-info';
                        info.innerHTML = `<strong>${msg.expediteur?.name}</strong> • ${new Date(msg.created_at).toLocaleString('fr-FR', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit' })}`;

                        div.appendChild(content);
                        div.appendChild(info);
                        chatMessages.appendChild(div);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            });
    } else {
        chatMessages.innerHTML = '<div class="empty-state"><div class="empty-state-icon">💬</div><h4>Sélectionnez un client pour commencer</h4></div>';
    }
});
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
</script>
@endsection
