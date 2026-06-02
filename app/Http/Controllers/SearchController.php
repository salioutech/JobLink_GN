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
        $categories = Categorie::all();
        $tab        = $request->get('tab', 'services'); // services | offres

        // --- Recherche Services ---
        $queryServices = Service::with(['user.profile', 'categorie'])
            ->where('statut', 'actif')
            ->whereHas('user');

        if ($request->filled('q'))
            $queryServices->where('titre', 'LIKE', '%'.$request->q.'%');

        if ($request->filled('categorie'))
            $queryServices->where('categorie_id', $request->categorie);

        if ($request->filled('localisation'))
            $queryServices->whereHas('user.profile', fn($q) =>
                $q->where('localisation', 'LIKE', '%'.$request->localisation.'%')
            );

        if ($request->filled('dispo'))
            $queryServices->whereHas('user.profile.detail', fn($q) =>
                $q->where('disponibilite', true)
            );

        $services = $queryServices->latest()->paginate(9)->withQueryString();

        // --- Recherche Offres ---
        $queryOffres = Offre::with(['user.profile', 'categorie'])
            ->where('statut', 'active')
            ->whereHas('user');

        if ($request->filled('q'))
            $queryOffres->where('titre', 'LIKE', '%'.$request->q.'%');

        if ($request->filled('categorie'))
            $queryOffres->where('categorie_id', $request->categorie);

        if ($request->filled('type'))
            $queryOffres->where('type', $request->type);

        $offres = $queryOffres->latest()->paginate(9)->withQueryString();

        return view('search.index', compact('services', 'offres', 'categories', 'tab'));
    }
}