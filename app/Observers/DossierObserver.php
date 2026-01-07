<?php

namespace App\Observers;
use App\Models\Message;
use App\Models\Dossier;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;

class DossierObserver
{
    public function updating(Dossier $dossier)
    {
        // Vérifier si le statut a changé
        if ($dossier->isDirty('status')) {
            Historique::create([
                'dossier_id'     => $dossier->id,
                'user_id'        => Auth::id() ?? $dossier->agent_id, // on prend l'agent si pas d'auth
                'action'         => 'Changement de statut',
                'description'    => "Le statut est passé de '{$dossier->getOriginal('status')}' à '{$dossier->status}'",
                'ancien_status'  => $dossier->getOriginal('status'),
                'nouveau_status' => $dossier->status,
            ]);
        }
    }
     public function updated(Dossier $dossier)
    {
        // Vérifie si le statut vient de passer à "terminé"
        if ($dossier->isDirty('statut') && $dossier->statut === 'terminé') {
            Message::create([
                'dossier_id' => $dossier->id,
                'expediteur_id' => Auth::id(), // ou 0 si système
                'destinataire_id' => $dossier->client->id,
                'contenu' => "Bonjour {$dossier->client->name}, votre dossier #{$dossier->numero} est terminé ✅. Merci pour votre confiance !"
            ]);
        }
    }
}
