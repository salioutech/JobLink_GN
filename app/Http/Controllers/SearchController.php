<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Offre;
use App\Models\Categorie;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categorie::generales()->get();
        $tab        = $request->get('tab', 'services');
        $categories = \App\Models\Categorie::generales()->get();

        // --- Recherche Services ---
        $queryServices = Service::with(['user.profile', 'categorie'])
            ->where('statut', 'actif');

        // Mot-clé
        if ($request->filled('q'))
            $queryServices->where('titre', 'LIKE', '%'.$request->q.'%');

        // Catégorie
        if ($request->filled('categorie'))
            $queryServices->where('categorie_id', $request->categorie);

        // Localisation
        if ($request->filled('localisation'))
            $queryServices->whereHas('user.profile', fn($q) =>
                $q->where('localisation', 'LIKE', '%'.$request->localisation.'%')
            );

        // Disponibilité
        if ($request->filled('dispo'))
            $queryServices->whereHas('user.profile.detail', fn($q) =>
                $q->where('disponibilite', true)
            );

        // Tarif min
        if ($request->filled('tarif_min'))
            $queryServices->whereHas('user.profile.detail', fn($q) =>
                $q->where('tarif', '>=', $request->tarif_min)
            );

        // Tarif max
        if ($request->filled('tarif_max'))
            $queryServices->whereHas('user.profile.detail', fn($q) =>
                $q->where('tarif', '<=', $request->tarif_max)
            );

        // Tri
        if ($request->sort === 'tarif_asc')
            $queryServices->join('profil_details', function($join) {
                $join->on('profil_details.profile_id', '=',
                    \DB::raw('(SELECT id FROM profiles WHERE profiles.user_id = services.user_id LIMIT 1)'));
            })->orderBy('profil_details.tarif', 'asc')->select('services.*');
        elseif ($request->sort === 'tarif_desc')
            $queryServices->join('profil_details', function($join) {
                $join->on('profil_details.profile_id', '=',
                    \DB::raw('(SELECT id FROM profiles WHERE profiles.user_id = services.user_id LIMIT 1)'));
            })->orderBy('profil_details.tarif', 'desc')->select('services.*');
        else
            $queryServices->latest();

        $services = $queryServices->paginate(9)->withQueryString();

        // --- Recherche Offres ---
        $queryOffres = Offre::with(['user.profile', 'categorie'])
            ->where('statut', 'active');

        // Mot-clé
        if ($request->filled('q'))
            $queryOffres->where('titre', 'LIKE', '%'.$request->q.'%');

        // Catégorie
        if ($request->filled('categorie'))
            $queryOffres->where('categorie_id', $request->categorie);

        // Type d'offre (emploi, mission, demande_service)
        if ($request->filled('type_offre'))
            $queryOffres->whereIn('type', $request->type_offre);

        // Localisation
        if ($request->filled('localisation'))
            $queryOffres->whereHas('user.profile', fn($q) =>
                $q->where('localisation', 'LIKE', '%'.$request->localisation.'%')
            );

        // Budget min
        if ($request->filled('tarif_min'))
            $queryOffres->where('budget', '>=', $request->tarif_min);

        // Budget max
        if ($request->filled('tarif_max'))
            $queryOffres->where('budget', '<=', $request->tarif_max);

        // Tri
        if ($request->sort === 'tarif_asc')
            $queryOffres->orderBy('budget', 'asc');
        elseif ($request->sort === 'tarif_desc')
            $queryOffres->orderBy('budget', 'desc');
        else
            $queryOffres->latest();

        $offres = $queryOffres->paginate(9)->withQueryString();

        return view('search.index', compact('services', 'offres', 'categories', 'tab'));
    }
}