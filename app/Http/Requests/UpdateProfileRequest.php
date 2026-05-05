<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Tout utilisateur connecté peut modifier son profil
    }

    public function rules(): array
    {
        return [
            'nom'          => 'required|string|max:100',
            'prenom'       => 'nullable|string|max:100',
            'telephone'    => 'nullable|string|max:20',
            'localisation' => 'nullable|string|max:150',
            'bio'          => 'nullable|string|max:300',
            'photo'        => 'nullable|image|mimes:jpeg,png|max:2048',
            // Offreurs
            'competences'  => 'nullable|string|max:500',
            'tarif'        => 'nullable|numeric|min:0',
            'disponibilite'=> 'nullable|boolean',
            'portfolio_url'=> 'nullable|url|max:255',
            'portfolio_fichier' => 'nullable|file|mimes:pdf|max:5120',
            // Entreprise
            'secteur_activite'  => 'nullable|string|max:150',
            'taille_structure'  => 'nullable|string|max:100',
            'site_web'          => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'       => 'Le nom est obligatoire.',
            'nom.max'            => 'Le nom ne peut pas dépasser 100 caractères.',
            'bio.max'            => 'La biographie ne peut pas dépasser 300 caractères.',
            'photo.image'        => 'Le fichier doit être une image.',
            'photo.mimes'        => 'La photo doit être au format JPEG ou PNG.',
            'photo.max'          => 'La photo ne doit pas dépasser 2 Mo.',
            'tarif.numeric'      => 'Le tarif doit être un nombre.',
            'tarif.min'          => 'Le tarif ne peut pas être négatif.',
            'portfolio_url.url'  => 'L\'URL du portfolio n\'est pas valide.',
            'portfolio_fichier.mimes' => 'Le portfolio doit être un fichier PDF.',
            'portfolio_fichier.max'   => 'Le portfolio ne doit pas dépasser 5 Mo.',
            'site_web.url'       => 'L\'URL du site web n\'est pas valide.',
        ];
    }
}