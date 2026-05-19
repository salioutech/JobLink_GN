@extends('layouts.app')
@section('title', 'Inscription')

@section('content')
<div style="background:linear-gradient(135deg,#0D2137,#1A4B7A);padding:28px;text-align:center;">
    <div style="display:inline-block;background:#F0A500;color:#0D2137;font-size:11px;font-weight:700;padding:4px 14px;border-radius:20px;margin-bottom:10px;">🇬🇳 Inscription gratuite</div>
    <h1 style="color:#fff;font-size:22px;font-weight:700;margin-bottom:6px;">Créez votre compte JobLinkGN</h1>
    <p style="color:#B5C8D8;font-size:13px;">Rejoignez la première plateforme guinéenne de mise en relation.</p>
</div>

<div style="max-width:580px;margin:28px auto 32px;background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:28px;box-shadow:0 2px 16px rgba(0,0,0,0.06);">

    @if($errors->any())
        <div class="alert-error">
            <ul style="list-style:none;padding:0;">
                @foreach($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        {{-- CHOIX DU RÔLE --}}
        <div style="margin-bottom:20px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:10px;">
                Vous êtes... <span style="color:#c0392b;">*</span>
            </label>
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;">
                @foreach([
                    'freelance'   => ['💻', 'Freelance',   'Dev, design...'],
                    'artisan'     => ['🔧', 'Artisan',     'Élec, plomb...'],
                    'tuteur'      => ['🎓', 'Tuteur',      'Cours, soutien'],
                    'entreprise'  => ['🏢', 'Entreprise',  'PME, ONG...'],
                    'particulier' => ['👤', 'Particulier', 'Besoin ponctuel'],
                ] as $value => $info)
                    <label data-role="{{ $value }}"
                        style="border:2px solid {{ old('role') === $value ? '#1A9B5A' : '#E2E8F0' }};border-radius:10px;padding:12px 6px;text-align:center;cursor:pointer;background:{{ old('role') === $value ? '#E6F7EE' : '#fff' }};">
                        <input type="radio" name="role" value="{{ $value }}"
                            {{ old('role') === $value ? 'checked' : '' }} style="display:none;">
                        <div style="font-size:22px;margin-bottom:5px;">{{ $info[0] }}</div>
                        <div style="font-size:11px;font-weight:700;color:#0D2137;">{{ $info[1] }}</div>
                        <div style="font-size:10px;color:#5a6a7a;margin-top:2px;">{{ $info[2] }}</div>
                    </label>
                @endforeach
            </div>
        </div>

        <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">

        {{-- NOM — masqué pour entreprise --}}
        <div id="champ-nom" style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Nom <span style="color:#c0392b;">*</span></label>
            <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Diallo"
                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
        </div>

        {{-- PRÉNOM — masqué pour entreprise --}}
        <div id="champ-prenom" style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Prénom</label>
            <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Ex: Mamadou"
                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
        </div>

        {{-- RAISON SOCIALE — entreprise uniquement --}}
        <div id="champ-raison-sociale" style="display:none;margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Raison sociale <span style="color:#c0392b;">*</span></label>
            <input type="text" name="raison_sociale" value="{{ old('raison_sociale') }}" placeholder="Ex: TechGuinée SARL"
                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
        </div>

        {{-- EMAIL --}}
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Adresse email <span style="color:#c0392b;">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@email.com"
                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
        </div>

        {{-- TÉLÉPHONE --}}
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Téléphone</label>
            <div style="display:flex;gap:10px;">
                <div style="padding:11px 12px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;color:#5a6a7a;background:#f8f9fa;white-space:nowrap;">🇬🇳 +224</div>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="622 000 000"
                    style="flex:1;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
            </div>
        </div>

        {{-- COMMUNE --}}
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Commune <span style="color:#c0392b;">*</span></label>
            <select name="commune" style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                <option value="">-- Sélectionnez votre commune --</option>
                @foreach(['Kaloum','Dixinn','Matam','Matoto','Ratoma','Lambanyi'] as $commune)
                    <option value="{{ $commune }}" {{ old('commune') === $commune ? 'selected' : '' }}>{{ $commune }}</option>
                @endforeach
            </select>
        </div>

        {{-- CHAMPS OFFREURS --}}
        <div id="champs-offreur" style="display:none;">
            <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:16px;">
            <div style="font-size:13px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                <span style="width:20px;height:20px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:10px;">i</span>
                Informations professionnelles
            </div>
            <div style="margin-bottom:16px;">
                <label id="label-competences" style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Compétences</label>
                <input type="text" name="competences" value="{{ old('competences') }}" placeholder="Séparez par des virgules"
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:12px;margin-bottom:16px;">
                <div>
                    <label id="label-tarif" style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Tarif indicatif (GNF)</label>
                    <input type="number" name="tarif" value="{{ old('tarif') }}" placeholder="Ex: 500000" min="0"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Unité</label>
                    <select id="select-unite" name="unite_tarif"
                        style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        <option>/ heure</option>
                        <option>/ jour</option>
                        <option>/ projet</option>
                        <option>/ séance</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:8px;">Disponibilité</label>
                <div style="display:flex;gap:16px;">
                    <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
                        <input type="radio" name="disponibilite" value="1" checked> Disponible maintenant
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
                        <input type="radio" name="disponibilite" value="0"> Indisponible
                    </label>
                </div>
            </div>
        </div>

        {{-- CHAMPS ENTREPRISE --}}
        <div id="champs-entreprise" style="display:none;">
            <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:16px;">
            <div style="font-size:13px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                <span style="width:20px;height:20px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:10px;">i</span>
                Informations de votre structure
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Secteur d'activité <span style="color:#c0392b;">*</span></label>
                <select name="secteur_activite"
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    <option value="">-- Sélectionnez --</option>
                    @foreach(['Informatique & Technologie','Bâtiment & Construction','Commerce & Distribution','Éducation & Formation','Santé','Transport & Logistique','ONG / Association','Autre'] as $secteur)
                        <option value="{{ $secteur }}" {{ old('secteur_activite') === $secteur ? 'selected' : '' }}>{{ $secteur }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Taille de la structure <span style="color:#c0392b;">*</span></label>
                <select name="taille_structure"
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    <option value="">-- Sélectionnez --</option>
                    @foreach(['TPE (1–9 employés)','PME (10–49 employés)','Grande entreprise (50+)','ONG / Association','Institution publique'] as $taille)
                        <option value="{{ $taille }}" {{ old('taille_structure') === $taille ? 'selected' : '' }}>{{ $taille }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Site web (optionnel)</label>
                <input type="url" name="site_web" value="{{ old('site_web') }}" placeholder="https://www.monentreprise.com"
                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
            </div>
        </div>

        {{-- MOT DE PASSE --}}
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Mot de passe <span style="color:#c0392b;">*</span></label>
            <input type="password" name="password" placeholder="Minimum 8 caractères"
                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
            <div style="font-size:11px;color:#5a6a7a;margin-top:4px;">⚠ Doit contenir au moins 1 majuscule et 1 chiffre</div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Confirmer le mot de passe <span style="color:#c0392b;">*</span></label>
            <input type="password" name="password_confirmation" placeholder="Répétez votre mot de passe"
                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
        </div>

        {{-- CGU --}}
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:22px;">
            <input type="checkbox" name="cgu" required style="width:16px;height:16px;margin-top:2px;flex-shrink:0;">
            <span style="font-size:12px;color:#5a6a7a;line-height:1.7;">J'accepte les conditions d'utilisation de JobLinkGN et je certifie que mes informations sont exactes.</span>
        </div>

        <button type="submit" style="background:#1A9B5A;color:#fff;border:none;width:100%;padding:14px;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;">
            Créer mon compte gratuitement
        </button>

        <div style="display:flex;align-items:center;gap:12px;margin:18px 0;">
            <div style="flex:1;height:1px;background:#E2E8F0;"></div>
            <span style="font-size:12px;color:#5a6a7a;">ou</span>
            <div style="flex:1;height:1px;background:#E2E8F0;"></div>
        </div>

        <p style="text-align:center;font-size:14px;color:#5a6a7a;">
            Déjà un compte ? <a href="{{ route('login') }}" style="color:#1A9B5A;font-weight:700;">Se connecter →</a>
        </p>
    </form>
</div>

@push('scripts')
<script>
const cartes = document.querySelectorAll('label[data-role]');

cartes.forEach(carte => {
    carte.addEventListener('click', function() {
        cartes.forEach(c => {
            c.style.border     = '2px solid #E2E8F0';
            c.style.background = '#fff';
        });
        this.style.border     = '2px solid #1A9B5A';
        this.style.background = '#E6F7EE';
        this.querySelector('input[type="radio"]').checked = true;
        adapterChamps(this.getAttribute('data-role'));
    });
});

function adapterChamps(role) {
    // Reset tous les blocs
    document.getElementById('champs-offreur').style.display       = 'none';
    document.getElementById('champs-entreprise').style.display    = 'none';
    document.getElementById('champ-nom').style.display            = 'block';
    document.getElementById('champ-prenom').style.display         = 'block';
    document.getElementById('champ-raison-sociale').style.display = 'none';

    if (['freelance', 'artisan', 'tuteur'].includes(role)) {
        document.getElementById('champs-offreur').style.display = 'block';

        const labels = {
            freelance: {
                competences: 'Compétences (ex: Laravel, Design, Comptabilité...)',
                tarif:       'Tarif horaire ou par projet (GNF)',
                unites:      ['/ heure', '/ jour', '/ projet']
            },
            artisan: {
                competences: "Domaine d'activité (ex: Électricité, Plomberie...)",
                tarif:       'Tarif journalier ou par intervention (GNF)',
                unites:      ['/ jour', '/ intervention', '/ heure']
            },
            tuteur: {
                competences: 'Matières enseignées (ex: Maths, Physique, Anglais...)',
                tarif:       'Tarif par séance (GNF)',
                unites:      ['/ séance', '/ heure', '/ mois']
            }
        };

        document.getElementById('label-competences').textContent = labels[role].competences;
        document.getElementById('label-tarif').textContent       = labels[role].tarif;

        const sel = document.getElementById('select-unite');
        sel.innerHTML = '';
        labels[role].unites.forEach(u => {
            const o = document.createElement('option');
            o.text = u; o.value = u;
            sel.add(o);
        });

    } else if (role === 'entreprise') {
        document.getElementById('champs-entreprise').style.display    = 'block';
        document.getElementById('champ-nom').style.display            = 'none';
        document.getElementById('champ-prenom').style.display         = 'none';
        document.getElementById('champ-raison-sociale').style.display = 'block';
    }
    // particulier — aucun champ supplémentaire
}

// Restaurer après erreur de validation
const roleSelectionne = document.querySelector('input[name="role"]:checked');
if (roleSelectionne) {
    const carte = document.querySelector(`label[data-role="${roleSelectionne.value}"]`);
    if (carte) {
        carte.style.border     = '2px solid #1A9B5A';
        carte.style.background = '#E6F7EE';
    }
    adapterChamps(roleSelectionne.value);
}
</script>
@endpush
@endsection