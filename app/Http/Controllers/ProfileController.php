<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfilDetail;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Profil public — visible par tous
    public function show($id)
    {
        $profile = Profile::with(['user.services.categorie', 'detail'])
                    ->where('user_id', $id)
                    ->firstOrFail();

        return view('profil.show', compact('profile'));
    }

    // Formulaire d'édition
    public function edit()
    {
        $user    = Auth::user()->load('profile.detail');
        $profile = $user->profile;
        $detail  = $profile?->detail;

        return view('profil.edit', compact('user', 'profile', 'detail'));
    }

    // Enregistrer les modifications
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->only([
            'nom', 'prenom', 'telephone', 'localisation', 'bio'
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile?->photo) {
                Storage::disk('public')->delete($user->profile->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Mettre à jour ou créer le profil
        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // Champs spécifiques offreurs
        if ($user->isOffreur()) {
            $detailData = [
                'competences'   => $request->competences,
                'tarif'         => $request->tarif,
                'disponibilite' => $request->boolean('disponibilite'),
                'portfolio_url' => $request->portfolio_url,
            ];

            // Upload portfolio PDF
            if ($request->hasFile('portfolio_fichier')) {
                $detailData['portfolio_fichier'] = $request->file('portfolio_fichier')
                    ->store('portfolios', 'public');
            }

            ProfilDetail::updateOrCreate(
                ['profile_id' => $profile->id],
                $detailData
            );
        }

        // Champs spécifiques entreprise
        if ($user->role === 'entreprise') {
            $profile->update([
                'secteur_activite' => $request->secteur_activite,
                'taille_structure' => $request->taille_structure,
                'site_web'         => $request->site_web,
            ]);
        }

        // Recalculer le taux de complétion
        $this->updateCompletionRate($profile, $user);

        return redirect()->route('profil.edit')
               ->with('success', 'Profil mis à jour avec succès !');
    }

    private function updateCompletionRate(Profile $profile, $user)
    {
        $champs  = ['nom', 'photo', 'telephone', 'localisation', 'bio'];
        $remplis = 0;

        foreach ($champs as $champ) {
            if (!empty($profile->$champ)) $remplis++;
        }

        if ($user->isOffreur() && $profile->detail) {
            if (!empty($profile->detail->competences)) $remplis++;
            if (!empty($profile->detail->tarif))       $remplis++;
            $total = 7;
        } else {
            $total = 5;
        }

        $profile->update([
            'completion_rate' => round(($remplis / $total) * 100)
        ]);
    }
}