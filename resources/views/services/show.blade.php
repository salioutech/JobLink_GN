@extends('layouts.app')
@section('title', $service->titre)

@section('content')

{{-- FIL D'ARIANE --}}
<div style="background:#fff;padding:12px 28px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#5a6a7a;">
    <a href="{{ route('home') }}" style="color:#1A4B7A;">Accueil</a> ›
    <a href="{{ route('search') }}" style="color:#1A4B7A;">Services</a> ›
    <span style="color:#0D2137;font-weight:600;">{{ $service->titre }}</span>
</div>

{{-- CONTENU --}}
<div style="max-width:900px;margin:28px auto;padding:0 28px;">
    <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">

        {{-- COLONNE GAUCHE --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- EN-TÊTE --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;border-top:4px solid #1A4B7A;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap;">
                    <span style="background:#E8F0F9;color:#1A4B7A;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                        {{ $service->categorie->nom ?? '' }}
                    </span>
                    <span style="background:{{ $service->statut === 'actif' ? '#E6F7EE' : '#f0f0f0' }};color:{{ $service->statut === 'actif' ? '#0A6B3A' : '#888' }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                        {{ $service->statut === 'actif' ? '✓ Disponible' : '⏸ Indisponible' }}
                    </span>
                    <span style="font-size:12px;color:#5a6a7a;">{{ $service->created_at->diffForHumans() }}</span>
                </div>

                <h1 style="font-size:22px;font-weight:700;color:#0D2137;margin-bottom:16px;">{{ $service->titre }}</h1>

                <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                    <a href="{{ route('profil.show', $service->user_id) }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
                        <div style="width:38px;height:38px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#0D2137;">
                            {{ strtoupper(substr($service->user->profile->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#0D2137;">{{ $service->user->profile->nom ?? '' }} {{ $service->user->profile->prenom ?? '' }}</div>
                            <div style="font-size:12px;color:#5a6a7a;">{{ ucfirst($service->user->role) }}</div>
                        </div>
                    </a>
                    <span style="font-size:13px;color:#5a6a7a;">📍 {{ $service->user->profile->localisation ?? 'Conakry' }}</span>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Description du service</h2>
                <p style="font-size:14px;color:#444;line-height:1.8;">{{ $service->description }}</p>
            </div>

        </div>

        {{-- COLONNE DROITE --}}
        <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:84px;">

            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-top:4px solid #1A9B5A;">
                <h3 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">Tarif & Contact</h3>

                <div style="margin-bottom:16px;">
                    <div style="font-size:24px;font-weight:700;color:#1A9B5A;margin-bottom:4px;">
                        {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' GNF' : 'À négocier' }}
                    </div>
                    <div style="font-size:12px;color:#5a6a7a;">Tarif indicatif</div>
                </div>

                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:16px;">

                @auth
                    @if(Auth::id() !== $service->user_id)
                        <a href="{{ route('profil.show', $service->user_id) }}"
                            style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;margin-bottom:10px;">
                            ✉ Contacter le prestataire
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                        🔒 Se connecter pour contacter
                    </a>
                @endauth
            </div>

        </div>
    </div>
</div>

@endsection