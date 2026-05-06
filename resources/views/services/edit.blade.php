@extends('layouts.app')
@section('title', 'Modifier le service')

@section('content')
<div style="display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px 12px;">
        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid #E2E8F0;">
            <div style="width:48px;height:48px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#0D2137;margin:0 auto 8px;">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}
            </div>
            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ Auth::user()->profile->nom ?? '' }}</div>
            <div style="font-size:11px;color:#5a6a7a;">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🏠 Tableau de bord</a>
        <a href="{{ route('profil.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">👤 Mon profil</a>
        <a href="{{ route('service.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#0D2137;font-weight:700;background:#E8F0F9;text-decoration:none;">🛠️ Mes services</a>
        <a href="{{ route('candidature.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">📩 Mes candidatures</a>
    </div>

    {{-- CONTENU --}}
    <div style="padding:28px;background:#F4F6F9;">

        {{-- FIL D'ARIANE --}}
        <div style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">
            <a href="{{ route('dashboard') }}" style="color:#1A4B7A;">Tableau de bord</a> ›
            <span style="color:#0D2137;font-weight:600;">Modifier le service</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Modifier le service</h1>
                <p style="font-size:13px;color:#5a6a7a;">Mettez à jour les informations de votre service</p>
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

            <form method="POST" action="{{ route('service.update', $service->id) }}">
                @csrf
                @method('PUT')

                {{-- TITRE --}}
                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Titre du service <span style="color:#c0392b;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre', $service->titre) }}"
                        maxlength="200"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                </div>

                {{-- CATÉGORIE --}}
                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Catégorie <span style="color:#c0392b;">*</span></label>
                    <select name="categorie_id"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id', $service->categorie_id) == $cat->id ? 'selected' : '' }}>
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
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;">{{ old('description', $service->description) }}</textarea>
                </div>

                {{-- TARIF --}}
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:14px;margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Tarif (GNF)</label>
                        <input type="number" name="tarif" value="{{ old('tarif', $service->tarif) }}"
                            min="0"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Unité</label>
                        <select name="unite_tarif"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                            @foreach(['/ heure', '/ jour', '/ projet', '/ séance'] as $unite)
                                <option value="{{ $unite }}" {{ old('unite_tarif', $service->devise) === $unite ? 'selected' : '' }}>
                                    {{ $unite }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- STATUT --}}
                <div style="margin-bottom:24px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:10px;">Statut</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <label style="border:2px solid {{ old('statut', $service->statut) === 'actif' ? '#1A9B5A' : '#E2E8F0' }};border-radius:8px;padding:14px;cursor:pointer;background:{{ old('statut', $service->statut) === 'actif' ? '#E6F7EE' : '#fff' }};">
                            <input type="radio" name="statut" value="actif" {{ old('statut', $service->statut) === 'actif' ? 'checked' : '' }} style="display:none;">
                            <div style="font-size:13px;font-weight:700;color:#0A6B3A;margin-bottom:4px;">✓ Actif</div>
                            <div style="font-size:11px;color:#0A6B3A;">Visible dans les résultats</div>
                        </label>
                        <label style="border:2px solid {{ old('statut', $service->statut) === 'suspendu' ? '#1A9B5A' : '#E2E8F0' }};border-radius:8px;padding:14px;cursor:pointer;background:{{ old('statut', $service->statut) === 'suspendu' ? '#E6F7EE' : '#fff' }};">
                            <input type="radio" name="statut" value="suspendu" {{ old('statut', $service->statut) === 'suspendu' ? 'checked' : '' }} style="display:none;">
                            <div style="font-size:13px;font-weight:700;color:#5a6a7a;margin-bottom:4px;">⏸ Suspendu</div>
                            <div style="font-size:11px;color:#5a6a7a;">Non visible publiquement</div>
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