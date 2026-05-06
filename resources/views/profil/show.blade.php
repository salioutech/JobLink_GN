@extends('layouts.app')
@section('title', $profile->nom . ' ' . $profile->prenom)

@section('content')

{{-- FIL D'ARIANE --}}
<div style="background:#fff;padding:12px 28px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#5a6a7a;">
    <a href="{{ route('home') }}" style="color:#1A4B7A;">Accueil</a> ›
    <a href="{{ route('search') }}" style="color:#1A4B7A;">Rechercher</a> ›
    <span style="color:#0D2137;font-weight:600;">{{ $profile->nom }} {{ $profile->prenom }}</span>
</div>

{{-- BANDEAU PROFIL --}}
<div style="background:linear-gradient(135deg,#0D2137,#1A4B7A);padding:32px 28px;">
    <div style="display:flex;align-items:flex-start;gap:24px;max-width:900px;margin:0 auto;">

        {{-- AVATAR --}}
        <div style="position:relative;flex-shrink:0;">
            @if($profile->photo)
                <img src="{{ asset('storage/'.$profile->photo) }}" alt="Photo"
                    style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:4px solid #fff;">
            @else
                <div style="width:90px;height:90px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:#0D2137;border:4px solid #fff;">
                    {{ strtoupper(substr($profile->nom, 0, 1)) }}{{ strtoupper(substr($profile->prenom ?? '', 0, 1)) }}
                </div>
            @endif
            {{-- Indicateur disponibilité --}}
            @if($profile->detail?->disponibilite)
                <div style="position:absolute;bottom:4px;right:4px;width:18px;height:18px;border-radius:50%;background:#1A9B5A;border:2px solid #fff;"></div>
            @endif
        </div>

        {{-- INFOS --}}
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px;flex-wrap:wrap;">
                <h1 style="color:#fff;font-size:22px;font-weight:700;">
                    {{ $profile->nom }} {{ $profile->prenom }}
                </h1>
                <span style="background:#1A9B5A;color:#fff;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                    {{ ucfirst($profile->user->role) }}
                </span>
                @if($profile->detail?->disponibilite)
                    <span style="background:#E6F7EE;color:#0A6B3A;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                        ✓ Disponible
                    </span>
                @else
                    <span style="background:#fdecea;color:#c0392b;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                        Indisponible
                    </span>
                @endif
            </div>
            <div style="font-size:14px;color:#B5C8D8;margin-bottom:10px;">
                {{ $profile->user->services->first()?->titre ?? ucfirst($profile->user->role) }}
            </div>
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <span style="font-size:13px;color:#B5C8D8;">📍 {{ $profile->localisation ?? 'Conakry' }}</span>
                <span style="font-size:13px;color:#B5C8D8;">📅 Membre depuis {{ $profile->created_at->format('M Y') }}</span>
                {{-- Téléphone --}}
                @auth
                    @if($profile->telephone)
                        <span style="font-size:13px;color:#B5C8D8;">📞 {{ $profile->telephone }}</span>
                    @endif
                @else
                    <span style="font-size:13px;display:flex;align-items:center;gap:6px;">
                        📞 <span style="background:rgba(255,255,255,0.12);padding:2px 12px;border-radius:4px;letter-spacing:3px;font-size:12px;color:rgba(255,255,255,0.4);">●●● ●●●●●●</span>
                        <a href="{{ route('login') }}" style="font-size:11px;background:#F0A500;color:#0D2137;padding:2px 8px;border-radius:4px;font-weight:700;text-decoration:none;">🔒 Connexion</a>
                    </span>
                @endauth
            </div>
        </div>

        {{-- BOUTONS --}}
        <div style="flex-shrink:0;">
            @auth
                @if(Auth::id() !== $profile->user_id)
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <button onclick="document.getElementById('modal-contact').style.display='flex'"
                            style="background:#1A9B5A;color:#fff;border:none;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;white-space:nowrap;">
                            ✉ Envoyer une demande
                        </button>
                        <button onclick="document.getElementById('modal-signalement').style.display='flex'"
                            style="background:transparent;color:#fff;border:2px solid #fff;padding:10px 24px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;">
                            🚩 Signaler
                        </button>
                    </div>
                @endif
            @else
                <div style="background:rgba(255,255,255,0.1);border:2px dashed rgba(255,255,255,0.3);border-radius:10px;padding:16px 20px;text-align:center;">
                    <div style="font-size:12px;color:#B5C8D8;margin-bottom:10px;">Pour contacter ce prestataire</div>
                    <a href="{{ route('login') }}" style="display:block;background:#1A9B5A;color:#fff;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;margin-bottom:8px;">Se connecter</a>
                    <a href="{{ route('register') }}" style="display:block;background:#F0A500;color:#0D2137;padding:9px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">S'inscrire</a>
                </div>
            @endauth
        </div>

    </div>
</div>

{{-- TAUX DE COMPLÉTION --}}
<div style="background:#E8F0F9;padding:12px 28px;border-bottom:1px solid #E2E8F0;">
    <div style="max-width:900px;margin:0 auto;display:flex;align-items:center;gap:16px;">
        <span style="font-size:13px;font-weight:600;color:#1A4B7A;">Profil complété à {{ $profile->completion_rate }}%</span>
        <div style="flex:1;height:8px;background:#E2E8F0;border-radius:4px;overflow:hidden;">
            <div style="width:{{ $profile->completion_rate }}%;height:100%;background:#1A9B5A;border-radius:4px;"></div>
        </div>
    </div>
</div>

{{-- CORPS --}}
<div style="max-width:900px;margin:24px auto;padding:0 28px;display:grid;grid-template-columns:1fr 300px;gap:20px;">

    {{-- COLONNE GAUCHE --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- BIOGRAPHIE --}}
        @if($profile->bio)
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:12px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">À propos</h2>
                <p style="font-size:14px;color:#444;line-height:1.8;">{{ $profile->bio }}</p>
            </div>
        @endif

        {{-- COMPÉTENCES --}}
        @if($profile->detail?->competences)
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Compétences</h2>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach(explode(',', $profile->detail->competences) as $comp)
                        <span style="background:#E8F0F9;color:#1A4B7A;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                            {{ trim($comp) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- SERVICES --}}
        @if($profile->user->services->count() > 0)
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Services proposés</h2>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($profile->user->services->where('statut','actif') as $service)
                        <div style="background:#F4F6F9;border-radius:10px;padding:16px;border-left:4px solid #1A4B7A;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                <div style="font-size:14px;font-weight:700;color:#0D2137;">{{ $service->titre }}</div>
                                <span style="background:#E6F7EE;color:#0A6B3A;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Actif</span>
                            </div>
                            <p style="font-size:13px;color:#5a6a7a;margin-bottom:10px;line-height:1.6;">
                                {{ Str::limit($service->description, 100) }}
                            </p>
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <span style="font-size:14px;font-weight:700;color:#1A9B5A;">
                                    {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' GNF' : 'À négocier' }}
                                </span>
                                <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                    {{ $service->categorie->nom ?? '' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- PORTFOLIO --}}
        @if($profile->detail?->portfolio_url || $profile->detail?->portfolio_fichier)
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Portfolio</h2>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    @if($profile->detail->portfolio_url)
                        <a href="{{ $profile->detail->portfolio_url }}" target="_blank"
                            style="display:flex;align-items:center;gap:8px;background:#E8F0F9;color:#1A4B7A;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                            🌐 Voir mon portfolio en ligne
                        </a>
                    @endif
                    @if($profile->detail->portfolio_fichier)
                        <a href="{{ asset('storage/'.$profile->detail->portfolio_fichier) }}" target="_blank"
                            style="display:flex;align-items:center;gap:8px;background:#FEF3DC;color:#7A4500;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                            📄 Télécharger le CV (PDF)
                        </a>
                    @endif
                </div>
            </div>
        @endif

    </div>

    {{-- COLONNE DROITE --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- CARTE CONTACT --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-top:4px solid #1A9B5A;">
            <h3 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">
                Contacter {{ $profile->prenom ?? $profile->nom }}
            </h3>

            @if($profile->detail?->tarif)
                <div style="margin-bottom:14px;">
                    <div style="font-size:12px;color:#5a6a7a;margin-bottom:4px;">Tarif</div>
                    <div style="font-size:18px;font-weight:700;color:#1A9B5A;">
                        {{ number_format($profile->detail->tarif, 0, ',', ' ') }} GNF
                    </div>
                </div>
                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:14px;">
            @endif

            <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:#5a6a7a;">Disponibilité</span>
                    @if($profile->detail?->disponibilite)
                        <span style="font-weight:600;color:#1A9B5A;">✓ Disponible</span>
                    @else
                        <span style="font-weight:600;color:#c0392b;">✗ Indisponible</span>
                    @endif
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:#5a6a7a;">Localisation</span>
                    <span style="font-weight:600;color:#0D2137;">{{ $profile->localisation ?? 'Conakry' }}</span>
                </div>
                {{-- Téléphone --}}
                <div style="display:flex;justify-content:space-between;font-size:13px;align-items:center;">
                    <span style="color:#5a6a7a;">Téléphone</span>
                    @auth
                        <span style="font-weight:600;color:#0D2137;">{{ $profile->telephone ?? 'Non renseigné' }}</span>
                    @else
                        <span style="display:flex;align-items:center;gap:4px;">
                            <span style="letter-spacing:2px;color:#ccc;font-size:12px;">●●● ●●●●●●</span>
                            <span style="font-size:10px;background:#FEF3DC;color:#7A4500;padding:2px 6px;border-radius:4px;font-weight:600;">🔒</span>
                        </span>
                    @endauth
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:#5a6a7a;">Services publiés</span>
                    <span style="font-weight:600;color:#0D2137;">{{ $profile->user->services->where('statut','actif')->count() }} actifs</span>
                </div>
            </div>

            @auth
                @if(Auth::id() !== $profile->user_id)
                    <button onclick="document.getElementById('modal-contact').style.display='flex'"
                        style="background:#1A9B5A;color:#fff;border:none;width:100%;padding:13px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;margin-bottom:10px;">
                        ✉ Envoyer une demande
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}"
                    style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;margin-bottom:10px;">
                    🔒 Se connecter pour contacter
                </a>
                <p style="text-align:center;font-size:12px;color:#5a6a7a;">
                    Pas de compte ? <a href="{{ route('register') }}" style="color:#1A9B5A;font-weight:700;">S'inscrire →</a>
                </p>
            @endauth
        </div>

        {{-- SIGNALEMENT --}}
        @auth
            @if(Auth::id() !== $profile->user_id)
                <div style="background:#F4F6F9;border:1.5px dashed #E2E8F0;border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:12px;color:#5a6a7a;margin-bottom:8px;">Ce profil vous semble inapproprié ?</div>
                    <button onclick="document.getElementById('modal-signalement').style.display='flex'"
                        style="background:transparent;color:#c0392b;border:1.5px solid #c0392b;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                        🚩 Signaler ce profil
                    </button>
                </div>
            @endif
        @endauth

    </div>
</div>

{{-- MODAL DEMANDE DE CONTACT --}}
@auth
<div id="modal-contact" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:28px;width:100%;max-width:480px;margin:20px;">
        <h3 style="font-size:18px;font-weight:700;color:#0D2137;margin-bottom:6px;">
            Envoyer une demande à {{ $profile->prenom ?? $profile->nom }}
        </h3>
        <p style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">Décrivez votre besoin en quelques mots.</p>

        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px;margin-bottom:16px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fdecea;border-left:4px solid #c0392b;border-radius:8px;padding:12px;margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <div style="font-size:13px;color:#7b1c1c;">⚠ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('demande.store') }}">
            @csrf
            <input type="hidden" name="offreur_id" value="{{ $profile->user_id }}">
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                    Message <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                </label>
                <textarea name="message" rows="4" maxlength="1000"
                    placeholder="Décrivez votre besoin..."
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="flex:1;background:#1A9B5A;color:#fff;border:none;padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                    Envoyer la demande
                </button>
                <button type="button" onclick="document.getElementById('modal-contact').style.display='none'"
                    style="flex:1;background:transparent;color:#5a6a7a;border:1.5px solid #E2E8F0;padding:12px;border-radius:8px;font-size:14px;cursor:pointer;">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL SIGNALEMENT --}}
<div id="modal-signalement" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:28px;width:100%;max-width:440px;margin:20px;">
        <h3 style="font-size:18px;font-weight:700;color:#c0392b;margin-bottom:6px;">Signaler ce profil</h3>
        <p style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">Décrivez le problème. L'administrateur examinera votre signalement.</p>

        <form method="POST" action="{{ route('signalement.store') }}">
            @csrf
            <input type="hidden" name="cible_type" value="user">
            <input type="hidden" name="cible_id" value="{{ $profile->user_id }}">
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                    Motif <span style="color:#c0392b;">*</span>
                    <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(minimum 10 caractères)</span>
                </label>
                <textarea name="motif" rows="4" maxlength="500"
                    placeholder="Décrivez pourquoi vous signalez ce profil..."
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="flex:1;background:#c0392b;color:#fff;border:none;padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                    Envoyer le signalement
                </button>
                <button type="button" onclick="document.getElementById('modal-signalement').style.display='none'"
                    style="flex:1;background:transparent;color:#5a6a7a;border:1.5px solid #E2E8F0;padding:12px;border-radius:8px;font-size:14px;cursor:pointer;">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection