<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Candidature;

class StoreCandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Seuls les offreurs peuvent postuler
        return $this->user()->isOffreur();
    }

    public function rules(): array
    {
        return [
            'offre_id' => [
                'required',
                'exists:offres,id',
                // Vérifier qu'il n'a pas déjà postulé
                function ($attribute, $value, $fail) {
                    $existe = Candidature::where('offreur_id', $this->user()->id)
                                ->where('offre_id', $value)
                                ->exists();
                    if ($existe) {
                        $fail('Vous avez déjà postulé à cette offre.');
                    }
                },
            ],
            'message' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'offre_id.required' => 'L\'offre est obligatoire.',
            'offre_id.exists'   => 'Cette offre n\'existe pas ou a été supprimée.',
            'message.max'       => 'Le message ne peut pas dépasser 1000 caractères.',
        ];
    }
}