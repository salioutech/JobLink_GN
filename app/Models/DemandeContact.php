<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeContact extends Model
{
    protected $fillable = [
        'demandeur_id', 'offreur_id', 'message', 'statut'
    ];

    public function demandeur()
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function offreur()
    {
        return $this->belongsTo(User::class, 'offreur_id');
    }
}