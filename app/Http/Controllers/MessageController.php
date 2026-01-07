<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NouveauMessageNotification;
use App\Models\Dossier;


class MessageController extends Controller
{
public function index()
{
    $dossiers = Dossier::all(); // ou filtrer selon l’agent connecté
    $messages = collect(); // aucun message par défaut

    return view('messages.index', compact('dossiers', 'messages'));
}
public function store(Request $request)
{
    $request->validate([
        'dossier_id' => 'required|exists:dossiers,id',
        'contenu' => 'required|string|max:1000',
        'destinataire_id' => 'required|exists:users,id',
    ]);

    $message = Message::create([
        'dossier_id' => $request->dossier_id,
        'expediteur_id' => Auth::id(),
        'destinataire_id' => $request->destinataire_id,
        'contenu' => $request->contenu,
    ]);

    // notification
    $destinataire = User::find($request->destinataire_id);
    $destinataire->notify(new NouveauMessageNotification($message));

    return redirect()->back()->with('success', 'Message envoyé.');
}
/*public function messagesJson($dossierId)
{
    return Message::with('expediteur') // charge le user
                  ->where('dossier_id', $dossierId)
                  ->orderBy('created_at', 'asc')
                  ->get();
}*/
public function messagesJson($dossierId)
{
    return Message::where('dossier_id', $dossierId)
                  ->with('expediteur') // <-- Charger la relation expediteur
                  ->orderBy('created_at', 'asc')
                  ->get();
}



}
