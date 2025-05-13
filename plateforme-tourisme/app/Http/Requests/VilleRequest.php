<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VilleRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'nom' => 'required|min:2|max:255',
            'slug' => 'nullable|unique:villes,slug,' . $this->id,
            // Change the validation for image field
            'image' => 'nullable|sometimes|image|max:5000',
            'description' => 'nullable|string',
            'populaire' => 'boolean',
        ];
    }
}