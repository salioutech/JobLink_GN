<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Categorie;
use App\Http\Requests\StoreServiceRequest;
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

    public function store(StoreServiceRequest $request)
    {
        // Si tuteur → créer ou trouver la catégorie par nom
        if (Auth::user()->role === 'tuteur') {
            $categorie = Categorie::firstOrCreate(['nom' => $request->categorie_id]);
            $categorie_id = $categorie->id;
        } else {
            $categorie_id = $request->categorie_id;
        }

        Service::create([
            'user_id'      => Auth::id(),
            'titre'        => $request->titre,
            'description'  => $request->description,
            'categorie_id' => $categorie_id,
            'tarif'        => $request->tarif,
            'devise'       => 'GNF',
            'statut'       => $request->statut,
        ]);

        return redirect()->route('dashboard')
               ->with('success', Auth::user()->role === 'tuteur' ? 'Cours publié avec succès !' : 'Service publié avec succès !');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->authorize('update', $service);
        $categories = Categorie::all();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(StoreServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $this->authorize('update', $service);

        // Si tuteur → créer ou trouver la catégorie par nom
        if (Auth::user()->role === 'tuteur') {
            $categorie = Categorie::firstOrCreate(['nom' => $request->categorie_id]);
            $service->update(array_merge($request->validated(), ['categorie_id' => $categorie->id]));
        } else {
            $service->update($request->validated());
        }

        return redirect()->route('dashboard')
            ->with('success', Auth::user()->role === 'tuteur' ? 'Cours modifié avec succès !' : 'Service modifié avec succès !');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $this->authorize('delete', $service);
        $service->delete();

        return redirect()->route('dashboard')
            ->with('success', Auth::user()->role === 'tuteur' ? 'Cours supprimé.' : 'Service supprimé.');
    }
}