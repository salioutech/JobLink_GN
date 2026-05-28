@extends('layouts.app')
@section('title', 'Mes favoris')

@section('content')
<div style="display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px 12px;display:flex;flex-direction:column;gap:4px;">
        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid #E2E8F0;">
            <div style="width:52px;height:52px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#0D2137;margin:0 auto 8px;border:3px solid #1A9B5A;">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}
            </div>
            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ Auth::user()->profile->nom ?? '' }}</div>
            <div style="font-size:11px;color:#5a6a7a;">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🏠 Tableau de bord</a>
        <a href="{{ route('profil.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">👤 Mon profil</a>
        <a href="{{ route('favori.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">🔖 Mes favoris</a>
        <a href="{{ route('search') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🔍 Explorer</a>
        <div style="margin-top:auto;padding-top:16px;border-top:1px solid #E2E8F0;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#c0392b;background:transparent;border:none;cursor:pointer;width:100%;">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- CONTENU --}}
    <div style="padding:28px;background:#F4F6F9;overflow-y:auto;">

        <div style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">
            <a href="{{ route('dashboard') }}" style="color:#1A4B7A;">Tableau de bord</a> ›
            <span style="color:#0D2137;font-weight:600;">Mes favoris</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">🔖 Mes favoris</h1>
                <p style="font-size:13px;color:#5a6a7a;">{{ $favoris->total() }} publication(s) sauvegardée(s)</p>
            </div>
            <a href="{{ route('search') }}"
                style="background:#1A9B5A;color:#fff;padding:10px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">
                🔍 Explorer
            </a>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- FILTRES --}}
        <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            @foreach(['tous' => 'Tous', 'service' => '🛠️ Services', 'offre' => '💼 Offres'] as $val => $label)
                <a href="{{ request()->fullUrlWithQuery(['type' => $val]) }}"
                    style="padding:7px 16px;border-radius:20px;font-size:13px;font-weight:600;text-decoration:none;
                    border:1.5px solid {{ request('type', 'tous') === $val ? '#0D2137' : '#E2E8F0' }};
                    background:{{ request('type', 'tous') === $val ? '#0D2137' : '#fff' }};
                    color:{{ request('type', 'tous') === $val ? '#fff' : '#5a6a7a' }};">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- LISTE --}}
        @if($favoris->count() > 0)
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
                @foreach($favoris as $favori)
                    @php $item = $favori->favorable; @endphp
                    @if($item)
                        @php
                            $isService = class_basename($favori->favorable_type) === 'Service';
                            $url = $isService ? route('service.show', $item->id) : route('offre.show', $item->id);
                            $prix = $isService
                                ? ($item->tarif ? number_format($item->tarif, 0, ',', ' ').' GNF' : 'À négocier')
                                : ($item->budget ? number_format($item->budget, 0, ',', ' ').' GNF' : 'À négocier');
                        @endphp
                        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;overflow:hidden;border-top:3px solid {{ $isService ? '#1A4B7A' : '#1A9B5A' }};">

                            {{-- EN-TÊTE --}}
                            <div style="padding:16px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                                    <span style="background:{{ $isService ? '#E8F0F9' : '#E6F7EE' }};color:{{ $isService ? '#1A4B7A' : '#0A6B3A' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                        {{ $isService ? '🛠️ Service' : '💼 Offre' }}
                                    </span>
                                    <span style="font-size:11px;color:#5a6a7a;">
                                        Ajouté {{ $favori->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <a href="{{ $url }}" style="text-decoration:none;">
                                    <div style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:6px;line-height:1.4;">
                                        {{ $item->titre }}
                                    </div>
                                </a>

                                @if($isService && $item->user?->profile)
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                        <div style="width:28px;height:28px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#0D2137;flex-shrink:0;">
                                            {{ strtoupper(substr($item->user->profile->nom ?? 'U', 0, 1)) }}
                                        </div>
                                        <div style="font-size:12px;color:#5a6a7a;">
                                            {{ $item->user->profile->nom ?? '' }} · 📍 {{ $item->user->profile->localisation ?? 'Conakry' }}
                                        </div>
                                    </div>
                                @elseif(!$isService && $item->user?->profile)
                                    <div style="font-size:12px;color:#5a6a7a;margin-bottom:8px;">
                                        🏢 {{ $item->user->profile->nom ?? '' }} · 📍 {{ $item->user->profile->localisation ?? 'Conakry' }}
                                    </div>
                                @endif

                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:14px;font-weight:700;color:#1A9B5A;">{{ $prix }}</span>
                                    @if($item->categorie)
                                        <span style="background:#F4F6F9;color:#5a6a7a;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                            {{ $item->categorie->nom }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- ACTIONS --}}
                            <div style="border-top:1px solid #E2E8F0;padding:12px 16px;display:flex;gap:8px;background:#F4F6F9;">
                                <a href="{{ $url }}"
                                    style="flex:1;text-align:center;background:#1A4B7A;color:#fff;padding:8px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">
                                    👁 Voir
                                </a>
                                <form method="POST" action="{{ route('favori.toggle') }}" style="flex:1;">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ strtolower(class_basename($favori->favorable_type)) }}">
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button type="submit" onclick="return confirm('Retirer des favoris ?')"
                                        style="width:100%;background:#fdecea;color:#c0392b;border:1px solid #f5c6c6;padding:8px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                        🗑 Retirer
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endif
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div style="margin-top:24px;">
                {{ $favoris->withQueryString()->links() }}
            </div>

        @else
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:48px;text-align:center;color:#5a6a7a;">
                <div style="font-size:48px;margin-bottom:16px;">🔖</div>
                <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucun favori sauvegardé</div>
                <div style="font-size:14px;margin-bottom:20px;">Parcourez les services et offres et sauvegardez ceux qui vous intéressent.</div>
                <a href="{{ route('search') }}"
                    style="background:#1A9B5A;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                    Explorer les publications
                </a>
            </div>
        @endif

    </div>
</div>
@endsection