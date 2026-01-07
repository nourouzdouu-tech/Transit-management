<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouveauMessageNotification extends Notification
{
    use Queueable;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email + base de données
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouveau message reçu')
                    ->line('Vous avez reçu un nouveau message de ' . $this->message->expediteur->name)
                    ->action('Voir le message', url('/messages/' . $this->message->dossier_id))
                    ->line('Contenu : ' . $this->message->contenu);
    }

    public function toArray($notifiable)
    {
        return [
            'dossier_id' => $this->message->dossier_id,
            'expediteur' => $this->message->expediteur->name,
            'contenu' => $this->message->contenu,
        ];
    }
}
