@extends('layouts.app')
@section('title', 'Publier une offre')

@section('content')
<div style="display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px 12px;display:flex;flex-direction:column;gap:4px;">
        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid #E2E8F0;">
            <div style="width:48px;height:48px;border-radius:50%;background:#1A4B7A;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;margin:0 auto 8px;">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}
            </div>
            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ Auth::user()->profile->nom ?? '' }}</div>
            <div style="font-size:11px;color:#5a6a7a;">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🏠 Tableau de bord</a>
        <a href="{{ route('profil.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">👤 Mon profil</a>
        <a href="{{ route('offre.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">📢 Mes offres</a>
        <a href="{{ route('candidature.received') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">👥 Candidatures reçues</a>
        <a href="{{ route('search') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🔍 Rechercher des talents</a>
        <div style="margin-top:auto;padding-top:16px;border-top:1px solid #E2E8F0;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#c0392b;background:transparent;border:none;cursor:pointer;width:100%;">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- CONTENU --}}
    <div style="padding:28px;background:#F4F6F9;">

        {{-- FIL D'ARIANE --}}
        <div style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">
            <a href="{{ route('dashboard') }}" style="color:#1A4B7A;">Tableau de bord</a> ›
            <span style="color:#0D2137;font-weight:600;">Publier une offre</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Publier une nouvelle offre</h1>
                <p style="font-size:13px;color:#5a6a7a;">Décrivez votre besoin pour recevoir des candidatures</p>
            </div>
            <a href="{{ route('dashboard') }}" style="font-size:13px;color:#5a6a7a;text-decoration:none;">← Retour</a>
        </div>

        <div style="max-width:680px;background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:28px;">

            {{-- ERREURS --}}
            @if($errors->any())
                <div style="background:#fdecea;border-left:4px solid #c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                        <div style="font-size:13px;color:#7b1c1c;">⚠ {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('offre.store') }}">
                @csrf

                {{-- SECTION 1 — Type d'offre --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">1</span>
                    Type d'offre
                </div>

                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;">
                    @foreach([
                        ['emploi', '💼', 'Emploi', 'Poste permanent ou CDD'],
                        ['mission', '🎯', 'Mission', 'Projet ponctuel défini'],
                        ['demande_service', '🛠️', 'Demande de service', 'Besoin ponctuel'],
                    ] as $type)
                        <label style="border:2px solid {{ old('type') === $type[0] ? '#1A4B7A' : '#E2E8F0' }};border-radius:10px;padding:14px;cursor:pointer;background:{{ old('type') === $type[0] ? '#E8F0F9' : '#fff' }};text-align:center;">
                            <input type="radio" name="type" value="{{ $type[0] }}" {{ old('type') === $type[0] ? 'checked' : '' }} style="display:none;">
                            <div style="font-size:24px;margin-bottom:8px;">{{ $type[1] }}</div>
                            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ $type[2] }}</div>
                            <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">{{ $type[3] }}</div>
                        </label>
                    @endforeach
                </div>
                @error('type')<div style="font-size:12px;color:#c0392b;margin-bottom:16px;">⚠ {{ $message }}</div>@enderror

                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">

                {{-- SECTION 2 — Informations --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">2</span>
                    Informations générales
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Titre de l'offre <span style="color:#c0392b;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                        placeholder="Ex: Développeur PHP Laravel — Mission 3 mois"
                        maxlength="200"
                        style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('titre') ? '#c0392b' : '#E2E8F0' }};border-radius:8px;font-size:14px;outline:none;">
                    @error('titre')<div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Catégorie <span style="color:#c0392b;">*</span></label>
                    <select name="categorie_id"
                        style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('categorie_id') ? '#c0392b' : '#E2E8F0' }};border-radius:8px;font-size:14px;outline:none;">
                        <option value="">-- Sélectionnez une catégorie --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')<div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                        Description <span style="color:#c0392b;">*</span>
                        <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(minimum 50 caractères)</span>
                    </label>
                    <textarea name="description" rows="5" maxlength="1000"
                        placeholder="Décrivez votre besoin en détail..."
                        style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('description') ? '#c0392b' : '#E2E8F0' }};border-radius:8px;font-size:14px;outline:none;resize:vertical;">{{ old('description') }}</textarea>
                    @error('description')<div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                        Compétences requises <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                    </label>
                    <input type="text" name="competences_requises" value="{{ old('competences_requises') }}"
                        placeholder="Ex: Laravel, PHP, MySQL..."
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                </div>

                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">

                {{-- SECTION 3 — Budget et durée --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">3</span>
                    Budget et durée
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                            Budget (GNF) <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                        </label>
                        <input type="number" name="budget" value="{{ old('budget') }}"
                            placeholder="Ex: 1500000" min="0"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Laissez vide pour "À négocier"</div>
                    </div>
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                            Durée <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                        </label>
                        <input type="text" name="duree" value="{{ old('duree') }}"
                            placeholder="Ex: 3 mois, 1 semaine, CDI..."
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                </div>

                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">

                {{-- SECTION 4 — Publication --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">4</span>
                    Publication
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px;">
                    <label style="border:2px solid #1A9B5A;border-radius:8px;padding:14px;cursor:pointer;background:#E6F7EE;">
                        <input type="radio" name="statut" value="active" checked style="display:none;">
                        <div style="font-size:13px;font-weight:700;color:#0A6B3A;margin-bottom:4px;">✓ Publier maintenant</div>
                        <div style="font-size:11px;color:#0A6B3A;line-height:1.5;">Visible et recevra des candidatures immédiatement</div>
                    </label>
                    <label style="border:2px solid #E2E8F0;border-radius:8px;padding:14px;cursor:pointer;background:#fff;">
                        <input type="radio" name="statut" value="cloturee" style="display:none;">
                        <div style="font-size:13px;font-weight:700;color:#5a6a7a;margin-bottom:4px;">⏸ Sauvegarder en brouillon</div>
                        <div style="font-size:11px;color:#5a6a7a;line-height:1.5;">Non visible publiquement</div>
                    </label>
                </div>

                <div style="display:flex;gap:12px;">
                    <button type="submit"
                        style="flex:1;background:#1A4B7A;color:#fff;border:none;padding:14px;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;">
                        🚀 Publier l'offre
                    </button>
                    <a href="{{ route('dashboard') }}"
                        style="background:transparent;color:#5a6a7a;border:1.5px solid #E2E8F0;padding:14px 20px;border-radius:8px;font-size:14px;text-decoration:none;">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sélection type d'offre
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.closest('label').addEventListener('click', function() {
        document.querySelectorAll('input[name="type"]').forEach(r => {
            const lbl = r.closest('label');
            lbl.style.border = '2px solid #E2E8F0';
            lbl.style.background = '#fff';
        });
        this.style.border = '2px solid #1A4B7A';
        this.style.background = '#E8F0F9';
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// Sélection statut publication
document.querySelectorAll('input[name="statut"]').forEach(radio => {
    radio.closest('label').addEventListener('click', function() {
        document.querySelectorAll('input[name="statut"]').forEach(r => {
            const lbl = r.closest('label');
            lbl.style.border = '2px solid #E2E8F0';
            lbl.style.background = '#fff';
        });
        this.style.border = '2px solid #1A9B5A';
        this.style.background = '#E6F7EE';
        this.querySelector('input[type="radio"]').checked = true;
    });
});
</script>
@endpush

@endsection