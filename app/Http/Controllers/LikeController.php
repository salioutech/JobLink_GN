<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Service;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'type' => 'required|in:service,offre',
            'id'   => 'required|integer',
        ]);

        $model = $request->type === 'service'
            ? Service::findOrFail($request->id)
            : Offre::findOrFail($request->id);

        $like = Like::where('user_id', Auth::id())
            ->where('likeable_type', get_class($model))
            ->where('likeable_id', $model->id)
            ->first();

        if ($like) {
            // Déjà liké — on retire le like
            $like->delete();
            $liked = false;
        } else {
            // Pas encore liké — on ajoute
            Like::create([
                'user_id'       => Auth::id(),
                'likeable_type' => get_class($model),
                'likeable_id'   => $model->id,
            ]);
            $liked = true;
        }

        $count = $model->likes()->count();

        if ($request->expectsJson()) {
            return response()->json(['liked' => $liked, 'count' => $count]);
        }

        return back()->with('success', $liked ? 'Publication likée !' : 'Like retiré.');
    }
}