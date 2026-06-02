@extends('layouts.app')
@section('title', 'Accueil')

@section('content')

{{-- HERO --}}
<div style="background:linear-gradient(135deg,#0D2137 0%,#1A4B7A 60%,#0A6B3A 100%);padding:56px 28px 48px;text-align:center;position:relative;overflow:hidden;">

    <div style="display:inline-block;background:#F0A500;color:#0D2137;font-size:12px;font-weight:700;padding:4px 14px;border-radius:20px;margin-bottom:18px;">
        🇬🇳 Plateforme 100% guinéenne
    </div>

    <h1 style="color:#fff;font-size:34px;font-weight:700;line-height:1.3;margin-bottom:14px;max-width:600px;margin-left:auto;margin-right:auto;">
        Connecter les talents,<br><span style="color:#F0A500;">créer des opportunités</span>
    </h1>

    <p style="color:#B5C8D8;font-size:15px;margin-bottom:28px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;">
        Consultants, artisans, tuteurs — tous les talents guinéens réunis. En français, gratuit, adapté à vos réalités.
    </p>

    {{-- BARRE DE RECHERCHE --}}
    <form method="GET" action="{{ route('search') }}" style="max-width:620px;margin:0 auto 16px;">
        <div style="display:flex;align-items:center;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.25);">
            <input type="text" name="q" placeholder="Ex: Développeur Laravel, électricien, tuteur maths..."
                style="flex:1;border:none;padding:14px 16px;font-size:14px;outline:none;color:#333;">
            <select name="categorie"
                style="border:none;border-left:1px solid #eee;padding:14px 12px;font-size:13px;color:#555;outline:none;background:#fff;">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                @endforeach
            </select>
            <button type="submit"
                style="background:#1A9B5A;color:#fff;border:none;padding:14px 22px;font-size:14px;font-weight:700;cursor:pointer;white-space:nowrap;">
                Rechercher
            </button>
        </div>
    </form>

    {{-- STATS --}}
    <div style="display:flex;align-items:center;justify-content:center;gap:36px;margin-top:32px;">
        <div style="text-align:center;">
            <div style="font-size:26px;font-weight:700;color:#F0A500;">{{ $services->count()  }}+</div>
            <div style="font-size:12px;color:#B5C8D8;">Prestataires actifs</div>
        </div>
        <div style="width:1px;height:36px;background:rgba(255,255,255,0.15);"></div>
        <div style="text-align:center;">
            <div style="font-size:26px;font-weight:700;color:#F0A500;">{{ $categories->count() }}</div>
            <div style="font-size:12px;color:#B5C8D8;">Catégories</div>
        </div>
        <div style="width:1px;height:36px;background:rgba(255,255,255,0.15);"></div>
        <div style="text-align:center;">
            <div style="font-size:26px;font-weight:700;color:#F0A500;">{{ $offres->count()  }}+</div>
            <div style="font-size:12px;color:#B5C8D8;">Offres actives</div>
        </div>
        <div style="width:1px;height:36px;background:rgba(255,255,255,0.15);"></div>
        <div style="text-align:center;">
            <div style="font-size:26px;font-weight:700;color:#F0A500;">100%</div>
            <div style="font-size:12px;color:#B5C8D8;">Gratuit</div>
        </div>
    </div>
</div>

{{-- CATÉGORIES --}}
<div style="padding:40px 28px;background:#fff;">
    <h2 style="font-size:20px;font-weight:700;text-align:center;margin-bottom:6px;color:#0D2137;">Explorez par catégorie</h2>
    <p style="text-align:center;color:#5a6a7a;font-size:14px;margin-bottom:28px;">Cliquez pour voir tous les prestataires disponibles</p>
    <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:12px;">
        @php
            $icones = ['💻','🏗️','🎓','🛒','🏥','🚗','💼'];
            $i = 0;
        @endphp
        @foreach($categories as $cat)
            <a href="{{ route('search', ['categorie' => $cat->id]) }}"
                style="background:#F4F6F9;border-radius:10px;padding:18px 8px;text-align:center;cursor:pointer;border:1px solid #E2E8F0;text-decoration:none;">
                <div style="font-size:24px;margin-bottom:8px;">{{ $icones[$i++] ?? '💼' }}</div>
                <div style="font-size:12px;font-weight:700;color:#0D2137;">{{ $cat->nom }}</div>
            </a>
        @endforeach
    </div>
</div>

{{-- SERVICES RÉCENTS --}}
<div style="padding:40px 28px;background:#F4F6F9;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <h2 style="font-size:20px;font-weight:700;margin-bottom:4px;color:#0D2137;">Services récents</h2>
            <p style="font-size:13px;color:#5a6a7a;">Les derniers prestataires inscrits sur la plateforme</p>
        </div>
        <a href="{{ route('search') }}" style="font-size:13px;color:#1A9B5A;font-weight:600;text-decoration:none;">Voir tous les services →</a>
    </div>

    @if($services->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            @foreach($services as $service)
                @php
                    $likeCount   = $service->likes()->count();
                    $liked       = auth()->check() && $service->likes()->where('user_id', auth()->id())->exists();
                    $saved       = auth()->check() && $service->favoris()->where('user_id', auth()->id())->exists();
                    $favoriCount = $service->favoris()->count();
                    $commCount   = $service->commentaires()->count();
                @endphp

                <div onclick="window.location='{{ route('service.show', $service->id) }}'"
                    style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;overflow:hidden;border-top:3px solid #1A4B7A;cursor:pointer;"
                    onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'"
                    onmouseout="this.style.boxShadow='none'">

                    <div style="padding:16px 16px 12px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                            <a href="{{ route('profil.show', $service->user_id) }}"
                                onclick="event.stopPropagation()"
                                style="text-decoration:none;display:flex;align-items:center;gap:10px;flex:1;">
                                <div style="width:44px;height:44px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#0D2137;flex-shrink:0;">
                                    {{ strtoupper(substr($service->user->profile->nom ?? 'U', 0, 1)) }}{{ strtoupper(substr($service->user->profile->prenom ?? '', 0, 1)) }}
                                </div>
                                <div style="flex:1;">
                                    <div style="font-size:14px;font-weight:700;color:#0D2137;">
                                        {{ $service->user->profile->nom ?? '' }} {{ $service->user->profile->prenom ?? '' }}
                                    </div>
                                    <div style="font-size:12px;color:#5a6a7a;">
                                        📍 {{ $service->user->profile->localisation ?? 'Conakry' }} · {{ ucfirst($service->user->role ?? '') }}
                                    </div>
                                </div>
                            </a>
                            <span style="background:#E6F7EE;color:#0A6B3A;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:600;flex-shrink:0;">Dispo</span>
                        </div>

                        <div style="font-size:13px;font-weight:700;color:#0D2137;margin-bottom:6px;">{{ $service->titre }}</div>

                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                            <span style="font-size:13px;font-weight:700;color:#1A9B5A;">
                                {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' GNF' : 'À négocier' }}
                            </span>
                            <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:600;">
                                {{ $service->categorie->nom ?? '' }}
                            </span>
                        </div>
                    </div>

                    {{-- BARRE D'ACTIONS --}}
                    <div style="border-top:1px solid #E2E8F0;padding:10px 16px;display:flex;align-items:center;gap:4px;background:#fff;">

                        {{-- LIKE --}}
                        @auth
                            <form method="POST" action="{{ route('like.toggle') }}"
                                onclick="event.stopPropagation()" style="display:inline;">
                                @csrf
                                <input type="hidden" name="type" value="service">
                                <input type="hidden" name="id" value="{{ $service->id }}">
                                <button type="submit" style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:{{ $liked ? '#fdecea' : 'transparent' }};color:{{ $liked ? '#c0392b' : '#5a6a7a' }};cursor:pointer;font-size:12px;font-weight:600;">
                                    {{ $liked ? '❤️' : '🤍' }} {{ $likeCount }}
                                </button>
                            </form>
                        @else
                            <button onclick="event.stopPropagation(); afficherAlerte()"
                                style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:transparent;color:#5a6a7a;cursor:pointer;font-size:12px;font-weight:600;">
                                🤍 {{ $likeCount }}
                            </button>
                        @endauth

                        {{-- COMMENTER --}}
                        <a href="{{ route('service.show', $service->id) }}#commentaires"
                            onclick="event.stopPropagation()"
                            style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;background:transparent;color:#5a6a7a;font-size:12px;font-weight:600;text-decoration:none;">
                            💬 {{ $commCount }}
                        </a>

                        {{-- FAVORI --}}
                        @auth
                            <form method="POST" action="{{ route('favori.toggle') }}"
                                onclick="event.stopPropagation()" style="display:inline;">
                                @csrf
                                <input type="hidden" name="type" value="service">
                                <input type="hidden" name="id" value="{{ $service->id }}">
                                <button type="submit" style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:{{ $saved ? '#FEF3DC' : 'transparent' }};color:{{ $saved ? '#7A4500' : '#5a6a7a' }};cursor:pointer;font-size:12px;font-weight:600;">
                                    {{ $saved ? '🔖' : '📌' }} {{ $favoriCount }}
                                </button>
                            </form>
                        @else
                            <button onclick="event.stopPropagation(); afficherAlerte()"
                                style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:transparent;color:#5a6a7a;cursor:pointer;font-size:12px;font-weight:600;">
                                📌 {{ $favoriCount }}
                            </button>
                        @endauth

                        {{-- PARTAGER --}}
                        <button onclick="event.stopPropagation(); partager('{{ $service->titre }}', '{{ route('service.show', $service->id) }}')"
                            style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:transparent;color:#5a6a7a;cursor:pointer;font-size:12px;font-weight:600;">
                            🔗
                        </button>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align:center;padding:40px;color:#5a6a7a;">
            <div style="font-size:14px;">Aucun service disponible pour le moment.</div>
        </div>
    @endif
</div>

{{-- OFFRES RÉCENTES --}}
<div style="padding:40px 28px;background:#fff;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <h2 style="font-size:20px;font-weight:700;margin-bottom:4px;color:#0D2137;">Offres récentes</h2>
            <p style="font-size:13px;color:#5a6a7a;">Missions et emplois publiés par entreprises et particuliers</p>
        </div>
        <a href="{{ route('search', ['tab' => 'offres']) }}" style="font-size:13px;color:#1A9B5A;font-weight:600;text-decoration:none;">Voir toutes les offres →</a>
    </div>

    @if($offres->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            @foreach($offres as $offre)
                @php
                    $likeCountO   = $offre->likes()->count();
                    $likedO       = auth()->check() && $offre->likes()->where('user_id', auth()->id())->exists();
                    $savedO       = auth()->check() && $offre->favoris()->where('user_id', auth()->id())->exists();
                    $favoriCountO = $offre->favoris()->count();
                    $commCountO   = $offre->commentaires()->count();
                @endphp

                <div onclick="window.location='{{ route('offre.show', $offre->id) }}'"
                    style="background:#F4F6F9;border-radius:10px;border:1px solid #E2E8F0;overflow:hidden;border-left:4px solid #1A4B7A;cursor:pointer;"
                    onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'"
                    onmouseout="this.style.boxShadow='none'">

                    <div style="padding:16px 16px 12px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                            <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                {{ ucfirst(str_replace('_',' ',$offre->type)) }}
                            </span>
                            <span style="font-size:11px;color:#5a6a7a;">{{ $offre->created_at->diffForHumans() }}</span>
                        </div>

                        <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:6px;">{{ $offre->titre }}</div>

                        <div style="font-size:12px;color:#5a6a7a;margin-bottom:10px;line-height:1.5;">
                            {{ Str::limit($offre->description, 80) }}
                        </div>

                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                            <span style="font-size:12px;color:#5a6a7a;">📍 {{ $offre->user->profile->localisation ?? 'Conakry' }}</span>
                            <span style="font-size:13px;font-weight:700;color:#1A9B5A;">
                                {{ $offre->budget ? number_format($offre->budget, 0, ',', ' ').' GNF' : 'À négocier' }}
                            </span>
                        </div>
                    </div>

                    {{-- BARRE D'ACTIONS --}}
                    <div style="border-top:1px solid #E2E8F0;padding:10px 16px;display:flex;align-items:center;gap:4px;background:#fff;">

                        {{-- LIKE --}}
                        @auth
                            <form method="POST" action="{{ route('like.toggle') }}"
                                onclick="event.stopPropagation()" style="display:inline;">
                                @csrf
                                <input type="hidden" name="type" value="offre">
                                <input type="hidden" name="id" value="{{ $offre->id }}">
                                <button type="submit" style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:{{ $likedO ? '#fdecea' : 'transparent' }};color:{{ $likedO ? '#c0392b' : '#5a6a7a' }};cursor:pointer;font-size:12px;font-weight:600;">
                                    {{ $likedO ? '❤️' : '🤍' }} {{ $likeCountO }}
                                </button>
                            </form>
                        @else
                            <button onclick="event.stopPropagation(); afficherAlerte()"
                                style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:transparent;color:#5a6a7a;cursor:pointer;font-size:12px;font-weight:600;">
                                🤍 {{ $likeCountO }}
                            </button>
                        @endauth

                        {{-- COMMENTER --}}
                        <a href="{{ route('offre.show', $offre->id) }}#commentaires"
                            onclick="event.stopPropagation()"
                            style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;background:transparent;color:#5a6a7a;font-size:12px;font-weight:600;text-decoration:none;">
                            💬 {{ $commCountO }}
                        </a>

                        {{-- FAVORI --}}
                        @auth
                            <form method="POST" action="{{ route('favori.toggle') }}"
                                onclick="event.stopPropagation()" style="display:inline;">
                                @csrf
                                <input type="hidden" name="type" value="offre">
                                <input type="hidden" name="id" value="{{ $offre->id }}">
                                <button type="submit" style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:{{ $savedO ? '#FEF3DC' : 'transparent' }};color:{{ $savedO ? '#7A4500' : '#5a6a7a' }};cursor:pointer;font-size:12px;font-weight:600;">
                                    {{ $savedO ? '🔖' : '📌' }} {{ $favoriCountO }}
                                </button>
                            </form>
                        @else
                            <button onclick="event.stopPropagation(); afficherAlerte()"
                                style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:transparent;color:#5a6a7a;cursor:pointer;font-size:12px;font-weight:600;">
                                📌 {{ $favoriCountO }}
                            </button>
                        @endauth

                        {{-- PARTAGER --}}
                        <button onclick="event.stopPropagation(); partager('{{ $offre->titre }}', '{{ route('offre.show', $offre->id) }}')"
                            style="display:flex;align-items:center;gap:4px;padding:6px 10px;border-radius:6px;border:none;background:transparent;color:#5a6a7a;cursor:pointer;font-size:12px;font-weight:600;">
                            🔗
                        </button>

                        {{-- SPACER --}}
                        <div style="flex:1;"></div>

                        {{-- POSTULER --}}
                        @auth
                            @if(Auth::user()->isOffreur())
                                <form method="POST" action="{{ route('candidature.store') }}"
                                    onclick="event.stopPropagation()" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                                    <button type="submit" style="background:#1A4B7A;color:#fff;border:none;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:700;cursor:pointer;">
                                        Postuler
                                    </button>
                                </form>
                            @endif
                        @else
                            <button onclick="event.stopPropagation(); afficherAlerte()"
                                style="background:#1A4B7A;color:#fff;border:none;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:700;cursor:pointer;">
                                Postuler
                            </button>
                        @endauth

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align:center;padding:40px;color:#5a6a7a;">
            <div style="font-size:14px;">Aucune offre disponible pour le moment.</div>
        </div>
    @endif
</div>

{{-- COMMENT ÇA MARCHE --}}
<div style="padding:48px 28px;background:#0D2137;">
    <h2 style="font-size:20px;font-weight:700;text-align:center;margin-bottom:6px;color:#fff;">Comment ça marche ?</h2>
    <p style="text-align:center;color:#B5C8D8;font-size:14px;margin-bottom:40px;">Simple, rapide, entièrement en français</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:660px;margin:0 auto;">
        @foreach([
            ['1', '#F0A500', 'Créez votre profil', 'Inscrivez-vous gratuitement et choisissez votre rôle en quelques minutes.'],
            ['2', '#1A9B5A', 'Publiez ou recherchez', 'Publiez vos services ou parcourez les offres disponibles près de chez vous.'],
            ['3', '#1A4B7A', 'Entrez en contact', 'Postulez à une offre ou contactez directement un prestataire depuis son profil.'],
        ] as $step)
            <div style="text-align:center;">
                <div style="width:56px;height:56px;background:{{ $step[1] }};border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:22px;font-weight:700;color:{{ $step[1] === '#F0A500' ? '#0D2137' : '#fff' }};">
                    {{ $step[0] }}
                </div>
                <div style="font-size:15px;font-weight:700;margin-bottom:8px;color:#fff;">{{ $step[2] }}</div>
                <div style="font-size:13px;color:#B5C8D8;line-height:1.6;">{{ $step[3] }}</div>
            </div>
        @endforeach
    </div>
</div>

{{-- CTA FINAL --}}
<div style="padding:52px 28px;background:linear-gradient(135deg,#0D2137,#0A6B3A);text-align:center;">
    <h2 style="color:#fff;font-size:26px;font-weight:700;margin-bottom:12px;">Rejoignez JobLinkGN aujourd'hui</h2>
    <p style="color:#B5C8D8;font-size:15px;margin-bottom:28px;max-width:440px;margin-left:auto;margin-right:auto;line-height:1.7;">
        Que vous soyez prestataire ou à la recherche d'un talent, créez votre compte gratuitement en 2 minutes.
    </p>
    <div style="display:flex;gap:16px;justify-content:center;">
        <a href="{{ route('register') }}"
            style="background:#F0A500;color:#0D2137;padding:13px 28px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
            S'inscrire gratuitement
        </a>
        <a href="{{ route('search') }}"
            style="background:transparent;color:#fff;border:2px solid #fff;padding:12px 28px;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;">
            Rechercher un prestataire
        </a>
    </div>
</div>

{{-- MODAL ALERTE CONNEXION --}}
<div id="modal-alerte-connexion"
    style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:32px 28px;width:100%;max-width:400px;margin:20px;text-align:center;box-shadow:0 8px 40px rgba(0,0,0,0.2);">
        <div style="font-size:48px;margin-bottom:16px;">🔒</div>
        <h3 style="font-size:18px;font-weight:700;color:#0D2137;margin-bottom:10px;">Connexion requise</h3>
        <p style="font-size:14px;color:#5a6a7a;line-height:1.7;margin-bottom:24px;">
            Vous devez être connecté pour effectuer cette action.<br>
            Rejoignez JobLink GN gratuitement !
        </p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <a href="{{ route('login') }}"
                style="background:#1A9B5A;color:#fff;padding:11px 24px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                Se connecter
            </a>
            <a href="{{ route('register') }}"
                style="background:#F0A500;color:#0D2137;padding:11px 24px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                S'inscrire
            </a>
        </div>
        <button onclick="document.getElementById('modal-alerte-connexion').style.display='none'"
            style="margin-top:16px;background:transparent;border:none;color:#5a6a7a;font-size:13px;cursor:pointer;text-decoration:underline;">
            Fermer
        </button>
    </div>
</div>

@push('scripts')
<script>
function afficherAlerte() {
    document.getElementById('modal-alerte-connexion').style.display = 'flex';
}

document.getElementById('modal-alerte-connexion').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});

function partager(titre, url) {
    if (navigator.share) {
        navigator.share({ title: titre, url: url });
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Lien copié dans le presse-papiers !');
        });
    }
}
</script>
@endpush

@endsection