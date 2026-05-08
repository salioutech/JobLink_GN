@extends('layouts.app')
@section('title', 'Mes demandes de contact')

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
        <a href="{{ route('candidature.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">📩 Mes candidatures</a>
        <a href="{{ route('demande.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">🤝 Demandes de contact</a>
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
            <span style="color:#0D2137;font-weight:600;">Mes demandes de contact</span>
        </div>

        <div style="margin-bottom:24px;">
            <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Mes demandes de contact</h1>
            <p style="font-size:13px;color:#5a6a7a;">Gérez les demandes reçues et envoyées</p>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- STATS --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #1A4B7A;">
                <div style="font-size:24px;font-weight:700;color:#0D2137;">{{ $demandes->total() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Reçues</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #F0A500;">
                <div style="font-size:24px;font-weight:700;color:#F0A500;">{{ $demandes->where('statut','en_attente')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">En attente</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #1A9B5A;">
                <div style="font-size:24px;font-weight:700;color:#1A9B5A;">{{ $demandes->where('statut','acceptee')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Acceptées</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #c0392b;">
                <div style="font-size:24px;font-weight:700;color:#c0392b;">{{ $demandes->where('statut','refusee')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Refusées</div>
            </div>
        </div>

        {{-- ONGLETS --}}
        <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;margin-bottom:20px;overflow:hidden;">
            <div style="display:flex;border-bottom:1px solid #E2E8F0;padding:0 16px;">
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'recues']) }}"
                    style="padding:14px 20px;font-size:14px;font-weight:600;text-decoration:none;
                    color:{{ request('tab', 'recues') === 'recues' ? '#0D2137' : '#5a6a7a' }};
                    border-bottom:{{ request('tab', 'recues') === 'recues' ? '3px solid #1A9B5A' : 'none' }};">
                    📥 Reçues ({{ $demandes->total() }})
                </a>
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'envoyees']) }}"
                    style="padding:14px 20px;font-size:14px;font-weight:600;text-decoration:none;
                    color:{{ request('tab') === 'envoyees' ? '#0D2137' : '#5a6a7a' }};
                    border-bottom:{{ request('tab') === 'envoyees' ? '3px solid #1A9B5A' : 'none' }};">
                    📤 Envoyées ({{ $demandesEnvoyees->total() }})
                </a>
            </div>
        </div>

        {{-- DEMANDES REÇUES --}}
        @if(request('tab', 'recues') === 'recues')
            @if($demandes->count() > 0)
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach($demandes as $demande)
                        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-left:4px solid
                            {{ $demande->statut === 'en_attente' ? '#F0A500' : ($demande->statut === 'acceptee' ? '#1A9B5A' : '#ccc') }};">

                            <div style="display:flex;align-items:flex-start;gap:14px;">
                                <div style="width:46px;height:46px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;flex-shrink:0;">
                                    {{ strtoupper(substr($demande->demandeur->profile->nom ?? 'U', 0, 1)) }}
                                </div>
                                <div style="flex:1;">
                                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                                        <span style="font-size:15px;font-weight:700;color:#0D2137;">
                                            {{ $demande->demandeur->profile->nom ?? 'Utilisateur' }}
                                            {{ $demande->demandeur->profile->prenom ?? '' }}
                                        </span>
                                        <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                            {{ ucfirst($demande->demandeur->role) }}
                                        </span>
                                        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                            background:{{ $demande->statut === 'acceptee' ? '#E6F7EE' : ($demande->statut === 'refusee' ? '#fdecea' : '#FEF3DC') }};
                                            color:{{ $demande->statut === 'acceptee' ? '#0A6B3A' : ($demande->statut === 'refusee' ? '#c0392b' : '#7A4500') }};">
                                            {{ $demande->statut === 'acceptee' ? '✓ Acceptée' : ($demande->statut === 'refusee' ? '✗ Refusée' : '⏳ En attente') }}
                                        </span>
                                    </div>
                                    <div style="font-size:12px;color:#5a6a7a;margin-bottom:10px;">
                                        📍 {{ $demande->demandeur->profile->localisation ?? 'Conakry' }} · {{ $demande->created_at->diffForHumans() }}
                                    </div>
                                    @if($demande->message)
                                        <div style="background:#F4F6F9;border-radius:8px;padding:12px;margin-bottom:12px;border-left:3px solid #E2E8F0;font-size:13px;color:#444;line-height:1.7;">
                                            "{{ $demande->message }}"
                                        </div>
                                    @endif
                                    @if($demande->statut === 'en_attente')
                                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                            <form method="POST" action="{{ route('demande.update', $demande->id) }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="statut" value="acceptee">
                                                <button type="submit" style="background:#1A9B5A;color:#fff;border:none;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">✓ Accepter</button>
                                            </form>
                                            <form method="POST" action="{{ route('demande.update', $demande->id) }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="statut" value="refusee">
                                                <button type="submit" style="background:#fdecea;color:#c0392b;border:1px solid #f5c6c6;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">✗ Refuser</button>
                                            </form>
                                            <a href="{{ route('profil.show', $demande->demandeur_id) }}"
                                                style="background:#E8F0F9;color:#1A4B7A;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                                                👁 Voir le profil
                                            </a>
                                        </div>
                                    @else
                                        <a href="{{ route('profil.show', $demande->demandeur_id) }}"
                                            style="background:#E8F0F9;color:#1A4B7A;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;display:inline-block;">
                                            👁 Voir le profil
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $demandes->withQueryString()->links() }}</div>
            @else
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:48px;text-align:center;color:#5a6a7a;">
                    <div style="font-size:48px;margin-bottom:16px;">📥</div>
                    <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucune demande reçue</div>
                    <div style="font-size:14px;">Complétez votre profil pour être plus visible.</div>
                </div>
            @endif

        {{-- DEMANDES ENVOYÉES --}}
        @else
            @if($demandesEnvoyees->count() > 0)
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach($demandesEnvoyees as $demande)
                        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-left:4px solid
                            {{ $demande->statut === 'en_attente' ? '#F0A500' : ($demande->statut === 'acceptee' ? '#1A9B5A' : '#ccc') }};">

                            <div style="display:flex;align-items:flex-start;gap:14px;">
                                <div style="width:46px;height:46px;border-radius:50%;background:#1A9B5A;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;flex-shrink:0;">
                                    {{ strtoupper(substr($demande->offreur->profile->nom ?? 'U', 0, 1)) }}
                                </div>
                                <div style="flex:1;">
                                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                                        <span style="font-size:15px;font-weight:700;color:#0D2137;">
                                            {{ $demande->offreur->profile->nom ?? 'Prestataire' }}
                                            {{ $demande->offreur->profile->prenom ?? '' }}
                                        </span>
                                        <span style="background:#E6F7EE;color:#0A6B3A;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                            {{ ucfirst($demande->offreur->role) }}
                                        </span>
                                        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                            background:{{ $demande->statut === 'acceptee' ? '#E6F7EE' : ($demande->statut === 'refusee' ? '#fdecea' : '#FEF3DC') }};
                                            color:{{ $demande->statut === 'acceptee' ? '#0A6B3A' : ($demande->statut === 'refusee' ? '#c0392b' : '#7A4500') }};">
                                            {{ $demande->statut === 'acceptee' ? '✓ Acceptée' : ($demande->statut === 'refusee' ? '✗ Refusée' : '⏳ En attente') }}
                                        </span>
                                    </div>
                                    <div style="font-size:12px;color:#5a6a7a;margin-bottom:10px;">
                                        📍 {{ $demande->offreur->profile->localisation ?? 'Conakry' }} · {{ $demande->created_at->diffForHumans() }}
                                    </div>
                                    @if($demande->message)
                                        <div style="background:#F4F6F9;border-radius:8px;padding:12px;margin-bottom:12px;border-left:3px solid #E2E8F0;font-size:13px;color:#444;line-height:1.7;">
                                            "{{ $demande->message }}"
                                        </div>
                                    @endif
                                    <div style="display:flex;gap:8px;">
                                        <a href="{{ route('profil.show', $demande->offreur_id) }}"
                                            style="background:#E8F0F9;color:#1A4B7A;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">
                                            👁 Voir son profil
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $demandesEnvoyees->withQueryString()->links() }}</div>
            @else
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:48px;text-align:center;color:#5a6a7a;">
                    <div style="font-size:48px;margin-bottom:16px;">📤</div>
                    <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucune demande envoyée</div>
                    <div style="font-size:14px;margin-bottom:20px;">Parcourez les profils et contactez des prestataires.</div>
                    <a href="{{ route('search') }}" style="background:#1A9B5A;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                        Rechercher des prestataires
                    </a>
                </div>
            @endif
        @endif

    </div>
</div>
@endsection