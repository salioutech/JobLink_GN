<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Offre;
use App\Models\Categorie;

class HomeController extends Controller
{
    public function index()
    {
        $services   = Service::with(['user.profile', 'categorie'])
                        ->where('statut', 'actif')
                        ->latest()
                        ->take(3)
                        ->get();

        $offres     = Offre::with(['user.profile', 'categorie'])
                        ->where('statut', 'active')
                        ->latest()
                        ->take(3)
                        ->get();

        $categories = Categorie::generales()->get();

        $categories    = \App\Models\Categorie::generales()->get();
    $services      = \App\Models\Service::with(['user.profile','categorie'])->where('statut','actif')->latest()->take(6)->get();
    $offres        = \App\Models\Offre::with(['user.profile'])->where('statut','actif')->latest()->take(6)->get();
    $totalServices = \App\Models\Service::where('statut','actif')->count();
    $totalOffres   = \App\Models\Offre::where('statut','actif')->count();
    $totalUsers    = \App\Models\User::where('statut','actif')->count();

    return view('home', compact('categories','services','offres','totalServices','totalOffres','totalUsers'));
    }
}
