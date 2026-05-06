<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSignalementRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Tout utilisateur connecté peut signaler
        return true;
    }

    public function rules(): array
    {
        return [
            'cible_type' => 'required|in:user,service,offre',
            'cible_id'   => [
                'required',
                'integer',
                // Vérifier que la cible existe selon son type
                function ($attribute, $value, $fail) {
                    $type = $this->input('cible_type');
                    $existe = match($type) {
                        'user'    => \App\Models\User::find($value),
                        'service' => \App\Models\Service::find($value),
                        'offre'   => \App\Models\Offre::find($value),
                        default   => null,
                    };
                    if (!$existe) {
                        $fail('L\'élément signalé n\'existe pas.');
                    }
                    // Ne pas se signaler soi-même
                    if ($type === 'user' && $value == $this->user()->id) {
                        $fail('Vous ne pouvez pas vous signaler vous-même.');
                    }
                },
            ],
            'motif' => 'required|string|min:10|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'cible_type.required' => 'Le type d\'élément signalé est obligatoire.',
            'cible_type.in'       => 'Le type doit être : user, service ou offre.',
            'cible_id.required'   => 'L\'élément à signaler est obligatoire.',
            'cible_id.integer'    => 'L\'identifiant de l\'élément est invalide.',
            'motif.required'      => 'Le motif du signalement est obligatoire.',
            'motif.min'           => 'Le motif doit contenir au moins 10 caractères.',
            'motif.max'           => 'Le motif ne peut pas dépasser 500 caractères.',
        ];
    }
}