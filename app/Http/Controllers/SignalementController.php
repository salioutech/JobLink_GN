<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignalementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cible_type' => 'required|in:user,service,offre',
            'cible_id'   => 'required|integer',
            'motif'      => 'required|string|max:500',
        ]);

        Signalement::create([
            'signaleur_id' => Auth::id(),
            'cible_type'   => $request->cible_type,
            'cible_id'     => $request->cible_id,
            'motif'        => $request->motif,
            'statut'       => 'en_attente',
        ]);

        return back()->with('success', 'Signalement envoyé à l\'administrateur.');
    }
}