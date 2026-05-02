<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Offre;
use App\Models\Candidature;
use App\Models\Signalement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users'        => User::count(),
            'services'     => Service::where('statut', 'actif')->count(),
            'offres'       => Offre::where('statut', 'active')->count(),
            'candidatures' => Candidature::count(),
            'signalements' => Signalement::where('statut', 'en_attente')->count(),
            'par_role'     => User::selectRaw('role, count(*) as total')
                                ->groupBy('role')->pluck('total', 'role'),
        ];

        $signalements = Signalement::with('signaleur.profile')
                            ->where('statut', 'en_attente')
                            ->latest()
                            ->take(5)
                            ->get();

        $derniers_users = User::with('profile')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'signalements', 'derniers_users'));
    }

    public function users(Request $request)
    {
        $query = User::with('profile')->whereNot('role', 'admin');

        if ($request->filled('role'))
            $query->where('role', $request->role);

        if ($request->filled('q'))
            $query->whereHas('profile', fn($q) =>
                $q->where('nom', 'LIKE', '%'.$request->q.'%')
            );

        $users = $query->latest()->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function suspend($id)
    {
        User::findOrFail($id)->update(['statut' => 'suspendu']);
        return back()->with('success', 'Compte suspendu.');
    }

    public function activer($id)
    {
        User::findOrFail($id)->update(['statut' => 'actif']);
        return back()->with('success', 'Compte réactivé.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete(); // SoftDelete
        return back()->with('success', 'Compte supprimé.');
    }

    public function deleteService($id)
    {
        Service::findOrFail($id)->delete();
        return back()->with('success', 'Service supprimé.');
    }

    public function deleteOffre($id)
    {
        Offre::findOrFail($id)->delete();
        return back()->with('success', 'Offre supprimée.');
    }

    public function signalements()
    {
        $signalements = Signalement::with('signaleur.profile')
                            ->latest()
                            ->paginate(15);

        return view('admin.signalements', compact('signalements'));
    }

    public function traiterSignalement(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:traite,ignore',
        ]);

        Signalement::findOrFail($id)->update(['statut' => $request->statut]);

        return back()->with('success', 'Signalement traité.');
    }

    public function stats()
    {
        $stats = [
            'users_par_role' => User::selectRaw('role, count(*) as total')
                                    ->groupBy('role')->pluck('total', 'role'),
            'services_par_statut' => Service::selectRaw('statut, count(*) as total')
                                        ->groupBy('statut')->pluck('total', 'statut'),
            'offres_par_statut' => Offre::selectRaw('statut, count(*) as total')
                                        ->groupBy('statut')->pluck('total', 'statut'),
            'candidatures_par_statut' => Candidature::selectRaw('statut, count(*) as total')
                                            ->groupBy('statut')->pluck('total', 'statut'),
        ];

        return view('admin.stats', compact('stats'));
    }
}