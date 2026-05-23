<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\DemandeContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Mail;

// =======================================
// ROUTES PUBLIQUES SANS PARAMÈTRES
// =======================================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/profils/{id}', [ProfileController::class, 'show'])->name('profil.show');

// =======================================
// ROUTES AUTH (gérées par Breeze)
// =======================================

require __DIR__.'/auth.php';

// =======================================
// ROUTES UTILISATEUR CONNECTÉ
// =======================================

Route::middleware(['auth', 'check.statut'])->group(function () {

    // Dashboard — redirige selon le rôle
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');

    // ---- OFFREURS (freelance, artisan, tuteur) ----
    Route::middleware('role:offreur')->group(function () {

        // Services
        Route::get('/services/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
        Route::put('/services/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

        // Mes candidatures envoyées
        Route::get('/mes-candidatures', [CandidatureController::class, 'index'])->name('candidature.index');
        Route::post('/candidatures', [CandidatureController::class, 'store'])->name('candidature.store');
        Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidature.destroy');

        // Demandes de contact reçues
        Route::get('/mes-demandes', [DemandeContactController::class, 'index'])->name('demande.index');
        Route::put('/demandes/{id}', [DemandeContactController::class, 'update'])->name('demande.update');

    });

    // ---- DEMANDEURS (entreprise, particulier) ----
    Route::middleware('role:demandeur')->group(function () {

        // Offres
        Route::get('/offres/create', [OffreController::class, 'create'])->name('offre.create');
        Route::post('/offres', [OffreController::class, 'store'])->name('offre.store');
        Route::get('/offres/{id}/edit', [OffreController::class, 'edit'])->name('offre.edit');
        Route::put('/offres/{id}', [OffreController::class, 'update'])->name('offre.update');
        Route::delete('/offres/{id}', [OffreController::class, 'destroy'])->name('offre.destroy');

        // Candidatures reçues
        Route::get('/candidatures-recues', [CandidatureController::class, 'received'])->name('candidature.received');
        Route::put('/candidatures/{id}', [CandidatureController::class, 'update'])->name('candidature.update');

        // Demandes de contact envoyées
        Route::post('/demandes', [DemandeContactController::class, 'store'])->name('demande.store');
        Route::get('/mes-demandes-envoyees', [DemandeContactController::class, 'sent'])->name('demande.sent');

    });

    // Signalement (tous les utilisateurs connectés)
    Route::post('/signalements', [App\Http\Controllers\SignalementController::class, 'store'])->name('signalement.store');

});

// =======================================
// ROUTES ADMINISTRATION
// =======================================

Route::middleware(['auth', 'check.statut', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Utilisateurs
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{id}/suspend', [AdminController::class, 'suspend'])->name('users.suspend');
        Route::put('/users/{id}/activer', [AdminController::class, 'activer'])->name('users.activer');
        Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

        // Publications
        Route::delete('/services/{id}', [AdminController::class, 'deleteService'])->name('services.delete');
        Route::delete('/offres/{id}', [AdminController::class, 'deleteOffre'])->name('offres.delete');

        // Signalements
        Route::get('/signalements', [AdminController::class, 'signalements'])->name('signalements');
        Route::put('/signalements/{id}', [AdminController::class, 'traiterSignalement'])->name('signalements.traiter');

        // Statistiques
        Route::get('/stats', [AdminController::class, 'stats'])->name('stats');

    });

// =======================================
// ROUTES PUBLIQUES AVEC PARAMÈTRES
// (définies en dernier pour éviter les conflits)
// =======================================

Route::get('/services/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/offres/{id}', [OffreController::class, 'show'])->name('offre.show');

Route::get('/test-mail', function () 
{

    Mail::raw('Ceci est un test Laravel', function ($message) {

        $message->to('salioumsd37@gmail.com')
                ->subject('Test Laravel');

    });

    return 'Mail envoyé';
});