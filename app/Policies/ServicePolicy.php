<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;

class ServicePolicy
{
    // Modifier un service — seulement le propriétaire
    public function update(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }

    // Supprimer un service — seulement le propriétaire
    public function delete(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }

    // Voir un service — tout le monde
    public function view(?User $user, Service $service): bool
    {
        return $service->statut === 'actif';
    }
}