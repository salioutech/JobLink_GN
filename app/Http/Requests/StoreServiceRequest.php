<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seuls les offreurs peuvent publier un service
        return $this->user()->isOffreur();
    }

    public function rules(): array
    {
        return [
            'titre'        => 'required|string|max:200',
            'description'  => 'required|string|min:50|max:1000',
            'categorie_id' => 'required|exists:categories,id',
            'tarif'        => 'nullable|numeric|min:0',
            'unite_tarif'  => 'nullable|string|max:20',
            'statut'       => 'required|in:actif,inactif',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'        => 'Le titre du service est obligatoire.',
            'titre.max'             => 'Le titre ne peut pas dépasser 200 caractères.',
            'description.required'  => 'La description est obligatoire.',
            'description.min'       => 'La description doit contenir au moins 50 caractères.',
            'description.max'       => 'La description ne peut pas dépasser 1000 caractères.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'categorie_id.exists'   => 'La catégorie sélectionnée est invalide.',
            'tarif.numeric'         => 'Le tarif doit être un nombre.',
            'tarif.min'             => 'Le tarif ne peut pas être négatif.',
            'statut.required'       => 'Le statut est obligatoire.',
            'statut.in'             => 'Le statut doit être actif ou inactif.',
        ];
    }
}