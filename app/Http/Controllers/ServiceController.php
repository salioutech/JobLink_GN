<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function show($id)
    {
        $service = Service::with(['user.profile', 'categorie'])->findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:200',
            'description' => 'required|string|min:50',
            'categorie_id'=> 'required|exists:categories,id',
            'tarif'       => 'nullable|numeric|min:0',
            'statut'      => 'required|in:actif,inactif',
        ]);

        Service::create([
            'user_id'     => Auth::id(),
            'titre'       => $request->titre,
            'description' => $request->description,
            'categorie_id'=> $request->categorie_id,
            'tarif'       => $request->tarif,
            'devise'      => 'GNF',
            'statut'      => $request->statut,
        ]);

        return redirect()->route('dashboard')
               ->with('success', 'Service publié avec succès !');
    }

    public function edit($id)
    {
        $service    = Service::where('user_id', Auth::id())->findOrFail($id);
        $categories = Categorie::all();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'titre'       => 'required|string|max:200',
            'description' => 'required|string|min:50',
            'categorie_id'=> 'required|exists:categories,id',
            'tarif'       => 'nullable|numeric|min:0',
            'statut'      => 'required|in:actif,suspendu',
        ]);

        $service->update($request->only([
            'titre', 'description', 'categorie_id', 'tarif', 'statut'
        ]));

        return redirect()->route('dashboard')
               ->with('success', 'Service modifié avec succès !');
    }

    public function destroy($id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        $service->delete(); // SoftDelete
        return redirect()->route('dashboard')
               ->with('success', 'Service supprimé.');
    }
}
