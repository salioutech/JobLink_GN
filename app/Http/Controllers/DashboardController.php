<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         /** @var \App\Models\User $user */
        $user = Auth::user()->load('profile');

        return match($user->role) {
            'freelance'  => $this->dashboardFreelance($user),
            'artisan'    => $this->dashboardArtisan($user),
            'tuteur'     => $this->dashboardTuteur($user),
            'entreprise' => $this->dashboardEntreprise($user),
            'particulier'=> $this->dashboardParticulier($user),
            'admin'      => redirect()->route('admin.dashboard'),
            default      => redirect()->route('home'),
        };
    }

    private function dashboardFreelance($user)
    {
        $services      = $user->services()->with('categorie')->latest()->get();
        $candidatures  = $user->candidatures()->with('offre.user.profile')->latest()->get();
        $demandes      = $user->demandesRecues()->with('demandeur.profile')->latest()->get();

        return view('dashboard.freelance', compact('user', 'services', 'candidatures', 'demandes'));
    }

    private function dashboardArtisan($user)
    {
        $services  = $user->services()->with('categorie')->latest()->get();
        $demandes  = $user->demandesRecues()->with('demandeur.profile')->latest()->get();

        return view('dashboard.artisan', compact('user', 'services', 'demandes'));
    }

    private function dashboardTuteur($user)
    {
        $services  = $user->services()->with('categorie')->latest()->get();
        $demandes  = $user->demandesRecues()->with('demandeur.profile')->latest()->get();

        return view('dashboard.tuteur', compact('user', 'services', 'demandes'));
    }

    private function dashboardEntreprise($user)
    {
        $offres       = $user->offres()->with('categorie')->withCount('candidatures')->latest()->get();
        $candidatures = \App\Models\Candidature::whereIn('offre_id', $user->offres->pluck('id'))
                            ->with(['offreur.profile', 'offre'])
                            ->latest()
                            ->get();
        $demandes     = $user->demandesEnvoyees()->with('offreur.profile')->latest()->get();

        return view('dashboard.entreprise', compact('user', 'offres', 'candidatures', 'demandes'));
    }

    private function dashboardParticulier($user)
    {
        $offres       = $user->offres()->with('categorie')->withCount('candidatures')->latest()->get();
        $demandes     = $user->demandesEnvoyees()->with('offreur.profile')->latest()->get();

        return view('dashboard.particulier', compact('user', 'offres', 'demandes'));
    }
}