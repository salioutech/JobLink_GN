@extends('layouts.app')
@section('title', 'Statistiques')

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
        <a href="{{ route('admin.signalements') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.7);text-decoration:none;">🚩 Signalements</a>
        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Gestion</div>
        <a href="{{ route('admin.stats') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:700;background:rgba(255,255,255,0.15);color:#fff;text-decoration:none;">📈 Statistiques</a>
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
            <span style="color:#0D2137;font-weight:600;">Statistiques</span>
        </div>

        <div style="margin-bottom:24px;">
            <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Statistiques globales</h1>
            <p style="font-size:13px;color:#5a6a7a;">Vue d'ensemble de l'activité de la plateforme</p>
        </div>

        {{-- UTILISATEURS PAR RÔLE --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;margin-bottom:20px;">
            <h2 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">👥 Utilisateurs par rôle</h2>
            @php
                $roles = [
                    'freelance'   => ['💻', '#1A4B7A'],
                    'artisan'     => ['🔧', '#1A9B5A'],
                    'tuteur'      => ['🎓', '#F0A500'],
                    'entreprise'  => ['🏢', '#0D2137'],
                    'particulier' => ['👤', '#888'],
                    'admin'       => ['🔑', '#c0392b'],
                ];
                $total = array_sum($stats['users_par_role']->toArray());
            @endphp
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
                @foreach($roles as $role => $info)
                    @php $count = $stats['users_par_role'][$role] ?? 0; @endphp
                    <div style="background:#F4F6F9;border-radius:10px;padding:16px;border-left:4px solid {{ $info[1] }};">
                        <div style="font-size:22px;margin-bottom:6px;">{{ $info[0] }}</div>
                        <div style="font-size:22px;font-weight:700;color:{{ $info[1] }};">{{ $count }}</div>
                        <div style="font-size:13px;color:#5a6a7a;margin-top:4px;">{{ ucfirst($role) }}</div>
                        <div style="height:6px;background:#E2E8F0;border-radius:4px;overflow:hidden;margin-top:8px;">
                            <div style="width:{{ $total > 0 ? round(($count/$total)*100) : 0 }}%;height:100%;background:{{ $info[1] }};border-radius:4px;"></div>
                        </div>
                        <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">{{ $total > 0 ? round(($count/$total)*100) : 0 }}%</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

            {{-- SERVICES PAR STATUT --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">🛠️ Services par statut</h2>
                @foreach(['actif' => ['#1A9B5A','✓ Actifs'], 'inactif' => ['#F0A500','⏸ Inactifs'], 'suspendu' => ['#c0392b','🚫 Suspendus']] as $statut => $info)
                    @php $count = $stats['services_par_statut'][$statut] ?? 0; @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <span style="font-size:13px;font-weight:600;color:#0D2137;">{{ $info[1] }}</span>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:120px;height:8px;background:#E2E8F0;border-radius:4px;overflow:hidden;">
                                <div style="width:{{ $count > 0 ? min(100, $count * 10) : 0 }}%;height:100%;background:{{ $info[0] }};border-radius:4px;"></div>
                            </div>
                            <span style="font-size:14px;font-weight:700;color:{{ $info[0] }};min-width:20px;text-align:right;">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- OFFRES PAR STATUT --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">📢 Offres par statut</h2>
                @foreach(['active' => ['#1A9B5A','✓ Actives'], 'cloturee' => ['#888','🔒 Clôturées']] as $statut => $info)
                    @php $count = $stats['offres_par_statut'][$statut] ?? 0; @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <span style="font-size:13px;font-weight:600;color:#0D2137;">{{ $info[1] }}</span>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:120px;height:8px;background:#E2E8F0;border-radius:4px;overflow:hidden;">
                                <div style="width:{{ $count > 0 ? min(100, $count * 10) : 0 }}%;height:100%;background:{{ $info[0] }};border-radius:4px;"></div>
                            </div>
                            <span style="font-size:14px;font-weight:700;color:{{ $info[0] }};min-width:20px;text-align:right;">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- CANDIDATURES PAR STATUT --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
            <h2 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">📩 Candidatures par statut</h2>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
                @foreach([
                    'en_attente' => ['#F0A500', '⏳ En attente'],
                    'acceptee'   => ['#1A9B5A', '✓ Acceptées'],
                    'refusee'    => ['#c0392b', '✗ Refusées'],
                ] as $statut => $info)
                    @php $count = $stats['candidatures_par_statut'][$statut] ?? 0; @endphp
                    <div style="background:#F4F6F9;border-radius:10px;padding:16px;text-align:center;border-top:3px solid {{ $info[0] }};">
                        <div style="font-size:28px;font-weight:700;color:{{ $info[0] }};">{{ $count }}</div>
                        <div style="font-size:13px;color:#5a6a7a;margin-top:6px;">{{ $info[1] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection