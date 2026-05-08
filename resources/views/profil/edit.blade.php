@extends('layouts.app')
@section('title', 'Modifier mon profil')

@section('content')
<div style="display:grid;grid-template-columns:220px 1fr;min-height:calc(100vh - 64px);">

    {{-- SIDEBAR --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px 12px;display:flex;flex-direction:column;gap:4px;">
        <div style="text-align:center;padding:14px 8px;margin-bottom:12px;border-bottom:1px solid #E2E8F0;">
            @if($profile?->photo)
                <img src="{{ asset('storage/'.$profile->photo) }}" alt="Photo"
                    style="width:52px;height:52px;border-radius:50%;object-fit:cover;border:3px solid #1A9B5A;margin:0 auto 8px;display:block;">
            @else
                <div style="width:52px;height:52px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#0D2137;margin:0 auto 8px;border:3px solid #1A9B5A;">
                    {{ strtoupper(substr($profile->nom ?? 'U', 0, 1)) }}
                </div>
            @endif
            <div style="font-size:13px;font-weight:700;color:#0D2137;">{{ $profile->nom ?? '' }} {{ $profile->prenom ?? '' }}</div>
            <div style="font-size:11px;color:#5a6a7a;margin-bottom:8px;">{{ ucfirst($user->role) }}</div>
            <div style="font-size:11px;color:#5a6a7a;margin-bottom:4px;">Profil complété à <strong style="color:#F0A500;">{{ $profile->completion_rate ?? 0 }}%</strong></div>
            <div style="height:6px;background:#E2E8F0;border-radius:4px;overflow:hidden;">
                <div style="width:{{ $profile->completion_rate ?? 0 }}%;height:100%;background:#F0A500;border-radius:4px;"></div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🏠 Tableau de bord</a>
        <a href="{{ route('profil.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:700;background:#E8F0F9;color:#0D2137;text-decoration:none;">👤 Mon profil</a>
        @if($user->isOffreur())
            <a href="{{ route('service.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🛠️ Mes services</a>
            <a href="{{ route('candidature.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">📩 Mes candidatures</a>
            <a href="{{ route('demande.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">🤝 Demandes reçues</a>
        @else
            <a href="{{ route('offre.create') }}" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#5a6a7a;text-decoration:none;">📢 Mes offres</a>
        @endif
        <div style="margin-top:auto;padding-top:16px;border-top:1px solid #E2E8F0;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:8px;font-size:14px;color:#c0392b;background:transparent;border:none;cursor:pointer;width:100%;">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    {{-- CONTENU --}}
    <div style="padding:28px;background:#F4F6F9;overflow-y:auto;">

        {{-- FIL D'ARIANE --}}
        <div style="font-size:13px;color:#5a6a7a;margin-bottom:20px;">
            <a href="{{ route('dashboard') }}" style="color:#1A4B7A;">Tableau de bord</a> ›
            <span style="color:#0D2137;font-weight:600;">Modifier mon profil</span>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0D2137;margin-bottom:4px;">Modifier mon profil</h1>
                <p style="font-size:13px;color:#5a6a7a;">Un profil complet augmente vos chances d'être contacté</p>
            </div>
            <a href="{{ route('profil.show', $user->id) }}" style="font-size:13px;color:#1A4B7A;font-weight:600;text-decoration:none;">👁 Voir mon profil public →</a>
        </div>

        {{-- BARRE DE COMPLÉTION --}}
        <div style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:16px;margin-bottom:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:13px;font-weight:700;color:#0D2137;">Taux de complétion</span>
                <span style="font-size:15px;font-weight:700;color:#F0A500;">{{ $profile->completion_rate ?? 0 }}%</span>
            </div>
            <div style="height:10px;background:#E2E8F0;border-radius:6px;overflow:hidden;">
                <div style="width:{{ $profile->completion_rate ?? 0 }}%;height:100%;background:{{ ($profile->completion_rate ?? 0) >= 80 ? '#1A9B5A' : (($profile->completion_rate ?? 0) >= 60 ? '#F0A500' : '#c0392b') }};border-radius:6px;transition:width 0.5s;"></div>
            </div>
        </div>

        {{-- ALERTES --}}
        @if(session('success'))
            <div style="background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#0A6B3A;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display:flex;flex-direction:column;gap:20px;max-width:680px;">

                {{-- SECTION 1 — Photo --}}
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">1</span>
                        Photo de profil
                    </div>
                    <div style="display:flex;align-items:center;gap:20px;">
                        @if($profile?->photo)
                            <img src="{{ asset('storage/'.$profile->photo) }}" alt="Photo"
                                style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #1A9B5A;flex-shrink:0;">
                        @else
                            <div style="width:80px;height:80px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#0D2137;border:3px solid #1A9B5A;flex-shrink:0;">
                                {{ strtoupper(substr($profile->nom ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div style="flex:1;">
                            <label for="photo" style="display:block;border:2px dashed #E2E8F0;border-radius:10px;padding:14px;text-align:center;cursor:pointer;background:#fafafa;">
                                <div style="font-size:18px;margin-bottom:4px;">📷</div>
                                <div style="font-size:13px;font-weight:600;color:#1A4B7A;">Changer la photo</div>
                                <div style="font-size:11px;color:#5a6a7a;margin-top:2px;">JPEG, PNG — Max 2 Mo</div>
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/jpeg,image/png" style="display:none;">
                            @error('photo')
                                <div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION 2 — Infos personnelles --}}
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">2</span>
                        Informations personnelles
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div style="margin-bottom:16px;">
                            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Nom <span style="color:#c0392b;">*</span></label>
                            <input type="text" name="nom" value="{{ old('nom', $profile->nom ?? '') }}"
                                style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('nom') ? '#c0392b' : '#E2E8F0' }};border-radius:8px;font-size:14px;outline:none;">
                            @error('nom')<div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>@enderror
                        </div>
                        <div style="margin-bottom:16px;">
                            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $profile->prenom ?? '') }}"
                                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Téléphone</label>
                        <div style="display:flex;gap:10px;">
                            <div style="padding:11px 12px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:13px;color:#5a6a7a;background:#f8f9fa;white-space:nowrap;">🇬🇳 +224</div>
                            <input type="tel" name="telephone" value="{{ old('telephone', $profile->telephone ?? '') }}"
                                style="flex:1;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Localisation</label>
                        <select name="localisation"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                            <option value="">-- Sélectionnez votre commune --</option>
                            @foreach(['Kaloum','Dixinn','Matam','Matoto','Ratoma','Lambanyi'] as $commune)
                                <option value="{{ $commune }}" {{ old('localisation', $profile->localisation ?? '') === $commune ? 'selected' : '' }}>
                                    {{ $commune }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom:0;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                            Biographie <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(max 300 caractères)</span>
                        </label>
                        <textarea name="bio" rows="3" maxlength="300"
                            style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('bio') ? '#c0392b' : '#E2E8F0' }};border-radius:8px;font-size:14px;outline:none;resize:vertical;">{{ old('bio', $profile->bio ?? '') }}</textarea>
                        @error('bio')<div style="font-size:12px;color:#c0392b;margin-top:4px;">⚠ {{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- SECTION 3 — Infos pro (offreurs uniquement) --}}
                @if($user->isOffreur())
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">3</span>
                        Informations professionnelles
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                            Compétences <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(séparées par des virgules)</span>
                        </label>
                        <input type="text" name="competences" value="{{ old('competences', $detail->competences ?? '') }}"
                            placeholder="Ex: Laravel, PHP, MySQL, Bootstrap..."
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>

                    <div style="display:grid;grid-template-columns:2fr 1fr;gap:14px;margin-bottom:16px;">
                        <div>
                            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Tarif indicatif (GNF)</label>
                            <input type="number" name="tarif" value="{{ old('tarif', $detail->tarif ?? '') }}"
                                min="0" placeholder="Ex: 500000"
                                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Unité</label>
                            <select name="unite_tarif"
                                style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                                @foreach(['/ heure','/ jour','/ projet','/ séance'] as $unite)
                                    <option value="{{ $unite }}">{{ $unite }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:8px;">Disponibilité</label>
                        <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;background:#F4F6F9;border-radius:8px;border:1.5px solid #E2E8F0;">
                            <label style="position:relative;width:48px;height:26px;flex-shrink:0;cursor:pointer;">
                                <input type="checkbox" name="disponibilite" value="1"
                                    {{ old('disponibilite', $detail->disponibilite ?? false) ? 'checked' : '' }}
                                    style="opacity:0;width:0;height:0;" id="toggle-dispo">
                                <span style="position:absolute;top:0;left:0;right:0;bottom:0;background:#ccc;border-radius:26px;transition:0.3s;" id="slider-dispo"></span>
                            </label>
                            <div>
                                <div style="font-size:14px;font-weight:700;color:#1A9B5A;" id="dispo-label">
                                    {{ old('disponibilite', $detail->disponibilite ?? false) ? '✓ Disponible pour de nouvelles missions' : '✗ Indisponible pour le moment' }}
                                </div>
                                <div style="font-size:11px;color:#5a6a7a;">Modifiable à tout moment</div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom:0;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                            Portfolio <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(optionnel)</span>
                        </label>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div>
                                <div style="font-size:11px;color:#5a6a7a;margin-bottom:6px;">URL externe</div>
                                <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $detail->portfolio_url ?? '') }}"
                                    placeholder="https://mon-portfolio.com"
                                    style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                            </div>
                            <div>
                                <div style="font-size:11px;color:#5a6a7a;margin-bottom:6px;">Ou fichier PDF</div>
                                <label for="portfolio_fichier" style="display:block;border:1.5px dashed #E2E8F0;border-radius:8px;padding:11px;text-align:center;cursor:pointer;background:#fafafa;font-size:12px;color:#1A4B7A;font-weight:600;">
                                    📄 Choisir un PDF
                                </label>
                                <input type="file" id="portfolio_fichier" name="portfolio_fichier" accept="application/pdf" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- SECTION 3 ou 4 — Entreprise --}}
                @if($user->role === 'entreprise')
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">3</span>
                        Informations de la structure
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Secteur d'activité</label>
                        <select name="secteur_activite"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                            <option value="">-- Sélectionnez --</option>
                            @foreach(['Informatique & Technologie','Bâtiment & Construction','Commerce & Distribution','Éducation & Formation','Santé','Transport & Logistique','ONG / Association','Autre'] as $secteur)
                                <option value="{{ $secteur }}" {{ old('secteur_activite', $profile->secteur_activite ?? '') === $secteur ? 'selected' : '' }}>{{ $secteur }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Taille de la structure</label>
                        <select name="taille_structure"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                            <option value="">-- Sélectionnez --</option>
                            @foreach(['TPE (1–9 employés)','PME (10–49 employés)','Grande entreprise (50+)','ONG / Association','Institution publique'] as $taille)
                                <option value="{{ $taille }}" {{ old('taille_structure', $profile->taille_structure ?? '') === $taille ? 'selected' : '' }}>{{ $taille }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom:0;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Site web</label>
                        <input type="url" name="site_web" value="{{ old('site_web', $profile->site_web ?? '') }}"
                            placeholder="https://www.monentreprise.com"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                </div>
                @endif

                {{-- SECTION — Sécurité --}}
                <div style="background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:24px;">
                    <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <span style="width:22px;height:22px;background:#1A4B7A;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:11px;">4</span>
                        Sécurité du compte
                    </div>

                    <div style="background:#F4F6F9;border-radius:8px;padding:14px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#0D2137;">Adresse email</div>
                            <div style="font-size:13px;color:#5a6a7a;">{{ $user->email }}</div>
                        </div>
                        <span style="font-size:11px;color:#1A9B5A;font-weight:600;background:#E6F7EE;padding:3px 10px;border-radius:20px;">✓ Vérifiée</span>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">
                            Nouveau mot de passe <span style="font-size:11px;color:#5a6a7a;font-weight:400;">(laissez vide pour ne pas changer)</span>
                        </label>
                        <input type="password" name="password" placeholder="Nouveau mot de passe"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>

                    <div style="margin-bottom:0;">
                        <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:6px;">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe"
                            style="width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    </div>
                </div>

                {{-- BOUTONS --}}
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

                {{-- DÉSACTIVATION --}}
                <div style="background:#F4F6F9;border:1px solid #E2E8F0;border-radius:12px;padding:20px;">
                    <div style="font-size:14px;font-weight:700;color:#5a6a7a;margin-bottom:8px;">⚙️ Désactivation du compte</div>
                    <p style="font-size:13px;color:#5a6a7a;margin-bottom:12px;line-height:1.6;">
                        Seul l'administrateur peut désactiver ou supprimer un compte. Envoyez-lui une demande ci-dessous.
                    </p>
                    <button type="button" onclick="document.getElementById('msg-desactivation').style.display='block'"
                        style="background:transparent;color:#5a6a7a;border:1.5px solid #E2E8F0;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                        ✉ Envoyer une demande à l'administrateur
                    </button>
                    <div id="msg-desactivation" style="display:none;margin-top:12px;background:#E6F7EE;border-left:4px solid #1A9B5A;border-radius:8px;padding:10px 14px;font-size:13px;color:#0A6B3A;">
                        ✓ Votre demande a été envoyée. L'administrateur vous contactera sous 48h.
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Toggle disponibilité
const toggle = document.getElementById('toggle-dispo');
const slider = document.getElementById('slider-dispo');
const label  = document.getElementById('dispo-label');

function updateToggle() {
    if (toggle && slider && label) {
        slider.style.background = toggle.checked ? '#1A9B5A' : '#ccc';
        label.textContent = toggle.checked ? '✓ Disponible pour de nouvelles missions' : '✗ Indisponible pour le moment';
        label.style.color = toggle.checked ? '#1A9B5A' : '#c0392b';
    }
}

if (toggle) {
    updateToggle();
    toggle.addEventListener('change', updateToggle);
}
</script>
@endpush

@endsection