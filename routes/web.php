<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatAIController;

// --------------------------------------------------
// Redirection racine vers login
// --------------------------------------------------
Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/client/chat-ai', [App\Http\Controllers\Client\ChatAIController::class, 'ask'])->name('client.chat.ai');
Route::get('/test-openai', function() {
    dd(config('openai.api_key'));
});
Route::get('/agent/clients/pdf', [AgentController::class, 'exportClientsPdf'])->name('agent.clients.pdf');
Route::get('/agent/dossiers/pdf', [App\Http\Controllers\AgentController::class, 'downloadDossiersPDF'])->name('agent.dossiers.pdf');

Route::get('/agent/statistiques', [AgentController::class, 'statistiques'])
    ->name('agent.statistiques');


// --------------------------------------------------
// Authentification
// --------------------------------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --------------------------------------------------
// Inscription
// --------------------------------------------------
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// --------------------------------------------------
// Dashboard
// --------------------------------------------------
Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');

// --------------------------------------------------
// Gestion Clients (Agent)
// --------------------------------------------------
Route::prefix('agent/clients')->group(function () {
    Route::get('/', [AgentController::class, 'clients'])->name('agent.clients');
    Route::post('/', [AgentController::class, 'storeClient'])->name('agent.clients.store');
    Route::put('/{id}', [AgentController::class, 'updateClient'])->name('agent.clients.update');
    Route::delete('/{id}', [AgentController::class, 'destroyClient'])->name('agent.clients.destroy');
});

// --------------------------------------------------
// Gestion Dossiers (Agent)
// --------------------------------------------------
Route::prefix('agent/dossiers')->group(function () {
    Route::post('/', [AgentController::class, 'storeDossier'])->name('agent.dossiers.store');
    Route::put('/{id}', [AgentController::class, 'updateDossier'])->name('agent.dossiers.update');
    Route::delete('/{id}', [AgentController::class, 'destroyDossier'])->name('agent.dossiers.destroy');
    Route::get('/en-retard', [AgentController::class, 'dossiersEnRetard'])->name('agent.dossiers.en_retard');

    // Mise à jour du statut d’un dossier
    Route::put('/{dossier}/status', [AgentController::class, 'updateStatus'])->name('agent.dossiers.updateStatus');

    // Télécharger un document lié au dossier
    Route::get('/{dossierId}/documents/{documentId}/download', [AgentController::class, 'downloadDocument'])->name('agent.documents.download');
});

// --------------------------------------------------
// Espace Client
// --------------------------------------------------
Route::prefix('client')->group(function () {

    // Liste des dossiers
    Route::get('/dossiers', [ClientController::class, 'dossiers'])->name('client.dossiers');

    // Détail d’un dossier
    Route::get('/dossiers/{id}', [ClientController::class, 'showDossier'])->name('client.dossiers.show');

    // Télécharger un document lié au dossier
    Route::get('/dossiers/{dossierId}/documents/{documentId}/download', [ClientController::class, 'downloadDocument'])->name('client.documents.download');

    // Envoyer un message depuis le détail d’un dossier
    Route::post('/dossiers/{dossierId}/messages', [ClientController::class, 'sendMessage'])->name('client.messages.send');
});

// --------------------------------------------------
// Messagerie générale
// --------------------------------------------------
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/messages/json/{dossierId}', [MessageController::class, 'messagesJson'])->name('messages.json');


Route::get('/client/dossiers/{id}/suivi', [ClientController::class, 'suiviColis'])->name('client.suivi');
Route::post('/client/dossiers/{dossier}/avis', [ClientController::class, 'donnerAvis'])
    ->name('client.dossiers.avis');
