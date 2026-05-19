@extends('layouts.app')
@section('title', $offre->titre)

@section('content')

{{-- FIL D'ARIANE --}}
<div style="background:#fff;padding:12px 28px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#5a6a7a;">
    <a href="{{ route('home') }}" style="color:#1A4B7A;">Accueil</a> ›
    <a href="{{ route('search', ['tab' => 'offres']) }}" style="color:#1A4B7A;">Offres</a> ›
    <span style="color:#0D2137;font-weight:600;">{{ $offre->titre }}</span>
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
                        {{ ucfirst(str_replace('_',' ',$offre->type)) }}
                    </span>
                    <span style="background:{{ $offre->statut === 'active' ? '#E6F7EE' : '#f0f0f0' }};color:{{ $offre->statut === 'active' ? '#0A6B3A' : '#888' }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                        {{ $offre->statut === 'active' ? '✓ Active' : '🔒 Clôturée' }}
                    </span>
                    <span style="font-size:12px;color:#5a6a7a;">{{ $offre->created_at->diffForHumans() }}</span>
                </div>

                <h1 style="font-size:22px;font-weight:700;color:#0D2137;margin-bottom:12px;">{{ $offre->titre }}</h1>

                <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:38px;height:38px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;">
                            {{ strtoupper(substr($offre->user->profile->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#0D2137;">{{ $offre->user->profile->nom ?? '' }}</div>
                            <div style="font-size:12px;color:#5a6a7a;">{{ ucfirst($offre->user->role) }}</div>
                        </div>
                    </div>
                    <span style="font-size:13px;color:#5a6a7a;">📍 {{ $offre->user->profile->localisation ?? 'Conakry' }}</span>
                    <span style="font-size:13px;color:#5a6a7a;">💼 {{ $offre->categorie->nom ?? '' }}</span>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Description</h2>
                <p style="font-size:14px;color:#444;line-height:1.8;">{{ $offre->description }}</p>
            </div>

            {{-- COMPÉTENCES REQUISES --}}
            @if($offre->competences_requises)
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Compétences requises</h2>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @foreach(explode(',', $offre->competences_requises) as $comp)
                            <span style="background:#E8F0F9;color:#1A4B7A;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                                {{ trim($comp) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- COLONNE DROITE --}}
        <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:84px;">

            {{-- CARTE POSTULER --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-top:4px solid #1A9B5A;">
                <h3 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">Détails de l'offre</h3>

                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:16px;">
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#5a6a7a;">Budget</span>
                        <span style="font-weight:700;color:#1A9B5A;">
                            {{ $offre->budget ? number_format($offre->budget, 0, ',', ' ').' GNF' : 'À négocier' }}
                        </span>
                    </div>
                    @if($offre->duree)
                        <div style="display:flex;justify-content:space-between;font-size:13px;">
                            <span style="color:#5a6a7a;">Durée</span>
                            <span style="font-weight:600;color:#0D2137;">{{ $offre->duree }}</span>
                        </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#5a6a7a;">Candidatures</span>
                        <span style="font-weight:600;color:#0D2137;">{{ $offre->candidatures->count() }} reçues</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#5a6a7a;">Publiée</span>
                        <span style="font-weight:600;color:#0D2137;">{{ $offre->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                @auth
                    @if(Auth::user()->isOffreur() && $offre->statut === 'active')
                        <form method="POST" action="{{ route('candidature.store') }}">
                            @csrf
                            <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                            <div style="margin-bottom:12px;">
                                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                                    Message de motivation <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                                </label>
                                <textarea name="message" rows="3" maxlength="1000"
                                    placeholder="Présentez-vous brièvement..."
                                    style="width:100%;padding:10px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;outline:none;resize:vertical;"></textarea>
                            </div>
                            @if($errors->any())
                                <div style="background:#fdecea;border-radius:6px;padding:8px 12px;margin-bottom:10px;font-size:12px;color:#c0392b;">
                                    @foreach($errors->all() as $error)
                                        <div>⚠ {{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            @if(session('success'))
                                <div style="background:#E6F7EE;border-radius:6px;padding:8px 12px;margin-bottom:10px;font-size:12px;color:#0A6B3A;">
                                    ✓ {{ session('success') }}
                                </div>
                            @endif
                            <button type="submit"
                                style="width:100%;background:#1A9B5A;color:#fff;border:none;padding:13px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                                🚀 Postuler à cette offre
                            </button>
                        </form>
                    @elseif($offre->statut === 'cloturee')
                        <div style="background:#f0f0f0;border-radius:8px;padding:14px;text-align:center;font-size:13px;color:#888;font-weight:600;">
                            🔒 Cette offre est clôturée
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                        🔒 Se connecter pour postuler
                    </a>
                    <p style="text-align:center;font-size:12px;color:#5a6a7a;margin-top:10px;">
                        Pas de compte ? <a href="{{ route('register') }}" style="color:#1A9B5A;font-weight:700;">S'inscrire →</a>
                    </p>
                @endauth
            </div>

            {{-- SIGNALEMENT --}}
            @auth
                @if(Auth::id() !== $offre->user_id)
                    <div style="background:#F4F6F9;border:1.5px dashed #E2E8F0;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:12px;color:#5a6a7a;margin-bottom:8px;">Cette offre vous semble inappropriée ?</div>
                        <form method="POST" action="{{ route('signalement.store') }}">
                            @csrf
                            <input type="hidden" name="cible_type" value="offre">
                            <input type="hidden" name="cible_id" value="{{ $offre->id }}">
                            <input type="hidden" name="motif" value="Offre signalée depuis la page de détail">
                            <button type="submit"
                                style="background:transparent;color:#c0392b;border:1.5px solid #c0392b;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                🚩 Signaler cette offre
                            </button>
                        </form>
                    </div>
                @endif
            @endauth

        </div>
    </div>
</div>

@endsection