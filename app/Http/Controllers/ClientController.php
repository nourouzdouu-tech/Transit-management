<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Dossier;
use App\Models\Message;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DossierUpdated;

class ClientController extends Controller
{
    /**
     * Tableau de bord client : liste + stats
     */
   /* public function dashboard()
    {
        
        $dossiers = Auth::user()->dossiers()->latest()->get();

        $stats = [
            'total'    => $dossiers->count(),
            'en_attente' => $dossiers->where('status', 'En attente')->count(),
            'en_cours' => $dossiers->where('status', 'En cours')->count(),
            'termines' => $dossiers->where('status', 'Terminé')->count(),
            'bloques'  => $dossiers->where('status', 'Bloqué')->count(),
        ];

        return view('client.dashboard', compact('dossiers', 'stats'));
        $rappels = auth()->user()->receivedMessages()->latest()->take(5)->get();
        return view('client.dashboard', compact('rappels'));

    }*/
     /**
     * Laisser un avis après clôture du dossier
     */
   public function donnerAvis(Request $request, $dossierId)
{
    $request->validate([
        'note' => 'required|integer|min:1|max:5',
        'commentaire' => 'nullable|string|max:500'
    ]);

    $dossier = Auth::user()->dossiers()
                ->where('status', 'Terminé') // uniquement si terminé
                ->findOrFail($dossierId);

    $avis = Avis::create([
        'dossier_id' => $dossier->id,
        'client_id'  => Auth::id(),
        'note'       => $request->note,
        'commentaire'=> $request->commentaire,
    ]);

    if($request->ajax()) {
        return response()->json(['success' => true]);
    }

    return back()->with('success', 'Merci pour votre avis !');
}

    /**
     * Suivi colis en temps réel (exemple simple avec historiques)
     */
    public function suiviColis($dossierId)
    {
        $dossier = Auth::user()->dossiers()
                    ->with('historiques')
                    ->findOrFail($dossierId);

        return view('client.suivi', compact('dossier'));
    }

 public function dashboard()
{
    $dossiers = Auth::user()->dossiers()->latest()->get();
     // Calcul prévision
    foreach($dossiers as $dossier) {
        $dossier->date_prevision = $dossier->created_at->addDays(7); // +7 jours
    }

    $stats = [
        'total'      => $dossiers->count(),
        'en_attente' => $dossiers->where('status', 'En attente')->count(),
        'en_cours'   => $dossiers->where('status', 'En cours')->count(),
        'termines'   => $dossiers->where('status', 'Terminé')->count(),
        'bloques'    => $dossiers->where('status', 'Bloqué')->count(),
    ];

   // Notifications récentes
    $notifications = Auth::user()->receivedMessages()->latest()->take(5)->get();

    return view('client.dashboard', compact('dossiers', 'stats', 'notifications'));
}



    /**
     * Voir les détails d’un dossier
     */
   public function showDossier($id)
{
    $dossier = auth()->user()->dossiers()->with(['documents', 'historiques', 'messages.expediteur'])->findOrFail($id);

    // Diagramme de progression
    $etapesTotal = 5; // nombre total d'étapes
    $etapesEffectuees = $dossier->historiques->count();
    $progressPercent = ($etapesEffectuees / $etapesTotal) * 100;
    

    return view('client.dossier', compact('dossier', 'progressPercent'));
}

    

    /**
     * Télécharger un document lié à un dossier
     */
  public function downloadDocument($dossierId, $documentId)
{
    // Vérifier que le dossier appartient au client authentifié
    $dossier = Auth::user()->dossiers()->findOrFail($dossierId);

    // Vérifier que le document appartient à ce dossier
    $document = $dossier->documents()->findOrFail($documentId);

    // Télécharger le fichier
    return response()->download(storage_path('app/' . $document->chemin));
}


    /**
     * Envoyer un message à l’agent
     */
    public function sendMessage(Request $request, $dossierId)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000'
        ]);

        $dossier = Auth::user()->dossiers()->findOrFail($dossierId);

        Message::create([
            'dossier_id'      => $dossier->id,
            'expediteur_id'   => Auth::id(),
            'destinataire_id' => $dossier->agent_id,
            'contenu'         => $request->contenu
        ]);

        return back()->with('success', 'Message envoyé avec succès.');
    }

    /**
     * Historique des mises à jour d’un dossier
     */
    public function historique($dossierId)
    {
        $dossier = Auth::user()->dossiers()->with('historiques')->findOrFail($dossierId);
        return view('client.historique', compact('dossier'));
    }

    /**
     * Notification par email/SMS quand un dossier est mis à jour
     */
    public function notifierClient(Dossier $dossier)
    {
        $client = $dossier->client;
        Notification::send($client, new DossierUpdated($dossier));
    }

    public function dossiers()
{
    $dossiers = Auth::user()->dossiers()->latest()->get();
    return view('client.dossiers', compact('dossiers'));
}



}
