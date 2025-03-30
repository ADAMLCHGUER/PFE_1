<?php

namespace App\Notifications;

use App\Models\Rapport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RapportHebdomadaireDisponible extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rapport;

    public function __construct(Rapport $rapport)
    {
        $this->rapport = $rapport;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $debut = $this->rapport->periode_debut->format('d/m/Y');
        $fin = $this->rapport->periode_fin->format('d/m/Y');

        return (new MailMessage)
            ->subject('Votre rapport hebdomadaire est disponible')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre rapport hebdomadaire pour la période du ' . $debut . ' au ' . $fin . ' est maintenant disponible.')
            ->line('Ce rapport contient des statistiques détaillées sur les visites de votre service, vous aidant à mieux comprendre l\'intérêt des visiteurs.')
            ->action('Consulter mon rapport', route('prestataire.rapports.show', $this->rapport->id))
            ->line('Nous vous invitons à consulter ces données régulièrement pour optimiser votre visibilité.')
            ->salutation('L\'équipe de la plateforme touristique');
    }
}