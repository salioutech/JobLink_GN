@extends('layouts.app')
@section('title', 'Mes candidatures')

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
        <a href="{{ route('service.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🛠️ Mes services</a>
        <a href="{{ route('candidature.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">📩 Mes candidatures</a>
        <a href="{{ route('demande.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🤝 Demandes reçues</a>
        <a href="{{ route('search', ['tab' => 'offres']) }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🔍 Rechercher des offres</a>
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
            <span style="color:#0D2137;font-weight:600;">Mes candidatures</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Mes candidatures</h1>
                <p style="font-size:13px;color:#5a6a7a;">Suivez l'état de toutes vos candidatures</p>
            </div>
            <a href="{{ route('search', ['tab' => 'offres']) }}"
                style="background:#1A9B5A;color:#fff;padding:10px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">
                🔍 Chercher des offres
            </a>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- STATS --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #1A4B7A;">
                <div style="font-size:24px;font-weight:700;color:#0D2137;">{{ $candidatures->total() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Total</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #F0A500;">
                <div style="font-size:24px;font-weight:700;color:#F0A500;">{{ $candidatures->where('statut','en_attente')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">En attente</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #1A9B5A;">
                <div style="font-size:24px;font-weight:700;color:#1A9B5A;">{{ $candidatures->where('statut','acceptee')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Acceptées</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #c0392b;">
                <div style="font-size:24px;font-weight:700;color:#c0392b;">{{ $candidatures->where('statut','refusee')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Refusées</div>
            </div>
        </div>

        {{-- FILTRES --}}
        <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            @foreach(['tous' => 'Toutes', 'en_attente' => '⏳ En attente', 'acceptee' => '✓ Acceptées', 'refusee' => '✗ Refusées'] as $val => $label)
                <a href="{{ request()->fullUrlWithQuery(['statut' => $val]) }}"
                    style="padding:7px 16px;border-radius:20px;font-size:13px;font-weight:600;text-decoration:none;
                    border:1.5px solid {{ request('statut', 'tous') === $val ? '#0D2137' : '#E2E8F0' }};
                    background:{{ request('statut', 'tous') === $val ? '#0D2137' : '#fff' }};
                    color:{{ request('statut', 'tous') === $val ? '#fff' : '#5a6a7a' }};">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- LISTE --}}
        @if($candidatures->count() > 0)
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($candidatures as $candidature)
                    <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-left:4px solid
                        {{ $candidature->statut === 'acceptee' ? '#1A9B5A' : ($candidature->statut === 'refusee' ? '#c0392b' : '#F0A500') }};">

                        <div style="display:flex;align-items:flex-start;gap:16px;">
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap;">
                                    <h3 style="font-size:15px;font-weight:700;color:#0D2137;">
                                        {{ $candidature->offre?->titre ?? 'Offre supprimée' }}
                                    </h3>
                                    <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                        background:{{ $candidature->statut === 'acceptee' ? '#E6F7EE' : ($candidature->statut === 'refusee' ? '#fdecea' : '#FEF3DC') }};
                                        color:{{ $candidature->statut === 'acceptee' ? '#0A6B3A' : ($candidature->statut === 'refusee' ? '#c0392b' : '#7A4500') }};">
                                        {{ $candidature->statut === 'acceptee' ? '✓ Acceptée' : ($candidature->statut === 'refusee' ? '✗ Refusée' : '⏳ En attente') }}
                                    </span>
                                </div>

                                <div style="display:flex;align-items:center;gap:16px;margin-bottom:10px;flex-wrap:wrap;">
                                    <span style="font-size:13px;color:#5a6a7a;">
                                        🏢 {{ $candidature->offre?->user?->profile?->nom ?? 'Recruteur' }}
                                    </span>
                                    <span style="font-size:13px;color:#5a6a7a;">
                                        💼 {{ ucfirst(str_replace('_',' ',$candidature->offre?->type ?? '')) }}
                                    </span>
                                    <span style="font-size:13px;font-weight:700;color:#1A9B5A;">
                                        {{ $candidature->offre?->budget ? number_format($candidature->offre->budget, 0, ',', ' ').' GNF' : 'À négocier' }}
                                    </span>
                                </div>

                                @if($candidature->message)
                                    <div style="background:#F4F6F9;border-radius:8px;padding:12px;margin-bottom:10px;border-left:3px solid #E2E8F0;">
                                        <div style="font-size:11px;color:#5a6a7a;margin-bottom:4px;font-weight:600;">Mon message :</div>
                                        <div style="font-size:13px;color:#444;line-height:1.6;">{{ Str::limit($candidature->message, 120) }}</div>
                                    </div>
                                @endif

                                <div style="display:flex;align-items:center;gap:16px;">
                                    <span style="font-size:12px;color:#5a6a7a;">📅 {{ $candidature->created_at->diffForHumans() }}</span>
                                    @if($candidature->statut !== 'en_attente')
                                        <span style="font-size:12px;color:{{ $candidature->statut === 'acceptee' ? '#1A9B5A' : '#c0392b' }};font-weight:600;">
                                            {{ $candidature->statut === 'acceptee' ? '✓ Réponse reçue' : '✗ Réponse reçue' }}
                                        </span>
                                    @else
                                        <span style="font-size:12px;color:#F0A500;font-weight:600;">⏳ En attente de réponse</span>
                                    @endif
                                </div>
                            </div>

                            <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0;">
                                @if($candidature->offre)
                                    <a href="{{ route('offre.show', $candidature->offre_id) }}"
                                        style="background:#E8F0F9;color:#1A4B7A;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;text-align:center;">
                                        👁 Voir l'offre
                                    </a>
                                @endif
                                @if($candidature->statut === 'en_attente')
                                    <form method="POST" action="{{ route('candidature.destroy', $candidature->id) }}" onsubmit="return confirm('Retirer cette candidature ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            style="background:#fdecea;color:#c0392b;border:1px solid #f5c6c6;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;width:100%;">
                                            ✕ Retirer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div style="margin-top:24px;">
                {{ $candidatures->withQueryString()->links() }}
            </div>

        @else
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:48px;text-align:center;color:#5a6a7a;">
                <div style="font-size:48px;margin-bottom:16px;">📩</div>
                <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucune candidature</div>
                <div style="font-size:14px;margin-bottom:20px;">Vous n'avez pas encore postulé à des offres.</div>
                <a href="{{ route('search', ['tab' => 'offres']) }}"
                    style="background:#1A4B7A;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                    Voir les offres disponibles
                </a>
            </div>
        @endif

    </div>
</div>
@endsection