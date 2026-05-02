<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfilDetail;
use Illuminate\Http\Request;
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
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom'        => 'required|string|max:100',
            'prenom'     => 'nullable|string|max:100',
            'telephone'  => 'nullable|string|max:20',
            'localisation'=> 'nullable|string|max:150',
            'bio'        => 'nullable|string|max:300',
            'photo'      => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        $data = $request->only(['nom', 'prenom', 'telephone', 'localisation', 'bio']);

        // Upload photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        // Mettre à jour ou créer le profil
        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // Champs spécifiques offreurs
        if ($user->isOffreur()) {
            ProfilDetail::updateOrCreate(
                ['profile_id' => $profile->id],
                [
                    'competences'  => $request->competences,
                    'tarif'        => $request->tarif,
                    'disponibilite'=> $request->has('disponibilite'),
                    'portfolio_url'=> $request->portfolio_url,
                ]
            );
        }

        // Recalculer le taux de complétion
        $this->updateCompletionRate($profile, $user);

        return redirect()->route('profil.edit')
               ->with('success', 'Profil mis à jour avec succès !');
    }

    private function updateCompletionRate(Profile $profile, $user)
    {
        $champs = ['nom', 'photo', 'telephone', 'localisation', 'bio'];
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

        $profile->update(['completion_rate' => round(($remplis / $total) * 100)]);
    }
}
