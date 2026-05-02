<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDetail extends Model
{
    protected $fillable = [
        'profile_id', 'competences', 'tarif', 'devise',
        'disponibilite', 'portfolio_url', 'portfolio_fichier'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}