<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DemandeContact;

class StoreDemandeContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Tout utilisateur connecté peut envoyer une demande de contact
        return true;
    }

    public function rules(): array
    {
        return [
            'offreur_id' => [
                'required',
                'exists:users,id',
                // Ne pas contacter soi-même
                function ($attribute, $value, $fail) {
                    if ($value == $this->user()->id) {
                        $fail('Vous ne pouvez pas vous contacter vous-même.');
                    }
                },
                // Vérifier qu'il n'a pas déjà envoyé une demande
                function ($attribute, $value, $fail) {
                    $existe = DemandeContact::where('demandeur_id', $this->user()->id)
                                ->where('offreur_id', $value)
                                ->exists();
                    if ($existe) {
                        $fail('Vous avez déjà contacté ce prestataire.');
                    }
                },
            ],
            'message' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'offreur_id.required' => 'Le prestataire est obligatoire.',
            'offreur_id.exists'   => 'Ce prestataire n\'existe pas.',
            'message.max'         => 'Le message ne peut pas dépasser 1000 caractères.',
        ];
    }
}