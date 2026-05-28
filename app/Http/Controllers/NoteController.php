<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Service;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:service,offre',
            'id'     => 'required|integer',
            'valeur' => 'required|integer|min:1|max:5',
        ]);

        $model = $request->type === 'service'
            ? Service::findOrFail($request->id)
            : Offre::findOrFail($request->id);

        // Ne pas noter sa propre publication
        if ($model->user_id === Auth::id()) {
            return back()->withErrors(['note' => 'Vous ne pouvez pas noter votre propre publication.']);
        }

        // Mettre à jour ou créer la note
        Note::updateOrCreate(
            [
                'user_id'       => Auth::id(),
                'noteable_type' => get_class($model),
                'noteable_id'   => $model->id,
            ],
            ['valeur' => $request->valeur]
        );

        return back()->with('success', 'Note enregistrée !');
    }
}