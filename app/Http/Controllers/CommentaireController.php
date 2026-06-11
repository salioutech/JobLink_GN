<?php

namespace App\Http\Controllers;


use App\Models\Commentaire;
use App\Models\Service;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'    => 'required|in:service,offre',
            'id'      => 'required|integer',
            'contenu' => 'required|string|min:3|max:500',
        ]);

        $model = $request->type === 'service'
            ? Service::findOrFail($request->id)
            : Offre::findOrFail($request->id);

        Commentaire::create([
            'user_id'          => Auth::id(),
            'commentable_type' => get_class($model),
            'commentable_id'   => $model->id,
            'contenu'          => $request->contenu,
        ]);

        return back()->with('success', 'Commentaire ajouté !');
    }

    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);

        // Seul l'auteur peut supprimer son commentaire
        if ($commentaire->user_id !== Auth::id()) {
            abort(403);
        }

        $commentaire->delete();

        return back()->with('success', 'Commentaire supprimé.');
    }
}

