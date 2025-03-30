<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RapportRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'type' => 'required|in:hebdomadaire,mensuel',
            'periode_debut' => 'required|date',
            'periode_fin' => 'required|date|after:periode_debut',
            'chemin_fichier' => 'required|string',
            'prestataire_id' => 'nullable|exists:prestataires,id',
        ];
    }
}