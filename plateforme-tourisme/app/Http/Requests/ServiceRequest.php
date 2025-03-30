<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'titre' => 'required|min:3|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'description' => 'required|string',
            'prestations' => 'required|string',
            'coordonnees' => 'nullable|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
            'site_web' => 'nullable|url',
            'horaires' => 'nullable|array',
        ];
    }
}