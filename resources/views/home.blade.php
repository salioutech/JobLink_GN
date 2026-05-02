@extends('layouts.app')
@section('title', 'Accueil')
@section('content')
<div style="background:linear-gradient(135deg,#0D2137,#1A4B7A);padding:60px 28px;text-align:center;">
    <h1 style="color:#fff;font-size:32px;font-weight:700;margin-bottom:14px;">
        Connecter les talents, créer des opportunités
    </h1>
    <p style="color:#B5C8D8;font-size:16px;margin-bottom:32px;">
        La première plateforme guinéenne de mise en relation professionnelle
    </p>
    <div style="display:flex;gap:16px;justify-content:center;">
        <a href="{{ route('register') }}" style="background:#F0A500;color:#0D2137;padding:13px 28px;border-radius:8px;font-size:14px;font-weight:700;">
            S'inscrire gratuitement
        </a>
        <a href="{{ route('search') }}" style="background:transparent;color:#fff;border:2px solid #fff;padding:12px 28px;border-radius:8px;font-size:14px;font-weight:600;">
            Rechercher un prestataire
        </a>
    </div>
</div>
@endsection