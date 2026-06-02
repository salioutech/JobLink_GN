<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom', 'description', 'icone', 'pour_tuteur'];

    // Scope catégories générales (accueil, recherche, offres)
    public function scopeGenerales($query)
    {
        return $query->where('pour_tuteur', false);
    }

    // Scope catégories tuteur uniquement
    public function scopePourTuteur($query)
    {
        return $query->where('pour_tuteur', true);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}