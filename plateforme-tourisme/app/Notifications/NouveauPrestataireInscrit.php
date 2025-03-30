<?php

namespace App\Notifications;

use App\Models\Prestataire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauPrestataireInscrit extends Notification implements ShouldQueue
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
            ->subject('Nouveau prestataire inscrit')
            ->greeting('Bonjour')
            ->line('Un nouveau prestataire vient de s\'inscrire sur la plateforme.')
            ->line('Nom de l\'entreprise : ' . $this->prestataire->nom_entreprise)
            ->line('Téléphone : ' . $this->prestataire->telephone)
            ->line('Email : ' . $this->prestataire->email)
            ->action('Voir les détails dans l\'administration', url('/admin/prestataire/' . $this->prestataire->id . '/show'))
            ->line('Vous pouvez examiner cette demande dans le panneau d\'administration.')
            ->salutation('La plateforme touristique');
    }
}