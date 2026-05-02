<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'nom', 'prenom', 'photo',
        'localisation', 'telephone', 'bio', 'completion_rate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasOne(ProfilDetail::class);
    }
}