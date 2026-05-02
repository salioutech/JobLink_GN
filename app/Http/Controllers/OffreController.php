<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    public function show($id)
    {
        $offre = Offre::with(['user.profile', 'categorie', 'candidatures'])->findOrFail($id);
        return view('offres.show', compact('offre'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('offres.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:200',
            'description' => 'required|string|min:50',
            'type'        => 'required|in:emploi,mission,demande_service',
            'categorie_id'=> 'required|exists:categories,id',
            'budget'      => 'nullable|numeric|min:0',
            'duree'       => 'nullable|string|max:100',
            'statut'      => 'required|in:active,cloturee',
        ]);

        Offre::create([
            'user_id'              => Auth::id(),
            'titre'                => $request->titre,
            'description'          => $request->description,
            'type'                 => $request->type,
            'categorie_id'         => $request->categorie_id,
            'budget'               => $request->budget,
            'devise'               => 'GNF',
            'duree'                => $request->duree,
            'competences_requises' => $request->competences_requises,
            'statut'               => $request->statut,
        ]);

        return redirect()->route('dashboard')
               ->with('success', 'Offre publiée avec succès !');
    }

    public function edit($id)
    {
        $offre      = Offre::where('user_id', Auth::id())->findOrFail($id);
        $categories = Categorie::all();
        return view('offres.edit', compact('offre', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $offre = Offre::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'titre'       => 'required|string|max:200',
            'description' => 'required|string|min:50',
            'type'        => 'required|in:emploi,mission,demande_service',
            'categorie_id'=> 'required|exists:categories,id',
            'budget'      => 'nullable|numeric|min:0',
            'statut'      => 'required|in:active,cloturee',
        ]);

        $offre->update($request->only([
            'titre', 'description', 'type',
            'categorie_id', 'budget', 'duree',
            'competences_requises', 'statut'
        ]));

        return redirect()->route('dashboard')
               ->with('success', 'Offre modifiée avec succès !');
    }

    public function destroy($id)
    {
        $offre = Offre::where('user_id', Auth::id())->findOrFail($id);
        $offre->delete(); // SoftDelete
        return redirect()->route('dashboard')
               ->with('success', 'Offre supprimée.');
    }
}