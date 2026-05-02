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

        $offreurs   = ['freelance', 'artisan', 'tuteur'];
        $demandeurs = ['entreprise', 'particulier'];

        $allowed = match($role) {
            'admin'     => $user->role === 'admin',
            'offreur'   => in_array($user->role, $offreurs),
            'demandeur' => in_array($user->role, $demandeurs),
            default     => false,
        };

        if (!$allowed) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}