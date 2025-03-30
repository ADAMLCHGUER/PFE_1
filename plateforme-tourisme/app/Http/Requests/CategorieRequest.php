<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'nom' => 'required|min:2|max:255',
            'slug' => 'nullable|unique:categories,slug,' . $this->id,
            'icone' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }
}