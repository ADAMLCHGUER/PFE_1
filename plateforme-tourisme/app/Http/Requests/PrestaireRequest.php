<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestataire;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;    

class PrestaireRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'nom_entreprise' => 'required|min:3|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'statut' => 'required|in:en_revision,valide,non_valide',
        ];
    }
}