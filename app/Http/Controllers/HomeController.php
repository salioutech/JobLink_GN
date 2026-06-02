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

        return view('home', compact('services', 'offres', 'categories'));
    }
}
