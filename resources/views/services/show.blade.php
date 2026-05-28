@extends('layouts.app')
@section('title', $service->titre)

@section('content')

{{-- FIL D'ARIANE --}}
<div style="background:#fff;padding:12px 28px;border-bottom:1px solid #E2E8F0;font-size:13px;color:#5a6a7a;">
    <a href="{{ route('home') }}" style="color:#1A4B7A;">Accueil</a> ›
    <a href="{{ route('search') }}" style="color:#1A4B7A;">Services</a> ›
    <span style="color:#0D2137;font-weight:600;">{{ $service->titre }}</span>
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
                        {{ $service->categorie->nom ?? '' }}
                    </span>
                    <span style="background:{{ $service->statut === 'actif' ? '#E6F7EE' : '#f0f0f0' }};color:{{ $service->statut === 'actif' ? '#0A6B3A' : '#888' }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                        {{ $service->statut === 'actif' ? '✓ Disponible' : '⏸ Indisponible' }}
                    </span>
                    <span style="font-size:12px;color:#5a6a7a;">{{ $service->created_at->diffForHumans() }}</span>
                </div>

                <h1 style="font-size:22px;font-weight:700;color:#0D2137;margin-bottom:16px;">{{ $service->titre }}</h1>

                <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                    <a href="{{ route('profil.show', $service->user_id) }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
                        <div style="width:38px;height:38px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#0D2137;">
                            {{ strtoupper(substr($service->user->profile->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#0D2137;">{{ $service->user->profile->nom ?? '' }} {{ $service->user->profile->prenom ?? '' }}</div>
                            <div style="font-size:12px;color:#5a6a7a;">{{ ucfirst($service->user->role) }}</div>
                        </div>
                    </a>
                    <span style="font-size:13px;color:#5a6a7a;">📍 {{ $service->user->profile->localisation ?? 'Conakry' }}</span>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                <h2 style="font-size:16px;font-weight:700;color:#0D2137;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #1A9B5A;display:inline-block;">Description du service</h2>
                <p style="font-size:14px;color:#444;line-height:1.8;">{{ $service->description }}</p>
            </div>

            {{-- ACTIONS — Like, Favori, Partager, Signalement, Note, Commentaires --}}
            @auth
        <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;">

            {{-- BOUTONS PRINCIPAUX --}}
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:16px;">

                {{-- LIKE --}}
                @php
                    $likeCount = $service->likes()->count();
                    $liked = auth()->check() && $service->likes()->where('user_id', Auth::id())->exists();
                @endphp
                @auth
                    <form method="POST" action="{{ route('like.toggle') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="type" value="service">
                        <input type="hidden" name="id" value="{{ $service->id }}">
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
                    $saved = auth()->check() && $service->favoris()->where('user_id', Auth::id())->exists();
                    $favoriCount = $service->favoris()->count();
                @endphp
                @auth
                    <form method="POST" action="{{ route('favori.toggle') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="type" value="service">
                        <input type="hidden" name="id" value="{{ $service->id }}">
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
                <button onclick="partager('{{ $service->titre }}', '{{ url()->current() }}')"
                    style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:#fff;color:#5a6a7a;cursor:pointer;font-size:13px;font-weight:600;">
                    🔗 Partager
                </button>

                {{-- SIGNALEMENT --}}
                @auth
                    @if(Auth::id() !== $service->user_id)
                        <button onclick="document.getElementById('modal-signalement-service').style.display='flex'"
                            style="display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:#fff;color:#5a6a7a;cursor:pointer;font-size:13px;font-weight:600;">
                            🚩 Signaler
                        </button>
                    @endif
                @endauth

            </div>

            {{-- NOTE --}}
            @php
                $moyenneNote = $service->notes()->avg('valeur');
                $totalNotes  = $service->notes()->count();
                $maNote      = auth()->check() ? $service->notes()->where('user_id', Auth::id())->first() : null;
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
                    @if(Auth::id() !== $service->user_id)
                        <form method="POST" action="{{ route('note.store') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            @csrf
                            <input type="hidden" name="type" value="service">
                            <input type="hidden" name="id" value="{{ $service->id }}">
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
                💬 Commentaires ({{ $service->commentaires()->count() }})
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
                    <input type="hidden" name="type" value="service">
                    <input type="hidden" name="id" value="{{ $service->id }}">
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
            @php $commentaires = $service->commentaires()->with('user.profile')->latest()->get(); @endphp

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

            <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;border-top:4px solid #1A9B5A;">
                <h3 style="font-size:15px;font-weight:700;color:#0D2137;margin-bottom:16px;">Tarif & Contact</h3>

                <div style="margin-bottom:16px;">
                    <div style="font-size:24px;font-weight:700;color:#1A9B5A;margin-bottom:4px;">
                        {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' GNF' : 'À négocier' }}
                    </div>
                    <div style="font-size:12px;color:#5a6a7a;">Tarif indicatif</div>
                </div>

                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:16px;">

                @auth
                    @if(Auth::id() !== $service->user_id)
                        <a href="{{ route('profil.show', $service->user_id) }}"
                            style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;margin-bottom:10px;">
                            ✉ Contacter le prestataire
                        </a>
                        @if($service->user->profile->telephone)
                            <a href="https://wa.me/224{{ preg_replace('/[^0-9]/', '', $service->user->profile->telephone) }}"
                                target="_blank"
                                style="display:flex;align-items:center;justify-content:center;gap:8px;background:#25D366;color:#fff;padding:12px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WhatsApp
                            </a>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        style="display:block;text-align:center;background:#1A9B5A;color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">
                        🔒 Se connecter pour contacter
                    </a>
                @endauth
            </div>

        </div>
    </div>
</div>

{{-- MODAL SIGNALEMENT SERVICE --}}
@auth
<div id="modal-signalement-service" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:28px;width:100%;max-width:440px;margin:20px;">
        <h3 style="font-size:18px;font-weight:700;color:#c0392b;margin-bottom:6px;">Signaler ce service</h3>
        <p style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">Décrivez le problème. L'administrateur examinera votre signalement.</p>
        <form method="POST" action="{{ route('signalement.store') }}">
            @csrf
            <input type="hidden" name="cible_type" value="service">
            <input type="hidden" name="cible_id" value="{{ $service->id }}">
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                    Motif <span style="color:#c0392b;">*</span>
                    <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(minimum 10 caractères)</span>
                </label>
                <textarea name="motif" rows="4" maxlength="500"
                    placeholder="Décrivez pourquoi vous signalez ce service..."
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit"
                    style="flex:1;background:#c0392b;color:#fff;border:none;padding:12px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                    Envoyer le signalement
                </button>
                <button type="button" onclick="document.getElementById('modal-signalement-service').style.display='none'"
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