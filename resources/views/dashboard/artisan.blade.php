@extends('layouts.app')
@section('title', 'Dashboard Artisan')

@section('content')
<div style="display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px 12px;display:flex;flex-direction:column;gap:4px;">
        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid #E2E8F0;">
            <div style="width:52px;height:52px;border-radius:50%;background:#1A9B5A;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;margin:0 auto 8px;border:3px solid #F0A500;">
                {{ strtoupper(substr($user->profile->nom ?? 'U', 0, 1)) }}
            </div>
            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ $user->profile->nom ?? '' }} {{ $user->profile->prenom ?? '' }}</div>
            <div style="font-size:11px;color:#5a6a7a;margin-bottom:8px;">Artisan · {{ $user->profile->localisation ?? 'Conakry' }}</div>
            <div style="font-size:11px;color:#5a6a7a;margin-bottom:4px;">Profil complété à <strong style="color:#F0A500;">{{ $user->profile->completion_rate ?? 0 }}%</strong></div>
            <div style="height:6px;background:#E2E8F0;border-radius:4px;overflow:hidden;">
                <div style="width:{{ $user->profile->completion_rate ?? 0 }}%;height:100%;background:#F0A500;border-radius:4px;"></div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">🏠 Tableau de bord</a>
        <a href="{{ route('profil.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">👤 Mon profil</a>
        <a href="{{ route('service.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🔧 Mes services</a>
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
    <div style="padding:24px;background:#F4F6F9;overflow-y:auto;">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">
                    Bonjour, {{ $user->profile->prenom ?? $user->profile->nom }} 👋
                </h1>
                <p style="font-size:13px;color:#5a6a7a;">Gérez vos services et vos demandes de contact</p>
            </div>
            <a href="{{ route('service.create') }}"
                style="background:#0D2137;color:#fff;padding:10px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">
                + Publier un service
            </a>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- STATS --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:24px;">
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #1A9B5A;">
                <div style="font-size:28px;font-weight:700;color:#0D2137;">{{ $services->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Services publiés</div>
                <div style="font-size:11px;color:#1A9B5A;margin-top:2px;">{{ $services->where('statut','actif')->count() }} actifs</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #F0A500;">
                <div style="font-size:28px;font-weight:700;color:#F0A500;">{{ $demandes->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Demandes reçues</div>
                <div style="font-size:11px;color:#F0A500;margin-top:2px;">{{ $demandes->where('statut','en_attente')->count() }} en attente</div>
            </div>
        </div>

        {{-- MES SERVICES --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;margin-bottom:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h2 style="font-size:15px;font-weight:700;color:#0D2137;">Mes services</h2>
                <a href="{{ route('service.create') }}" style="font-size:12px;color:#1A9B5A;font-weight:600;text-decoration:none;">+ Nouveau</a>
            </div>
            @if($services->count() > 0)
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($services as $service)
                        <div style="background:#F4F6F9;border-radius:8px;padding:14px;border-left:3px solid {{ $service->statut === 'actif' ? '#1A9B5A' : '#ccc' }};">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ $service->titre }}</div>
                                <span style="background:{{ $service->statut === 'actif' ? '#E6F7EE' : '#f0f0f0' }};color:{{ $service->statut === 'actif' ? '#0A6B3A' : '#888' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                    {{ $service->statut === 'actif' ? '✓ Actif' : '⏸ Suspendu' }}
                                </span>
                            </div>
                            <div style="font-size:12px;color:#5a6a7a;margin-bottom:8px;">
                                {{ $service->categorie->nom ?? '' }} ·
                                {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' GNF' : 'À négocier' }}
                            </div>
                            <div style="display:flex;gap:8px;">
                                <a href="{{ route('service.edit', $service->id) }}"
                                    style="font-size:11px;padding:5px 12px;border-radius:6px;border:1px solid #E2E8F0;background:#fff;color:#1A4B7A;text-decoration:none;font-weight:600;">
                                    ✏️ Modifier
                                </a>
                                <form method="POST" action="{{ route('service.destroy', $service->id) }}" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="font-size:11px;padding:5px 12px;border-radius:6px;border:1px solid #fcc;background:#fff;color:#c0392b;cursor:pointer;">🗑</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:32px;color:#5a6a7a;">
                    <div style="font-size:32px;margin-bottom:10px;">🔧</div>
                    <div style="font-size:14px;font-weight:600;margin-bottom:6px;">Aucun service publié</div>
                    <a href="{{ route('service.create') }}" style="background:#1A9B5A;color:#fff;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">+ Publier un service</a>
                </div>
            @endif
        </div>

        {{-- DEMANDES REÇUES --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h2 style="font-size:15px;font-weight:700;color:#0D2137;">Demandes de contact reçues</h2>
                <a href="{{ route('demande.index') }}" style="font-size:12px;color:#1A9B5A;font-weight:600;text-decoration:none;">Voir tout →</a>
            </div>
            @if($demandes->count() > 0)
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($demandes->take(3) as $demande)
                        <div style="background:#F4F6F9;border-radius:8px;padding:14px;border-left:3px solid {{ $demande->statut === 'en_attente' ? '#F0A500' : ($demande->statut === 'acceptee' ? '#1A9B5A' : '#ccc') }};">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                <div style="font-size:13px;font-weight:700;color:#0D2137;">
                                    {{ $demande->demandeur->profile->nom ?? 'Utilisateur' }}
                                    {{ $demande->demandeur->profile->prenom ?? '' }}
                                </div>
                                <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                    background:{{ $demande->statut === 'acceptee' ? '#E6F7EE' : ($demande->statut === 'refusee' ? '#fdecea' : '#FEF3DC') }};
                                    color:{{ $demande->statut === 'acceptee' ? '#0A6B3A' : ($demande->statut === 'refusee' ? '#c0392b' : '#7A4500') }};">
                                    {{ $demande->statut === 'acceptee' ? '✓ Acceptée' : ($demande->statut === 'refusee' ? '✗ Refusée' : '⏳ En attente') }}
                                </span>
                            </div>
                            <div style="font-size:12px;color:#5a6a7a;margin-bottom:8px;">
                                {{ Str::limit($demande->message, 80) ?? 'Aucun message' }} · {{ $demande->created_at->diffForHumans() }}
                            </div>
                            @if($demande->statut === 'en_attente')
                                <div style="display:flex;gap:8px;">
                                    <form method="POST" action="{{ route('demande.update', $demande->id) }}">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="statut" value="acceptee">
                                        <button type="submit" style="font-size:11px;padding:5px 12px;border-radius:6px;border:none;background:#1A9B5A;color:#fff;cursor:pointer;font-weight:700;">✓ Accepter</button>
                                    </form>
                                    <form method="POST" action="{{ route('demande.update', $demande->id) }}">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="statut" value="refusee">
                                        <button type="submit" style="font-size:11px;padding:5px 12px;border-radius:6px;border:1px solid #fcc;background:#fff;color:#c0392b;cursor:pointer;">✗ Refuser</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:24px;color:#5a6a7a;">
                    <div style="font-size:13px;">Aucune demande de contact reçue pour le moment.</div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection