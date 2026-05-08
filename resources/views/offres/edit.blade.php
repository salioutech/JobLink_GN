@extends('layouts.app')
@section('title', 'Modifier l\'offre')

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
        <div style="margin-top:auto;padding-top:16px;border-top:1px solid #E2E8F0;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#c0392b;background:transparent;border:none;cursor:pointer;width:100%;">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- CONTENU --}}
    <div style="padding:28px;background:#F4F6F9;">

        <div style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">
            <a href="{{ route('dashboard') }}" style="color:#1A4B7A;">Tableau de bord</a> ›
            <span style="color:#0D2137;font-weight:600;">Modifier l'offre</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Modifier l'offre</h1>
                <p style="font-size:13px;color:#5a6a7a;">Mettez à jour les informations de votre offre</p>
            </div>
            <a href="{{ route('dashboard') }}" style="font-size:13px;color:#5a6a7a;text-decoration:none;">← Retour</a>
        </div>

        <div style="max-width:680px;background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:28px;">

            @if($errors->any())
                <div style="background:#fdecea;border-left:4px solid #c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                        <div style="font-size:13px;color:#7b1c1c;">⚠ {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('offre.update', $offre->id) }}">
                @csrf
                @method('PUT')

                {{-- TYPE --}}
                <div style="margin-bottom:20px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:10px;">Type d'offre <span style="color:#c0392b;">*</span></label>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                        @foreach([
                            'emploi'          => ['💼', 'Emploi'],
                            'mission'         => ['🎯', 'Mission'],
                            'demande_service' => ['🛠️', 'Demande de service'],
                        ] as $val => $info)
                            <label style="border:2px solid {{ old('type', $offre->type) === $val ? '#1A4B7A' : '#E2E8F0' }};border-radius:10px;padding:12px;cursor:pointer;background:{{ old('type', $offre->type) === $val ? '#E8F0F9' : '#fff' }};text-align:center;">
                                <input type="radio" name="type" value="{{ $val }}" {{ old('type', $offre->type) === $val ? 'checked' : '' }} style="display:none;">
                                <div style="font-size:20px;margin-bottom:6px;">{{ $info[0] }}</div>
                                <div style="font-size:12px;font-weight:700;color:#0D2137;">{{ $info[1] }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">

                {{-- TITRE --}}
                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Titre <span style="color:#c0392b;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre', $offre->titre) }}"
                        maxlength="200"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                </div>

                {{-- CATÉGORIE --}}
                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Catégorie <span style="color:#c0392b;">*</span></label>
                    <select name="categorie_id" style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id', $offre->categorie_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                        Description <span style="color:#c0392b;">*</span>
                        <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(minimum 50 caractères)</span>
                    </label>
                    <textarea name="description" rows="5" maxlength="1000"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;">{{ old('description', $offre->description) }}</textarea>
                </div>

                {{-- COMPÉTENCES --}}
                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Compétences requises</label>
                    <input type="text" name="competences_requises" value="{{ old('competences_requises', $offre->competences_requises) }}"
                        placeholder="Ex: Laravel, PHP, MySQL..."
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                </div>

                {{-- BUDGET + DURÉE --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Budget (GNF)</label>
                        <input type="number" name="budget" value="{{ old('budget', $offre->budget) }}"
                            min="0"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Durée</label>
                        <input type="text" name="duree" value="{{ old('duree', $offre->duree) }}"
                            placeholder="Ex: 3 mois..."
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                </div>

                {{-- STATUT --}}
                <div style="margin-bottom:24px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:10px;">Statut</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <label style="border:2px solid {{ old('statut', $offre->statut) === 'active' ? '#1A9B5A' : '#E2E8F0' }};border-radius:8px;padding:14px;cursor:pointer;background:{{ old('statut', $offre->statut) === 'active' ? '#E6F7EE' : '#fff' }};">
                            <input type="radio" name="statut" value="active" {{ old('statut', $offre->statut) === 'active' ? 'checked' : '' }} style="display:none;">
                            <div style="font-size:13px;font-weight:700;color:#0A6B3A;margin-bottom:4px;">✓ Active</div>
                            <div style="font-size:11px;color:#0A6B3A;">Visible et reçoit des candidatures</div>
                        </label>
                        <label style="border:2px solid {{ old('statut', $offre->statut) === 'cloturee' ? '#1A9B5A' : '#E2E8F0' }};border-radius:8px;padding:14px;cursor:pointer;background:{{ old('statut', $offre->statut) === 'cloturee' ? '#E6F7EE' : '#fff' }};">
                            <input type="radio" name="statut" value="cloturee" {{ old('statut', $offre->statut) === 'cloturee' ? 'checked' : '' }} style="display:none;">
                            <div style="font-size:13px;font-weight:700;color:#5a6a7a;margin-bottom:4px;">🔒 Clôturée</div>
                            <div style="font-size:11px;color:#5a6a7a;">Ne reçoit plus de candidatures</div>
                        </label>
                    </div>
                </div>

                <div style="display:flex;gap:12px;">
                    <button type="submit"
                        style="flex:1;background:#1A9B5A;color:#fff;border:none;padding:14px;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;">
                        💾 Enregistrer les modifications
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
@endsection