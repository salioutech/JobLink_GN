<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        $allowed = match($role) {
            'admin'     => $user->role === 'admin',
            'offreur'   => in_array($user->role, ['consultant', 'artisan', 'tuteur']),
            'demandeur' => in_array($user->role, ['entreprise', 'particulier']),
            default     => false,
        };

        if (!$allowed) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}