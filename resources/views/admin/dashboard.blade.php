@extends('layouts.app')
@section('title', 'Administration')

@section('content')
<div style="display:grid;grid-template-columns:230px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR SOMBRE --}}
    <div style="background:#0D2137;padding:16px 10px;display:flex;flex-direction:column;gap:2px;">

        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid rgba(255,255,255,0.1);">
            <div style="width:48px;height:48px;border-radius:50%;background:#c0392b;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;margin:0 auto 8px;">AD</div>
            <div style="font-size:13px;font-weight:700;color:#fff;">Administrateur</div>
            <div style="background:#c0392b;color:#fff;font-size:10px;font-weight:700;padding:2px 10px;border-radius:4px;display:inline-block;margin-top:4px;">ADMIN</div>
        </div>

        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Navigation</div>
        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:700;background:rgba(255,255,255,0.15);color:#fff;text-decoration:none;">📊 Tableau de bord</a>
        <a href="{{ route('admin.users') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;">👥 Utilisateurs</a>

        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Modération</div>
        <a href="{{ route('admin.signalements') }}" style="display:flex;align-items:center;justify-content:space-between;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;">
            <span style="display:flex;align-items:center;gap:10px;">🚩 Signalements</span>
            @if($signalements->count() > 0)
                <span style="background:#c0392b;color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">{{ $signalements->count() }}</span>
            @endif
        </a>

        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Gestion</div>
        <a href="{{ route('admin.stats') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;">📈 Statistiques</a>

        <div style="margin-top:auto;padding-top:16px;border-top:1px solid rgba(255,255,255,0.1);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:#f88;background:transparent;border:none;cursor:pointer;width:100%;">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- CONTENU --}}
    <div style="padding:24px;background:#F4F6F9;overflow-y:auto;">

        {{-- EN-TÊTE --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Tableau de bord — Administration</h1>
                <p style="font-size:13px;color:#5a6a7a;">Vue globale de la plateforme JobLink GN</p>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- ALERTE SIGNALEMENTS --}}
        @if($signalements->count() > 0)
            <div style="background:#fdecea;border:1px solid #f5c6c6;border-left:4px solid #c0392b;border-radius:10px;padding:14px 16px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:20px;">🚨</span>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#c0392b;">{{ $signalements->count() }} signalement(s) en attente de traitement</div>
                        <div style="font-size:12px;color:#7b1c1c;">Des utilisateurs ont signalé des profils ou publications non conformes.</div>
                    </div>
                </div>
                <a href="{{ route('admin.signalements') }}"
                    style="background:#c0392b;color:#fff;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap;">
                    Traiter →
                </a>
            </div>
        @endif

        {{-- STATS --}}
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:24px;">
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #1A4B7A;">
                <div style="font-size:26px;font-weight:700;color:#0D2137;">{{ $stats['users'] }}</div>
                <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Utilisateurs</div>
            </div>
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #1A9B5A;">
                <div style="font-size:26px;font-weight:700;color:#0D2137;">{{ $stats['services'] }}</div>
                <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Services actifs</div>
            </div>
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #F0A500;">
                <div style="font-size:26px;font-weight:700;color:#0D2137;">{{ $stats['offres'] }}</div>
                <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Offres actives</div>
            </div>
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #1A4B7A;">
                <div style="font-size:26px;font-weight:700;color:#0D2137;">{{ $stats['candidatures'] }}</div>
                <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Candidatures</div>
            </div>
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:16px;text-align:center;border-top:3px solid #c0392b;">
                <div style="font-size:26px;font-weight:700;color:#c0392b;">{{ $stats['signalements'] }}</div>
                <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Signalements</div>
            </div>
        </div>

        {{-- GRILLE --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

            {{-- RÉPARTITION PAR RÔLE --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">Utilisateurs par rôle</h2>
                @php
                    $roles = [
                        'freelance'  => ['💻', '#1A4B7A'],
                        'artisan'    => ['🔧', '#1A9B5A'],
                        'tuteur'     => ['🎓', '#F0A500'],
                        'entreprise' => ['🏢', '#0D2137'],
                        'particulier'=> ['👤', '#888'],
                    ];
                    $total_users = $stats['users'] ?: 1;
                @endphp
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($roles as $role => $info)
                        @php $count = $stats['par_role'][$role] ?? 0; @endphp
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span style="font-size:13px;font-weight:600;color:#0D2137;">{{ $info[0] }} {{ ucfirst($role) }}</span>
                                <span style="font-size:13px;font-weight:700;color:#0D2137;">{{ $count }}</span>
                            </div>
                            <div style="height:8px;background:#E2E8F0;border-radius:4px;overflow:hidden;">
                                <div style="width:{{ $total_users > 0 ? round(($count/$total_users)*100) : 0 }}%;height:100%;background:{{ $info[1] }};border-radius:4px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- DERNIÈRES INSCRIPTIONS --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <h2 style="font-size:15px;font-weight:700;color:#0D2137;">Dernières inscriptions</h2>
                    <a href="{{ route('admin.users') }}" style="font-size:12px;color:#1A9B5A;font-weight:600;text-decoration:none;">Voir tout →</a>
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($derniers_users as $u)
                        <div style="display:flex;align-items:center;gap:10px;padding:8px;background:#F4F6F9;border-radius:8px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr($u->profile->nom ?? 'U', 0, 1)) }}
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:13px;font-weight:600;color:#0D2137;">{{ $u->profile->nom ?? 'Utilisateur' }} {{ $u->profile->prenom ?? '' }}</div>
                                <div style="font-size:11px;color:#5a6a7a;">{{ ucfirst($u->role) }} · {{ $u->created_at->diffForHumans() }}</div>
                            </div>
                            <span style="font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px;
                                background:{{ $u->statut === 'actif' ? '#E6F7EE' : '#fdecea' }};
                                color:{{ $u->statut === 'actif' ? '#0A6B3A' : '#c0392b' }};">
                                {{ $u->statut === 'actif' ? '✓ Actif' : '⏸ Suspendu' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SIGNALEMENTS EN ATTENTE --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h2 style="font-size:15px;font-weight:700;color:#0D2137;">Signalements en attente</h2>
                <a href="{{ route('admin.signalements') }}" style="font-size:12px;color:#1A9B5A;font-weight:600;text-decoration:none;">Voir tout →</a>
            </div>

            @if($signalements->count() > 0)
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($signalements as $signalement)
                        <div style="background:#fdecea;border-radius:8px;padding:14px;border-left:4px solid #c0392b;display:flex;align-items:center;gap:14px;">
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
                                    <span style="background:#fdecea;color:#c0392b;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                        🚩 {{ ucfirst($signalement->cible_type) }}
                                    </span>
                                    <span style="font-size:13px;font-weight:700;color:#0D2137;">
                                        Signalé par : {{ $signalement->signaleur->profile->nom ?? 'Utilisateur' }}
                                    </span>
                                    <span style="font-size:11px;color:#5a6a7a;">{{ $signalement->created_at->diffForHumans() }}</span>
                                </div>
                                <div style="font-size:12px;color:#555;background:#fff;padding:8px;border-radius:6px;border:1px solid #f5c6c6;line-height:1.5;">
                                    {{ Str::limit($signalement->motif, 120) }}
                                </div>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:6px;flex-shrink:0;">
                                <form method="POST" action="{{ route('admin.signalements.traiter', $signalement->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="statut" value="traite">
                                    <button type="submit" style="font-size:11px;padding:6px 12px;border-radius:6px;border:none;background:#c0392b;color:#fff;cursor:pointer;font-weight:700;white-space:nowrap;">✓ Traiter</button>
                                </form>
                                <form method="POST" action="{{ route('admin.signalements.traiter', $signalement->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="statut" value="ignore">
                                    <button type="submit" style="font-size:11px;padding:6px 12px;border-radius:6px;border:1px solid #E2E8F0;background:#fff;color:#5a6a7a;cursor:pointer;white-space:nowrap;">✗ Ignorer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:32px;color:#5a6a7a;">
                    <div style="font-size:32px;margin-bottom:10px;">✅</div>
                    <div style="font-size:14px;font-weight:600;">Aucun signalement en attente</div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection