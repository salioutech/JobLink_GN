{{-- resources/views/dashboard/freelance.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard Freelance')
@section('content')
<div style="padding:32px;max-width:900px;margin:0 auto;">
    <h1 style="font-size:22px;font-weight:700;color:#0D2137;margin-bottom:8px;">
        Bonjour, {{ $user->profile->prenom ?? $user->profile->nom }} 👋
    </h1>
    <p style="color:#5a6a7a;">Tableau de bord Freelance — En cours de développement</p>
</div>
@endsection