<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfilDetail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom'            => 'required_unless:role,entreprise|nullable|string|max:100',
            'prenom'         => 'nullable|string|max:100',
            'raison_sociale' => 'required_if:role,entreprise|nullable|string|max:200',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
            'role'           => 'required|in:freelance,artisan,tuteur,entreprise,particulier',
            'telephone'      => 'nullable|string|max:20',
            'commune'        => 'nullable|string|max:100',
        ]);

        // 1. Créer le compte utilisateur
        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'statut'   => 'actif',
        ]);

        // 2. Créer le profil — nom = raison sociale pour entreprise
        $profile = Profile::create([
            'user_id'         => $user->id,
            'nom'             => $request->role === 'entreprise'
                                    ? $request->raison_sociale
                                    : $request->nom,
            'prenom'          => $request->role === 'entreprise'
                                    ? null
                                    : $request->prenom,
            'telephone'       => $request->telephone,
            'localisation'    => $request->commune,
            'completion_rate' => 30,
        ]);

        // 3. Champs spécifiques Freelance / Artisan / Tuteur
        if (in_array($request->role, ['freelance', 'artisan', 'tuteur'])) {
            ProfilDetail::create([
                'profile_id'   => $profile->id,
                'competences'  => $request->competences,
                'tarif'        => $request->tarif,
                'devise'       => 'GNF',
                'disponibilite'=> $request->disponibilite ?? true,
            ]);
        }

        // 4. Champs spécifiques Entreprise
        if ($request->role === 'entreprise') {
            $profile->update([
                'secteur_activite' => $request->secteur_activite,
                'taille_structure' => $request->taille_structure,
                'site_web'         => $request->site_web,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}