<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $fillable = [
        'offreur_id', 'offre_id', 'message', 'statut'
    ];

    public function offreur()
    {
        return $this->belongsTo(User::class, 'offreur_id');
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
}