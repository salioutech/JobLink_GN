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
        Service::create([
            'user_id'      => Auth::id(),
            'titre'        => $request->titre,
            'description'  => $request->description,
            'categorie_id' => $request->categorie_id,
            'tarif'        => $request->tarif,
            'devise'       => 'GNF',
            'statut'       => $request->statut,
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

    public function update(StoreServiceRequest $request, $id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        $service->update($request->validated());

        return redirect()->route('dashboard')
               ->with('success', 'Service modifié avec succès !');
    }

    public function destroy($id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        $service->delete();

        return redirect()->route('dashboard')
               ->with('success', 'Service supprimé.');
    }
}