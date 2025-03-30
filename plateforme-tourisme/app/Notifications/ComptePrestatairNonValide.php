<?php

namespace App\Notifications;

use App\Models\Prestataire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComptePrestatairNonValide extends Notification implements ShouldQueue
{
    use Queueable;

    protected $prestataire;

    public function __construct(Prestataire $prestataire)
    {
        $this->prestataire = $prestataire;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Information concernant votre demande d\'inscription')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Nous avons examiné votre demande d\'inscription en tant que prestataire de services touristiques.')
            ->line('Nous sommes au regret de vous informer que votre demande n\'a pas été approuvée pour le moment.')
            ->line('Si vous avez des questions, vous pouvez nous contacter à l\'adresse support@exemple.com.')
            ->line('Nous vous remercions de votre compréhension.')
            ->salutation('L\'équipe de la plateforme touristique');
    }
}