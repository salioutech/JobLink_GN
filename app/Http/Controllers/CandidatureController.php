<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    // Liste des candidatures envoyées (offreur)
    public function index()
    {
        $candidatures = Auth::user()
            ->candidatures()
            ->with(['offre.user.profile', 'offre.categorie'])
            ->latest()
            ->paginate(10);

        return view('candidatures.index', compact('candidatures'));
    }

    // Liste des candidatures reçues (demandeur)
    public function received()
    {
        $offre_ids    = Auth::user()->offres->pluck('id');
        $candidatures = Candidature::whereIn('offre_id', $offre_ids)
            ->with(['offreur.profile', 'offre'])
            ->latest()
            ->paginate(10);

        return view('candidatures.received', compact('candidatures'));
    }

    // Postuler à une offre
    public function store(Request $request)
    {
        $request->validate([
            'offre_id' => 'required|exists:offres,id',
            'message'  => 'nullable|string|max:1000',
        ]);

        // Vérifier pas de doublon
        $existe = Candidature::where('offreur_id', Auth::id())
                    ->where('offre_id', $request->offre_id)
                    ->exists();

        if ($existe) {
            return back()->withErrors(['offre_id' => 'Vous avez déjà postulé à cette offre.']);
        }

        Candidature::create([
            'offreur_id' => Auth::id(),
            'offre_id'   => $request->offre_id,
            'message'    => $request->message,
            'statut'     => 'en_attente',
        ]);

        return back()->with('success', 'Candidature envoyée avec succès !');
    }

    // Accepter ou refuser (demandeur)
    public function update(Request $request, $id)
    {
        $candidature = Candidature::findOrFail($id);

        // Vérifier que c'est bien l'offre du demandeur connecté
        abort_if($candidature->offre->user_id !== Auth::id(), 403);

        $request->validate([
            'statut' => 'required|in:acceptee,refusee',
        ]);

        $candidature->update(['statut' => $request->statut]);

        return back()->with('success', 'Candidature mise à jour.');
    }

    // Retirer sa candidature (offreur)
    public function destroy($id)
    {
        $candidature = Candidature::where('offreur_id', Auth::id())
                        ->where('statut', 'en_attente')
                        ->findOrFail($id);

        $candidature->delete();

        return back()->with('success', 'Candidature retirée.');
    }
}