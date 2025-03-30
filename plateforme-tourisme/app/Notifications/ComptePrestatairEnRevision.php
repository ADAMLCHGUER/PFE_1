<?php

namespace App\Notifications;

use App\Models\Prestataire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComptePrestatairEnRevision extends Notification implements ShouldQueue
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
            ->subject('Votre demande d\'inscription est en cours de révision')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Nous avons bien reçu votre demande d\'inscription en tant que prestataire de services touristiques.')
            ->line('Notre équipe va examiner votre demande dans les plus brefs délais.')
            ->line('Vous recevrez une notification par email dès que votre compte sera validé.')
            ->line('Nous vous remercions de votre patience et de votre intérêt pour notre plateforme.')
            ->salutation('L\'équipe de la plateforme touristique');
    }
}