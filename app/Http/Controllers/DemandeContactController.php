<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreDemandeContactRequest;
use App\Models\DemandeContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeContactController extends Controller
{
    // Demandes reçues (offreur)
    public function index()
    {
        $demandes = Auth::user()
            ->demandesRecues()
            ->with('demandeur.profile')
            ->latest()
            ->paginate(10);

        $demandesEnvoyees = Auth::user()
            ->demandesEnvoyees()
            ->with('offreur.profile')
            ->latest()
            ->paginate(10);

        return view('demandes.index', compact('demandes', 'demandesEnvoyees'));
    }

    // Demandes envoyées (demandeur)
    public function sent()
    {
        $demandes = Auth::user()
            ->demandesEnvoyees()
            ->with('offreur.profile')
            ->latest()
            ->paginate(10);

        return view('demandes.sent', compact('demandes'));
    }

    // Envoyer une demande de contact
    public function store(Request $request)
    {
        $request->validate([
            'offreur_id' => 'required|exists:users,id',
            'message'    => 'nullable|string|max:1000',
        ]);

        // Pas de double demande
        $existe = DemandeContact::where('demandeur_id', Auth::id())
                    ->where('offreur_id', $request->offreur_id)
                    ->exists();

        if ($existe) {
            return back()->withErrors(['offreur_id' => 'Vous avez déjà contacté ce prestataire.']);
        }

        DemandeContact::create([
        'demandeur_id' => Auth::id(),
        'offreur_id'   => $request->offreur_id,
        'message'      => $request->message,
        'statut'       => 'en_attente',
    ]);

    return back()->with('success', 'Demande de contact envoyée !');
    }

    // Accepter ou refuser (offreur)
    public function update(Request $request, $id)
    {
        $demande = DemandeContact::where('offreur_id', Auth::id())->findOrFail($id);

        $request->validate([
            'statut' => 'required|in:acceptee,refusee',
        ]);

        $demande->update(['statut' => $request->statut]);

        return back()->with('success', 'Demande mise à jour.');
    }
}