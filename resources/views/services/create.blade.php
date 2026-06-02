@extends('layouts.app')
@section('title', 'Publier un service')

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
            <span style="color:#0D2137;font-weight:600;">Publier un service</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Publier un nouveau service</h1>
                <p style="font-size:13px;color:#5a6a7a;">Décrivez votre service pour être visible dans les résultats de recherche</p>
            </div>
            <a href="{{ route('dashboard') }}" style="font-size:13px;color:#5a6a7a;text-decoration:none;">← Retour</a>
        </div>

        {{-- FORMULAIRE --}}
        <div style="max-width:680px;background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:28px;">

            {{-- ERREURS --}}
            @if($errors->any())
                <div style="background:#fdecea;border-left:4px solid #c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                        <div style="font-size:13px;color:#7b1c1c;">⚠ {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('service.store') }}">
                @csrf

                {{-- SECTION 1 --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">1</span>
                    Informations générales
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Titre du service <span style="color:#c0392b;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                        placeholder="Ex: Développement web Laravel sur mesure"
                        maxlength="200"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">Maximum 200 caractères</div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Catégorie <span style="color:#c0392b;">*</span></label>
                    <select name="categorie_id"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        <option value="">-- Sélectionnez une catégorie --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                        Description <span style="color:#c0392b;">*</span>
                        <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(minimum 50 caractères)</span>
                    </label>
                    <textarea name="description" rows="5" maxlength="1000"
                        placeholder="Décrivez votre service en détail..."
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;resize:vertical;">{{ old('description') }}</textarea>
                </div>

                <hr style="border:none;border-top:1px solid #E2E8F0;margin:20px 0;">

                {{-- SECTION 2 --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">2</span>
                    Tarification
                </div>

                <div style="display:grid;grid-template-columns:2fr 1fr;gap:14px;margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Tarif (GNF)</label>
                        <input type="number" name="tarif" value="{{ old('tarif') }}"
                            placeholder="Ex: 500000" min="0"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                    <div>
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Unité</label>
                        <select name="unite_tarif"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                            <option value="/ heure">/ heure</option>
                            <option value="/ jour">/ jour</option>
                            <option value="/ projet">/ projet</option>
                            <option value="/ séance">/ séance</option>
                        </select>
                    </div>
                </div>

                {{-- <div style="background:#E8F0F9;border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:12px;color:#1A4B7A;line-height:1.6;">
                    💡 <strong>Conseil :</strong> Indiquez un tarif indicatif. Vous pourrez toujours négocier avec le client une fois en contact.
                </div> --}}

                <hr style="border:none;border-top:1px solid #E2E8F0;margin:20px 0;">

                {{-- SECTION 3 --}}
                <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">3</span>
                    Publication
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px;">
                    <label id="statut-actif" style="border:2px solid #1A9B5A;border-radius:8px;padding:14px;cursor:pointer;background:#E6F7EE;">
                        <input type="radio" name="statut" value="actif" checked style="display:none;">
                        <div style="font-size:13px;font-weight:700;color:#0A6B3A;margin-bottom:4px;">✓ Publier maintenant</div>
                        <div style="font-size:11px;color:#0A6B3A;line-height:1.5;">Visible immédiatement dans les résultats</div>
                    </label>
                    <label id="statut-inactif" style="border:2px solid #E2E8F0;border-radius:8px;padding:14px;cursor:pointer;background:#fff;">
                        <input type="radio" name="statut" value="inactif" style="display:none;">
                        <div style="font-size:13px;font-weight:700;color:#5a6a7a;margin-bottom:4px;">⏸ Sauvegarder en brouillon</div>
                        <div style="font-size:11px;color:#5a6a7a;line-height:1.5;">Non visible publiquement</div>
                    </label>
                </div>

                <div style="display:flex;gap:12px;">
                    <button type="submit"
                        style="flex:1;background:#1A9B5A;color:#fff;border:none;padding:14px;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;">
                        🚀 Publier le service
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
document.querySelectorAll('input[name="statut"]').forEach(radio => {
    radio.closest('label').addEventListener('click', function() {
        document.getElementById('statut-actif').style.border = '2px solid #E2E8F0';
        document.getElementById('statut-actif').style.background = '#fff';
        document.getElementById('statut-inactif').style.border = '2px solid #E2E8F0';
        document.getElementById('statut-inactif').style.background = '#fff';
        this.style.border = '2px solid #1A9B5A';
        this.style.background = '#E6F7EE';
    });
});
</script>
@endpush

@endsection