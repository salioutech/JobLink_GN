<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $email
 * @property string $role
 * @property string $statut
 * @property \App\Models\Profile $profile
 * @property \Illuminate\Database\Eloquent\Collection $services
 * @property \Illuminate\Database\Eloquent\Collection $offres
 * @property \Illuminate\Database\Eloquent\Collection $candidatures
 * @property \Illuminate\Database\Eloquent\Collection $demandesEnvoyees
 * @property \Illuminate\Database\Eloquent\Collection $demandesRecues
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'email', 'password', 'role', 'statut'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // ---- Relations ----

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'offreur_id');
    }

    public function demandesEnvoyees()
    {
        return $this->hasMany(DemandeContact::class, 'demandeur_id');
    }

    public function demandesRecues()
    {
        return $this->hasMany(DemandeContact::class, 'offreur_id');
    }

    // ---- Helpers rôles ----

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOffreur(): bool
    {
        return $this->role === 'freelance'; // ← artisan et tuteur supprimés
    }

    public function isDemandeur(): bool
    {
        return in_array($this->role, ['entreprise', 'particulier']);
    }
}