<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom', 'description', 'icone'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}