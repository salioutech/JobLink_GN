@extends('layouts.app')
@section('title', 'Candidatures reçues')

@section('content')
<div style="display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px 12px;display:flex;flex-direction:column;gap:4px;">
        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid #E2E8F0;">
            <div style="width:52px;height:52px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;margin:0 auto 8px;border:3px solid #F0A500;">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}
            </div>
            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ Auth::user()->profile->nom ?? '' }}</div>
            <div style="font-size:11px;color:#5a6a7a;">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🏠 Tableau de bord</a>
        <a href="{{ route('profil.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">👤 Mon profil</a>
        <a href="{{ route('offre.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">📢 Mes offres</a>
        <a href="{{ route('candidature.received') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">👥 Candidatures reçues</a>
        <a href="{{ route('demande.sent') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🤝 Demandes envoyées</a>
        <a href="{{ route('search') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🔍 Rechercher des talents</a>
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
            <span style="color:#0D2137;font-weight:600;">Candidatures reçues</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Candidatures reçues</h1>
                <p style="font-size:13px;color:#5a6a7a;">Gérez les candidatures sur vos offres publiées</p>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- STATS --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px;">
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #1A4B7A;">
                <div style="font-size:24px;font-weight:700;color:#0D2137;">{{ $candidatures->total() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Total reçues</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #F0A500;">
                <div style="font-size:24px;font-weight:700;color:#F0A500;">{{ $candidatures->where('statut','en_attente')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">En attente</div>
            </div>
            <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:14px;text-align:center;border-top:3px solid #1A9B5A;">
                <div style="font-size:24px;font-weight:700;color:#1A9B5A;">{{ $candidatures->where('statut','acceptee')->count() }}</div>
                <div style="font-size:12px;color:#5a6a7a;margin-top:4px;">Acceptées</div>
            </div>
        </div>

        {{-- LISTE --}}
        @if($candidatures->count() > 0)
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($candidatures as $candidature)
                    <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-left:4px solid
                        {{ $candidature->statut === 'acceptee' ? '#1A9B5A' : ($candidature->statut === 'refusee' ? '#c0392b' : '#F0A500') }};">

                        <div style="display:flex;align-items:flex-start;gap:16px;">
                            <div style="width:46px;height:46px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#0D2137;flex-shrink:0;">
                                {{ strtoupper(substr($candidature->offreur->profile->nom ?? 'U', 0, 1)) }}
                            </div>
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                                    <span style="font-size:15px;font-weight:700;color:#0D2137;">
                                        {{ $candidature->offreur->profile->nom ?? 'Candidat' }}
                                        {{ $candidature->offreur->profile->prenom ?? '' }}
                                    </span>
                                    <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                        {{ ucfirst($candidature->offreur->role) }}
                                    </span>
                                    <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;
                                        background:{{ $candidature->statut === 'acceptee' ? '#E6F7EE' : ($candidature->statut === 'refusee' ? '#fdecea' : '#FEF3DC') }};
                                        color:{{ $candidature->statut === 'acceptee' ? '#0A6B3A' : ($candidature->statut === 'refusee' ? '#c0392b' : '#7A4500') }};">
                                        {{ $candidature->statut === 'acceptee' ? '✓ Acceptée' : ($candidature->statut === 'refusee' ? '✗ Refusée' : '⏳ En attente') }}
                                    </span>
                                </div>

                                <div style="font-size:12px;color:#5a6a7a;margin-bottom:8px;">
                                    Pour : <strong>{{ $candidature->offre->titre ?? 'Offre supprimée' }}</strong> ·
                                    {{ $candidature->created_at->diffForHumans() }}
                                </div>

                                @if($candidature->message)
                                    <div style="background:#F4F6F9;border-radius:8px;padding:12px;margin-bottom:12px;border-left:3px solid #E2E8F0;font-size:13px;color:#444;line-height:1.6;">
                                        "{{ Str::limit($candidature->message, 150) }}"
                                    </div>
                                @endif

                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <a href="{{ route('profil.show', $candidature->offreur_id) }}"
                                        style="background:#E8F0F9;color:#1A4B7A;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">
                                        👁 Voir le profil
                                    </a>
                                    @if($candidature->statut === 'en_attente')
                                        <form method="POST" action="{{ route('candidature.update', $candidature->id) }}">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="acceptee">
                                            <button type="submit" style="background:#1A9B5A;color:#fff;border:none;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">✓ Accepter</button>
                                        </form>
                                        <form method="POST" action="{{ route('candidature.update', $candidature->id) }}">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="refusee">
                                            <button type="submit" style="background:#fdecea;color:#c0392b;border:1px solid #f5c6c6;padding:8px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">✗ Refuser</button>
                                        </form>
                                    @endif
                                </div>
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
                <div style="font-size:48px;margin-bottom:16px;">👥</div>
                <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucune candidature reçue</div>
                <div style="font-size:14px;margin-bottom:20px;">Publiez des offres pour recevoir des candidatures.</div>
                <a href="{{ route('offre.create') }}"
                    style="background:#1A4B7A;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                    + Publier une offre
                </a>
            </div>
        @endif

    </div>
</div>
@endsection