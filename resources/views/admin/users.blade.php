@extends('layouts.app')
@section('title', 'Gestion des utilisateurs')

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
        <a href="{{ route('admin.users') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:700;background:rgba(255,255,255,0.15);color:#fff;text-decoration:none;">👥 Utilisateurs</a>
        <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;padding:8px 16px;margin-top:8px;">Modération</div>
        <a href="{{ route('admin.signalements') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.7);text-decoration:none;">🚩 Signalements</a>
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
            <span style="color:#0D2137;font-weight:600;">Utilisateurs</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Gestion des utilisateurs</h1>
                <p style="font-size:13px;color:#5a6a7a;">{{ $users->total() }} utilisateurs au total</p>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- FILTRES --}}
        <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:16px;margin-bottom:20px;">
            <form method="GET" action="{{ route('admin.users') }}" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">

                <div style="position:relative;flex:1;min-width:200px;">
                    <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:14px;">🔍</span>
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Rechercher un utilisateur..."
                        style="width:100%;padding:9px 12px 9px 34px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;outline:none;">
                </div>

                <select name="role"
                    style="padding:9px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;outline:none;background:#fff;">
                    <option value="">Tous les rôles</option>
                    @foreach(['freelance','artisan','tuteur','entreprise','particulier'] as $r)
                        <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    style="background:#0D2137;color:#fff;border:none;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                    Filtrer
                </button>

                @if(request('q') || request('role'))
                    <a href="{{ route('admin.users') }}"
                        style="font-size:13px;color:#c0392b;font-weight:600;text-decoration:none;">
                        ✕ Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        {{-- TABLEAU --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F4F6F9;border-bottom:2px solid #E2E8F0;">
                        <th style="text-align:left;font-size:12px;color:#5a6a7a;padding:12px 16px;font-weight:600;">Utilisateur</th>
                        <th style="text-align:left;font-size:12px;color:#5a6a7a;padding:12px 16px;font-weight:600;">Rôle</th>
                        <th style="text-align:left;font-size:12px;color:#5a6a7a;padding:12px 16px;font-weight:600;">Email</th>
                        <th style="text-align:left;font-size:12px;color:#5a6a7a;padding:12px 16px;font-weight:600;">Inscription</th>
                        <th style="text-align:left;font-size:12px;color:#5a6a7a;padding:12px 16px;font-weight:600;">Statut</th>
                        <th style="text-align:left;font-size:12px;color:#5a6a7a;padding:12px 16px;font-weight:600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr style="border-bottom:1px solid #E2E8F0;">
                            <td style="padding:12px 16px;">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;">
                                        {{ strtoupper(substr($u->profile->nom ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-size:13px;font-weight:600;color:#0D2137;">
                                            {{ $u->profile->nom ?? 'Sans nom' }} {{ $u->profile->prenom ?? '' }}
                                        </div>
                                        <div style="font-size:11px;color:#5a6a7a;">
                                            📍 {{ $u->profile->localisation ?? 'Non renseigné' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 16px;">
                                <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;font-size:13px;color:#5a6a7a;">{{ $u->email }}</td>
                            <td style="padding:12px 16px;font-size:12px;color:#5a6a7a;">{{ $u->created_at->format('d/m/Y') }}</td>
                            <td style="padding:12px 16px;">
                                <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                    background:{{ $u->statut === 'actif' ? '#E6F7EE' : '#fdecea' }};
                                    color:{{ $u->statut === 'actif' ? '#0A6B3A' : '#c0392b' }};">
                                    {{ $u->statut === 'actif' ? '✓ Actif' : '⏸ Suspendu' }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;">
                                <div style="display:flex;gap:6px;align-items:center;">
                                    <a href="{{ route('profil.show', $u->id) }}"
                                        style="font-size:11px;padding:5px 10px;border-radius:6px;border:1px solid #E2E8F0;background:#fff;color:#1A4B7A;text-decoration:none;font-weight:600;">
                                        👁
                                    </a>
                                    @if($u->statut === 'actif')
                                        <form method="POST" action="{{ route('admin.users.suspend', $u->id) }}">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                style="font-size:11px;padding:5px 10px;border-radius:6px;border:none;background:#F0A500;color:#0D2137;cursor:pointer;font-weight:700;">
                                                ⏸
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.activer', $u->id) }}">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                style="font-size:11px;padding:5px 10px;border-radius:6px;border:none;background:#1A9B5A;color:#fff;cursor:pointer;font-weight:700;">
                                                ▶
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Supprimer définitivement ce compte ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            style="font-size:11px;padding:5px 10px;border-radius:6px;border:none;background:#fdecea;color:#c0392b;cursor:pointer;font-weight:700;">
                                            🗑
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:40px;text-align:center;color:#5a6a7a;">
                                <div style="font-size:32px;margin-bottom:10px;">👥</div>
                                <div style="font-size:14px;font-weight:600;">Aucun utilisateur trouvé</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:20px;">
            {{ $users->withQueryString()->links() }}
        </div>

    </div>
</div>
@endsection