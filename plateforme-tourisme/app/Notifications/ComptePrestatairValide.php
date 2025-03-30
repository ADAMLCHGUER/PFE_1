<?php

namespace App\Notifications;

use App\Models\Prestataire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComptePrestatairValide extends Notification implements ShouldQueue
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
            ->subject('Votre compte prestataire a été validé')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Félicitations ! Votre compte prestataire a été validé.')
            ->line('Vous pouvez maintenant vous connecter à votre espace prestataire et commencer à configurer votre service touristique.')
            ->action('Accéder à mon espace', route('prestataire.tableau'))
            ->line('Nous sommes ravis de vous compter parmi nos partenaires et nous vous souhaitons beaucoup de succès.')
            ->salutation('L\'équipe de la plateforme touristique');
    }
}