<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seuls les demandeurs peuvent publier une offre
        return $this->user()->isDemandeur();
    }

    public function rules(): array
    {
        return [
            'titre'                => 'required|string|max:200',
            'description'          => 'required|string|min:50|max:1000',
            'type'                 => 'required|in:emploi,mission,demande_service',
            'categorie_id'         => 'required|exists:categories,id',
            'budget'               => 'nullable|numeric|min:0',
            'duree'                => 'nullable|string|max:100',
            'competences_requises' => 'nullable|string|max:500',
            'statut'               => 'required|in:active,cloturee',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'        => 'Le titre de l\'offre est obligatoire.',
            'titre.max'             => 'Le titre ne peut pas dépasser 200 caractères.',
            'description.required'  => 'La description est obligatoire.',
            'description.min'       => 'La description doit contenir au moins 50 caractères.',
            'description.max'       => 'La description ne peut pas dépasser 1000 caractères.',
            'type.required'         => 'Le type d\'offre est obligatoire.',
            'type.in'               => 'Le type doit être : emploi, mission ou demande_service.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'categorie_id.exists'   => 'La catégorie sélectionnée est invalide.',
            'budget.numeric'        => 'Le budget doit être un nombre.',
            'budget.min'            => 'Le budget ne peut pas être négatif.',
            'statut.required'       => 'Le statut est obligatoire.',
            'statut.in'             => 'Le statut doit être active ou cloturee.',
        ];
    }
}