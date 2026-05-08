<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Offre;

class OffrePolicy
{
    // Modifier une offre — seulement le propriétaire
    public function update(User $user, Offre $offre): bool
    {
        return $user->id === $offre->user_id;
    }

    // Supprimer une offre — seulement le propriétaire
    public function delete(User $user, Offre $offre): bool
    {
        return $user->id === $offre->user_id;
    }

    // Voir une offre — tout le monde
    public function view(?User $user, Offre $offre): bool
    {
        return $offre->statut === 'active';
    }

    // Clôturer une offre — seulement le propriétaire
    public function cloturer(User $user, Offre $offre): bool
    {
        return $user->id === $offre->user_id;
    }
}