<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Dossier;

class DossierUpdated extends Notification
{
    use Queueable;

    protected $dossier;

    public function __construct(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function via($notifiable)
    {
        return ['mail']; // tu peux ajouter 'database' ou 'sms' si tu configures Twilio
    }

   public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject('Mise à jour de votre dossier')
                ->line("Le statut de votre dossier #{$this->dossier->numero} a été mis à jour : {$this->dossier->status}")
                ->action('Voir le dossier', url(route('client.dossiers.show', $this->dossier->id)))
                ->line('Merci de votre confiance.');
}

}
