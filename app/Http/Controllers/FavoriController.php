<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Service;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
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

        $favori = Favori::where('user_id', Auth::id())
            ->where('favorable_type', get_class($model))
            ->where('favorable_id', $model->id)
            ->first();

        if ($favori) {
            $favori->delete();
            $saved = false;
        } else {
            Favori::create([
                'user_id'        => Auth::id(),
                'favorable_type' => get_class($model),
                'favorable_id'   => $model->id,
            ]);
            $saved = true;
        }

        if ($request->expectsJson()) {
            return response()->json(['saved' => $saved]);
        }

        return back()->with('success', $saved ? 'Ajouté aux favoris !' : 'Retiré des favoris.');
    }

    public function index(Request $request)
    {
        $query = Favori::where('user_id', Auth::id())
            ->with('favorable')
            ->latest();

        // Filtre par type
        if ($request->type && $request->type !== 'tous') {
            $class = $request->type === 'service'
                ? 'App\\Models\\Service'
                : 'App\\Models\\Offre';
            $query->where('favorable_type', $class);
        }

        $favoris = $query->paginate(10);

        return view('favoris.index', compact('favoris'));
    }
}