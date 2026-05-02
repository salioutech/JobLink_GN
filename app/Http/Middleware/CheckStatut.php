<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStatut
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->statut !== 'actif') {
            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'compte' => 'Votre compte a été suspendu. Contactez l\'administrateur.'
                ]);
        }

        return $next($request);
    }
}