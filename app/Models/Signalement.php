<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
     public $timestamps = false; // ← ajouter ceci
    protected $fillable = [
        'signaleur_id',
        'cible_type',
        'cible_id',
        'motif',
        'statut',
    ];

    protected $casts = [
        'created_at' => 'datetime', // ← ajouter ceci
        'updated_at' => 'datetime',
    ];

    public function signaleur()
    {
        return $this->belongsTo(User::class, 'signaleur_id');
    }
}