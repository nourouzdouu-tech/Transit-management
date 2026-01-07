<?php

namespace App\Models;
use App\Models\Message;
use App\Models\Dossier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id', 'expediteur_id', 'destinataire_id', 'contenu', 'lu'
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }
  

public function terminerDossier($dossierId)
{
    $dossier = Dossier::findOrFail($dossierId);

    // Mettre à jour le statut
    $dossier->status = 'Terminé';
    $dossier->save();

    // Créer un message automatique de confirmation pour le client
    Message::create([
        'dossier_id'      => $dossier->id,
        'expediteur_id'   => null, // null = système
        'destinataire_id' => $dossier->client_id,
        'contenu'         => "✅ Votre colis n°{$dossier->numero} a été livré avec succès.",
        'lu'              => false
    ]);

    return redirect()->back()->with('success', 'Le dossier est terminé et le client a été notifié.');
}

}