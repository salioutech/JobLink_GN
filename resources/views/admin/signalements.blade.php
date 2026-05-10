@extends('layouts.app')
@section('title', 'Signalements')

@section('content')
<div style="display:grid;grid-template-columns:230px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR SOMBRE --}}
    <div style="background:#0D2137;padding:16px 10px;display:flex;flex-direction:column;gap:2px;">
        <div style="text-align:center;padding:16px 8px;margin-bottom:12px;border-bottom:1px solid rgba(255,255,255,0.1);">
            <div style="width:48px;height:48px;border-radius:50%;background:#c0392b;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;margin:0 auto 8px;">AD</div>
            <div style="font-size:13px;font-weight:700;color:#fff;">Administrateur</div>
            <div style="display:inline-block;background:#c0392b;color:#fff;font-size:10px;font-weight:700;padding:2px 10px;border-radius:4px;margin-top:4px;">ADMIN</div>
        </div>
        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;">Navigation</div>
        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.7);text-decoration:none;">📊 Tableau de bord</a>
        <a href="{{ route('admin.users') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.7);text-decoration:none;">👥 Utilisateurs</a>
        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Modération</div>
        <a href="{{ route('admin.signalements') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:700;background:rgba(255,255,255,0.15);color:#fff;text-decoration:none;">🚩 Signalements</a>
        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Gestion</div>
        <a href="{{ route('admin.stats') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.7);text-decoration:none;">📈 Statistiques</a>
        <div style="margin-top:auto;padding-top:16px;border-top:1px solid rgba(255,255,255,0.1);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:#f88;background:transparent;border:none;cursor:pointer;width:100%;">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- CONTENU --}}
    <div style="padding:24px;background:#F4F6F9;overflow-y:auto;">

        <div style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">
            <a href="{{ route('admin.dashboard') }}" style="color:#1A4B7A;">Administration</a> ›
            <span style="color:#0D2137;font-weight:600;">Signalements</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Gestion des signalements</h1>
                <p style="font-size:13px;color:#5a6a7a;">{{ $signalements->total() }} signalement(s) au total</p>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- FILTRES --}}
        <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            @foreach(['tous' => 'Tous', 'en_attente' => '⏳ En attente', 'traite' => '✓ Traités', 'ignore' => '✗ Ignorés'] as $val => $label)
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
        @if($signalements->count() > 0)
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($signalements as $signalement)
                    <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-left:4px solid
                        {{ $signalement->statut === 'en_attente' ? '#c0392b' : ($signalement->statut === 'traite' ? '#1A9B5A' : '#ccc') }};">

                        <div style="display:flex;align-items:flex-start;gap:16px;">
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap;">
                                    <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                        background:{{ $signalement->cible_type === 'user' ? '#fdecea' : ($signalement->cible_type === 'service' ? '#FEF3DC' : '#E8F0F9') }};
                                        color:{{ $signalement->cible_type === 'user' ? '#c0392b' : ($signalement->cible_type === 'service' ? '#7A4500' : '#1A4B7A') }};">
                                        🚩 {{ ucfirst($signalement->cible_type) }}
                                    </span>
                                    <span style="font-size:13px;font-weight:700;color:#0D2137;">
                                        Signalé par : {{ $signalement->signaleur->profile->nom ?? 'Utilisateur' }}
                                        {{ $signalement->signaleur->profile->prenom ?? '' }}
                                    </span>
                                    <span style="font-size:11px;color:#5a6a7a;">
                                        {{ $signalement->created_at->diffForHumans() }}
                                    </span>
                                    <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                        background:{{ $signalement->statut === 'en_attente' ? '#fdecea' : ($signalement->statut === 'traite' ? '#E6F7EE' : '#f0f0f0') }};
                                        color:{{ $signalement->statut === 'en_attente' ? '#c0392b' : ($signalement->statut === 'traite' ? '#0A6B3A' : '#888') }};">
                                        {{ $signalement->statut === 'en_attente' ? '⏳ En attente' : ($signalement->statut === 'traite' ? '✓ Traité' : '✗ Ignoré') }}
                                    </span>
                                </div>

                                <div style="background:#F4F6F9;border-radius:8px;padding:12px;margin-bottom:10px;border-left:3px solid #E2E8F0;font-size:13px;color:#444;line-height:1.6;">
                                    {{ $signalement->motif }}
                                </div>

                                <div style="font-size:12px;color:#5a6a7a;">
                                    ID de la cible : #{{ $signalement->cible_id }}
                                </div>
                            </div>

                            @if($signalement->statut === 'en_attente')
                                <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0;">
                                    <form method="POST" action="{{ route('admin.signalements.traiter', $signalement->id) }}">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="statut" value="traite">
                                        <button type="submit"
                                            style="font-size:12px;padding:8px 16px;border-radius:8px;border:none;background:#c0392b;color:#fff;cursor:pointer;font-weight:700;white-space:nowrap;width:100%;">
                                            ✓ Marquer traité
                                        </button>
                                    </form>
                                    @if($signalement->cible_type === 'user')
                                        <a href="{{ route('profil.show', $signalement->cible_id) }}"
                                            style="font-size:12px;padding:8px 16px;border-radius:8px;border:1px solid #E2E8F0;background:#fff;color:#1A4B7A;text-decoration:none;font-weight:600;text-align:center;white-space:nowrap;">
                                            👁 Voir le profil
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.signalements.traiter', $signalement->id) }}">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="statut" value="ignore">
                                        <button type="submit"
                                            style="font-size:12px;padding:8px 16px;border-radius:8px;border:1px solid #E2E8F0;background:#fff;color:#5a6a7a;cursor:pointer;white-space:nowrap;width:100%;">
                                            ✗ Ignorer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div style="margin-top:24px;">
                {{ $signalements->withQueryString()->links() }}
            </div>

        @else
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:48px;text-align:center;color:#5a6a7a;">
                <div style="font-size:48px;margin-bottom:16px;">✅</div>
                <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucun signalement</div>
                <div style="font-size:14px;">La plateforme est propre !</div>
            </div>
        @endif

    </div>
</div>
@endsection