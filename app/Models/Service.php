<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'categorie_id', 'titre',
        'description', 'tarif', 'devise', 'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function likes()

{
    return $this->morphMany(Like::class, 'likeable');
}

public function commentaires()
{
    return $this->morphMany(Commentaire::class, 'commentable');
}

public function notes()
{
    return $this->morphMany(Note::class, 'noteable');
}

public function favoris()
{
    return $this->morphMany(Favori::class, 'favorable');
}

}