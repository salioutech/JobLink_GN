@extends('layouts.app')
@section('title', $offre->titre)

@section('content')

{{-- FIL D'ARIANE --}}
<div style="background:#fff;padding:12px 28px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#5a6a7a;">
    <a href="{{ route('home') }}" style="color:#1A4B7A;">Accueil</a> ›
    <a href="{{ route('search', ['tab' => 'offres']) }}" style="color:#1A4B7A;">Offres</a> ›
    <span style="color:#0D2137;font-weight:600;">{{ $offre->titre }}</span>
</div>

{{-- CONTENU --}}
<div style="max-width:900px;margin:28px auto;padding:0 28px;">
    <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start;">

        {{-- COLONNE GAUCHE --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- EN-TÊTE --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;border-top:4px solid #1A4B7A;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap;">
                    <span style="background:#E8F0F9;color:#1A4B7A;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                        {{ ucfirst(str_replace('_',' ',$offre->type)) }}
                    </span>
                    <span style="background:{{ $offre->statut === 'active' ? '#E6F7EE' : '#f0f0f0' }};color:{{ $offre->statut === 'active' ? '#0A6B3A' : '#888' }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                        {{ $offre->statut === 'active' ? '✓ Active' : '🔒 Clôturée' }}
                    </span>
                    <span style="font-size:12px;color:#5a6a7a;">{{ $offre->created_at->diffForHumans() }}</span>
                </div>

                <h1 style="font-size:22px;font-weight:700;color:#0D2137;margin-bottom:12px;">{{ $offre->titre }}</h1>

                <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:38px;height:38px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;">
                            {{ strtoupper(substr($offre->user->profile->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#0D2137;">{{ $offre->user->profile->nom ?? '' }}</div>
                            <div style="font-size:12px;color:#5a6a7a;">{{ ucfirst($offre->user->role) }}</div>
                        </div>
                    </div>
                    <span style="font-size:13px;color:#5a6a7a;">📍 {{ $offre->user->profile->localisation ?? 'Conakry' }}</span>
                    <span style="font-size:13px;color:#5a6a7a;">💼 {{ $offre->categorie->nom ?? '' }}</span>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Description</h2>
                <p style="font-size:14px;color:#444;line-height:1.8;">{{ $offre->description }}</p>
            </div>

            {{-- COMPÉTENCES REQUISES --}}
            @if($offre->competences_requises)
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Compétences requises</h2>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @foreach(explode(',', $offre->competences_requises) as $comp)
                            <span style="background:#E8F0F9;color:#1A4B7A;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                                {{ trim($comp) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ACTIONS — Like, Favori, Signalement --}}
            @auth
            {{-- ACTIONS — Like, Favori, Partager, Signalement, Note, Commentaires --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">

            {{-- BOUTONS PRINCIPAUX --}}
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:16px;">

                {{-- LIKE --}}
                @php
                    $likeCount = $offre->likes()->count();
                    $liked = auth()->check() && $offre->likes()->where('user_id', Auth::id())->exists();
                @endphp
                @auth
                    <form method="POST" action="{{ route('like.toggle') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="type" value="offre">
                        <input type="hidden" name="id" value="{{ $offre->id }}">
                        <button type="submit" style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid {{ $liked ? '#c0392b' : '#E2E8F0' }};background:{{ $liked ? '#fdecea' : '#fff' }};color:{{ $liked ? '#c0392b' : '#5a6a7a' }};cursor:pointer;font-size:13px;font-weight:600;">
                            {{ $liked ? '❤️' : '🤍' }} {{ $likeCount }} J'aime
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:#fff;color:#5a6a7a;font-size:13px;font-weight:600;text-decoration:none;">
                        🤍 {{ $likeCount }} J'aime
                    </a>
                @endauth

                {{-- FAVORI --}}
                @php
                    $saved = auth()->check() && $offre->favoris()->where('user_id', Auth::id())->exists();
                    $favoriCount = $offre->favoris()->count();
                @endphp
                @auth
                    <form method="POST" action="{{ route('favori.toggle') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="type" value="offre">
                        <input type="hidden" name="id" value="{{ $offre->id }}">
                        <button type="submit" style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid {{ $saved ? '#F0A500' : '#E2E8F0' }};background:{{ $saved ? '#FEF3DC' : '#fff' }};color:{{ $saved ? '#7A4500' : '#5a6a7a' }};cursor:pointer;font-size:13px;font-weight:600;">
                            {{ $saved ? '🔖' : '📌' }} {{ $favoriCount }} Favoris
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:#fff;color:#5a6a7a;font-size:13px;font-weight:600;text-decoration:none;">
                        📌 {{ $favoriCount }} Favoris
                    </a>
                @endauth

                {{-- PARTAGER --}}
                <button onclick="partager('{{ $offre->titre }}', '{{ url()->current() }}')"
                    style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:#fff;color:#5a6a7a;cursor:pointer;font-size:13px;font-weight:600;">
                    🔗 Partager
                </button>

                {{-- SIGNALEMENT --}}
                @auth
                    @if(Auth::id() !== $offre->user_id)
                        <button onclick="document.getElementById('modal-signalement-offre').style.display='flex'"
                            style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:#fff;color:#5a6a7a;cursor:pointer;font-size:13px;font-weight:600;">
                            🚩 Signaler
                        </button>
                    @endif
                @endauth

            </div>

            {{-- NOTE --}}
            @php
                $moyenneNote = $offre->notes()->avg('valeur');
                $totalNotes  = $offre->notes()->count();
                $maNote      = auth()->check() ? $offre->notes()->where('user_id', Auth::id())->first() : null;
            @endphp
            <div style="padding-top:14px;border-top:1px solid #E2E8F0;">
                <div style="font-size:13px;font-weight:600;color:#0D2137;margin-bottom:10px;">
                    ⭐ Note moyenne :
                    <strong style="color:#F0A500;">{{ $moyenneNote ? number_format($moyenneNote, 1) : 'Aucune' }}</strong>
                    @if($totalNotes > 0)
                        <span style="font-size:12px;color:#5a6a7a;font-weight:400;">({{ $totalNotes }} avis)</span>
                    @endif
                </div>
                @auth
                    @if(Auth::id() !== $offre->user_id)
                        <form method="POST" action="{{ route('note.store') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            @csrf
                            <input type="hidden" name="type" value="offre">
                            <input type="hidden" name="id" value="{{ $offre->id }}">
                            <div style="display:flex;gap:6px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <label style="cursor:pointer;font-size:22px;">
                                        <input type="radio" name="valeur" value="{{ $i }}" {{ $maNote?->valeur == $i ? 'checked' : '' }} style="display:none;">
                                        <span style="color:{{ ($maNote?->valeur ?? 0) >= $i ? '#F0A500' : '#E2E8F0' }};">★</span>
                                    </label>
                                @endfor
                            </div>
                            <button type="submit" style="padding:7px 14px;border-radius:8px;border:none;background:#F0A500;color:#0D2137;font-size:12px;font-weight:700;cursor:pointer;">
                                {{ $maNote ? 'Modifier' : 'Noter' }}
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" style="font-size:13px;color:#1A9B5A;font-weight:600;">
                        Connectez-vous pour noter
                    </a>
                @endauth
            </div>

        </div>

        {{-- COMMENTAIRES --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
            <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:16px;">
                💬 Commentaires ({{ $offre->commentaires()->count() }})
            </h2>

            {{-- Formulaire --}}
            @auth
                @if(session('success'))
                    <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#0A6B3A;">
                        ✓ {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('commentaire.store') }}" style="margin-bottom:20px;">
                    @csrf
                    <input type="hidden" name="type" value="offre">
                    <input type="hidden" name="id" value="{{ $offre->id }}">
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:36px;height:36px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div style="flex:1;">
                            <textarea name="contenu" rows="2" maxlength="500"
                                placeholder="Laissez un commentaire..."
                                style="width:100%;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;outline:none;resize:vertical;">{{ old('contenu') }}</textarea>
                            @error('contenu')
                                <div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>
                            @enderror
                            <button type="submit" style="margin-top:8px;background:#1A4B7A;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                                Publier
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div style="background:#F4F6F9;border-radius:8px;padding:14px;margin-bottom:20px;text-align:center;font-size:13px;color:#5a6a7a;">
                    <a href="{{ route('login') }}" style="color:#1A9B5A;font-weight:700;">Connectez-vous</a> pour laisser un commentaire.
                </div>
            @endauth

            {{-- Liste --}}
            @php $commentaires = $offre->commentaires()->with('user.profile')->latest()->get(); @endphp

            @if($commentaires->count() > 0)
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach($commentaires as $commentaire)
                        <div style="display:flex;gap:12px;align-items:flex-start;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#0D2137;flex-shrink:0;">
                                {{ strtoupper(substr($commentaire->user->profile->nom ?? 'U', 0, 1)) }}
                            </div>
                            <div style="flex:1;background:#F4F6F9;border-radius:8px;padding:12px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                    <div>
                                        <span style="font-size:13px;font-weight:700;color:#0D2137;">
                                            {{ $commentaire->user->profile->nom ?? '' }} {{ $commentaire->user->profile->prenom ?? '' }}
                                        </span>
                                        <span style="font-size:11px;color:#5a6a7a;margin-left:8px;">
                                            {{ $commentaire->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    @auth
                                        @if($commentaire->user_id === Auth::id())
                                            <form method="POST" action="{{ route('commentaire.destroy', $commentaire->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="background:transparent;border:none;color:#c0392b;cursor:pointer;font-size:12px;">🗑</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p style="font-size:13px;color:#444;line-height:1.6;margin:0;">{{ $commentaire->contenu }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:24px;color:#5a6a7a;font-size:13px;">
                    Aucun commentaire pour l'instant. Soyez le premier !
                </div>
            @endif
        </div>
        @endauth
        {{-- COLONNE DROITE --}}
        <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:84px;">

            {{-- CARTE POSTULER --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-top:4px solid #1A9B5A;">
                <h3 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">Détails de l'offre</h3>

                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:16px;">
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#5a6a7a;">Budget</span>
                        <span style="font-weight:700;color:#1A9B5A;">
                            {{ $offre->budget ? number_format($offre->budget, 0, ',', ' ').' GNF' : 'À négocier' }}
                        </span>
                    </div>
                    @if($offre->duree)
                        <div style="display:flex;justify-content:space-between;font-size:13px;">
                            <span style="color:#5a6a7a;">Durée</span>
                            <span style="font-weight:600;color:#0D2137;">{{ $offre->duree }}</span>
                        </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#5a6a7a;">Candidatures</span>
                        <span style="font-weight:600;color:#0D2137;">{{ $offre->candidatures->count() }} reçues</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#5a6a7a;">Publiée</span>
                        <span style="font-weight:600;color:#0D2137;">{{ $offre->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                @auth
                    @if(Auth::user()->isOffreur() && $offre->statut === 'active')
                        <form method="POST" action="{{ route('candidature.store') }}">
                            @csrf
                            <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                            <div style="margin-bottom:12px;">
                                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                                    Message de motivation <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                                </label>
                                <textarea name="message" rows="3" maxlength="1000"
                                    placeholder="Présentez-vous brièvement..."
                                    style="width:100%;padding:10px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;outline:none;resize:vertical;"></textarea>
                            </div>
                            @if($errors->any())
                                <div style="background:#fdecea;border-radius:6px;padding:8px 12px;margin-bottom:10px;font-size:12px;color:#c0392b;">
                                    @foreach($errors->all() as $error)
                                        <div>⚠ {{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            @if(session('success'))
                                <div style="background:#E6F7EE;border-radius:6px;padding:8px 12px;margin-bottom:10px;font-size:12px;color:#0A6B3A;">
                                    ✓ {{ session('success') }}
                                </div>
                            @endif
                            <button type="submit"
                                style="width:100%;background:#1A9B5A;color:#fff;border:none;padding:13px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                                🚀 Postuler à cette offre
                            </button>
                        </form>
                    @elseif($offre->statut === 'cloturee')
                        <div style="background:#f0f0f0;border-radius:8px;padding:14px;text-align:center;font-size:13px;color:#888;font-weight:600;">
                            🔒 Cette offre est clôturée
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                        🔒 Se connecter pour postuler
                    </a>
                    <p style="text-align:center;font-size:12px;color:#5a6a7a;margin-top:10px;">
                        Pas de compte ? <a href="{{ route('register') }}" style="color:#1A9B5A;font-weight:700;">S'inscrire →</a>
                    </p>
                @endauth
            </div>

        </div>
    </div>
</div>

{{-- MODAL SIGNALEMENT OFFRE --}}
@auth
<div id="modal-signalement-offre" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:28px;width:100%;max-width:440px;margin:20px;">
        <h3 style="font-size:18px;font-weight:700;color:#c0392b;margin-bottom:6px;">Signaler cette offre</h3>
        <p style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">Décrivez le problème. L'administrateur examinera votre signalement.</p>
        <form method="POST" action="{{ route('signalement.store') }}">
            @csrf
            <input type="hidden" name="cible_type" value="offre">
            <input type="hidden" name="cible_id" value="{{ $offre->id }}">
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                    Motif <span style="color:#c0392b;">*</span>
                    <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(minimum 10 caractères)</span>
                </label>
                <textarea name="motif" rows="4" maxlength="500"
                    placeholder="Décrivez pourquoi vous signalez cette offre..."
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="flex:1;background:#c0392b;color:#fff;border:none;padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                    Envoyer le signalement
                </button>
                <button type="button" onclick="document.getElementById('modal-signalement-offre').style.display='none'"
                    style="flex:1;background:transparent;color:#5a6a7a;border:1.5px solid #E2E8F0;padding:12px;border-radius:8px;font-size:14px;cursor:pointer;">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@push('scripts')
<script>
// Partage
function partager(titre, url) {
    if (navigator.share) {
        navigator.share({ title: titre, url: url });
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Lien copié dans le presse-papiers !');
        });
    }
}

// Notation interactive
document.querySelectorAll('input[name="valeur"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const valeur = parseInt(this.value);
        document.querySelectorAll('input[name="valeur"]').forEach((r, i) => {
            r.nextElementSibling.style.color = (i + 1) <= valeur ? '#F0A500' : '#E2E8F0';
        });
    });
});

document.querySelectorAll('label:has(input[name="valeur"])').forEach((label, index) => {
    label.addEventListener('mouseenter', function() {
        document.querySelectorAll('input[name="valeur"]').forEach((r, i) => {
            r.nextElementSibling.style.color = (i <= index) ? '#F0A500' : '#E2E8F0';
        });
    });

    label.addEventListener('mouseleave', function() {
        const checked = document.querySelector('input[name="valeur"]:checked');
        const valeur = checked ? parseInt(checked.value) : 0;
        document.querySelectorAll('input[name="valeur"]').forEach((r, i) => {
            r.nextElementSibling.style.color = (i + 1) <= valeur ? '#F0A500' : '#E2E8F0';
        });
    });
});
</script>
@endpush

@endsection