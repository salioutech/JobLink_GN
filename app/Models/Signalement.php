<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    public $timestamps = false; // la table n'a que created_at
    
    protected $fillable = [
        'signaleur_id', 'cible_type', 'cible_id', 'motif', 'statut'
    ];

    public function signaleur()
    {
        return $this->belongsTo(User::class, 'signaleur_id');
    }
}