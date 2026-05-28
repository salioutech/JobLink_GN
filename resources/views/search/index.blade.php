@extends('layouts.app')
@section('title', 'Rechercher')

@section('content')

{{-- BARRE DE RECHERCHE --}}
<div style="background:linear-gradient(135deg,#0D2137,#1A4B7A);padding:28px;">
    <form method="GET" action="{{ route('search') }}">
        <div style="display:flex;gap:10px;max-width:800px;margin:0 auto;">
            <input type="text" name="q" value="{{ request('q') }}"
                placeholder="Ex: Développeur Laravel, électricien, tuteur maths..."
                style="flex:1;padding:12px 16px;border:none;border-radius:8px;font-size:14px;outline:none;">

            <select name="categorie"
                style="padding:12px;border:none;border-radius:8px;font-size:14px;outline:none;">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom }}
                    </option>
                @endforeach
            </select>

            <select name="localisation"
                style="padding:12px;border:none;border-radius:8px;font-size:14px;outline:none;">
                <option value="">Toute la ville</option>
                @foreach(['Kaloum','Dixinn','Matam','Matoto','Ratoma','Lambanyi'] as $commune)
                    <option value="{{ $commune }}" {{ request('localisation') === $commune ? 'selected' : '' }}>
                        {{ $commune }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                style="background:#1A9B5A;color:#fff;border:none;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;">
                Rechercher
            </button>
        </div>
    </form>
</div>

{{-- ONGLETS --}}
<div style="background:#fff;border-bottom:1px solid #E2E8F0;padding:0 28px;">
    <div style="display:flex;gap:0;">
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'services']) }}"
            style="padding:14px 24px;font-size:14px;font-weight:600;color:{{ $tab === 'services' ? '#0D2137' : '#5a6a7a' }};border-bottom:{{ $tab === 'services' ? '3px solid #1A9B5A' : 'none' }};text-decoration:none;">
            Services ({{ $services->total() }})
        </a>
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'offres']) }}"
            style="padding:14px 24px;font-size:14px;font-weight:600;color:{{ $tab === 'offres' ? '#0D2137' : '#5a6a7a' }};border-bottom:{{ $tab === 'offres' ? '3px solid #1A9B5A' : 'none' }};text-decoration:none;">
            Offres ({{ $offres->total() }})
        </a>
    </div>
</div>

{{-- CORPS --}}
<div style="display:grid;grid-template-columns:240px 1fr;min-height:600px;">

    {{-- SIDEBAR FILTRES --}}
    <div style="background:#fff;border-right:1px solid #E2E8F0;padding:20px;">
        <form method="GET" action="{{ route('search') }}">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="hidden" name="q" value="{{ request('q') }}">

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <span style="font-size:14px;font-weight:700;color:#0D2137;">Filtres</span>
                <a href="{{ route('search', ['tab' => $tab]) }}" style="font-size:12px;color:#1A9B5A;font-weight:600;">Réinitialiser</a>
            </div>

            {{-- DISPONIBILITÉ — uniquement pour les services --}}
            @if($tab === 'services')
                <div style="margin-bottom:20px;">
                    <div style="font-size:12px;font-weight:700;color:#5a6a7a;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Disponibilité</div>
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;">
                        <input type="checkbox" name="dispo" value="1" {{ request('dispo') ? 'checked' : '' }}>
                        Disponible uniquement
                    </label>
                </div>
                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">
            @endif

            {{-- TYPE D'OFFRE — uniquement pour les offres --}}
            @if($tab === 'offres')
                <div style="margin-bottom:20px;">
                    <div style="font-size:12px;font-weight:700;color:#5a6a7a;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Type d'offre</div>
                    @foreach(['emploi' => 'Emploi', 'mission' => 'Mission', 'demande_service' => 'Demande de service'] as $val => $label)
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;margin-bottom:8px;cursor:pointer;">
                            <input type="checkbox" name="type_offre[]" value="{{ $val }}"
                                {{ in_array($val, request('type_offre', [])) ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">
            @endif

            {{-- TARIF / BUDGET --}}
            <div style="margin-bottom:20px;">
                <div style="font-size:12px;font-weight:700;color:#5a6a7a;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">
                    {{ $tab === 'services' ? 'Tarif (GNF)' : 'Budget (GNF)' }}
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                    <div>
                        <div style="font-size:11px;color:#5a6a7a;margin-bottom:4px;">Min</div>
                        <input type="number" name="tarif_min" value="{{ request('tarif_min') }}"
                            placeholder="0"
                            style="width:100%;padding:8px;border:1.5px solid #E2E8F0;border-radius:6px;font-size:13px;outline:none;">
                    </div>
                    <div>
                        <div style="font-size:11px;color:#5a6a7a;margin-bottom:4px;">Max</div>
                        <input type="number" name="tarif_max" value="{{ request('tarif_max') }}"
                            placeholder="Max"
                            style="width:100%;padding:8px;border:1.5px solid #E2E8F0;border-radius:6px;font-size:13px;outline:none;">
                    </div>
                </div>
            </div>

            <hr style="border:none;border-top:1px solid #E2E8F0;margin-bottom:20px;">

            {{-- CATÉGORIE --}}
            <div style="margin-bottom:20px;">
                <div style="font-size:12px;font-weight:700;color:#5a6a7a;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Catégorie</div>
                @foreach($categories as $cat)
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;margin-bottom:8px;cursor:pointer;">
                        <input type="checkbox" name="categorie" value="{{ $cat->id }}"
                            {{ request('categorie') == $cat->id ? 'checked' : '' }}>
                        {{ $cat->nom }}
                    </label>
                @endforeach
            </div>

            <button type="submit"
                style="background:#0D2137;color:#fff;border:none;width:100%;padding:11px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
                Appliquer les filtres
            </button>
        </form>
    </div>

    {{-- RÉSULTATS --}}
    <div style="padding:20px 24px;">

        {{-- BARRE RÉSULTATS + TRI --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <span style="font-size:15px;font-weight:700;color:#0D2137;">
                {{ $tab === 'services' ? $services->total() : $offres->total() }} résultats trouvés
            </span>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:13px;color:#5a6a7a;">Trier par :</span>
                <select name="sort" onchange="this.form.submit()" form="sort-form"
                    style="padding:7px 12px;border:1px solid #E2E8F0;border-radius:6px;font-size:13px;outline:none;">
                    <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Plus récent</option>
                    <option value="tarif_asc" {{ request('sort') === 'tarif_asc' ? 'selected' : '' }}>Tarif croissant</option>
                    <option value="tarif_desc" {{ request('sort') === 'tarif_desc' ? 'selected' : '' }}>Tarif décroissant</option>
                </select>
            </div>
        </div>

        {{-- SERVICES --}}
        @if($tab === 'services')
            @if($services->count() > 0)
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
                    @foreach($services as $service)
                        <div onclick="window.location='{{ route('service.show', $service->id) }}'"
                            style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:16px;border-top:3px solid #1A4B7A;cursor:pointer;"
                            onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'"
                            onmouseout="this.style.boxShadow='none'">

                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                                <a href="{{ route('profil.show', $service->user_id) }}"
                                    onclick="event.stopPropagation()"
                                    style="display:flex;align-items:center;gap:10px;flex:1;text-decoration:none;">
                                    <div style="width:42px;height:42px;border-radius:50%;background:#F0A500;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#0D2137;flex-shrink:0;">
                                        {{ strtoupper(substr($service->user->profile->nom ?? 'U', 0, 1)) }}{{ strtoupper(substr($service->user->profile->prenom ?? '', 0, 1)) }}
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-size:14px;font-weight:700;color:#0D2137;">
                                            {{ $service->user->profile->nom ?? '' }} {{ $service->user->profile->prenom ?? '' }}
                                        </div>
                                        <div style="font-size:12px;color:#5a6a7a;">
                                            📍 {{ $service->user->profile->localisation ?? 'Conakry' }} · {{ ucfirst($service->user->role) }}
                                        </div>
                                    </div>
                                </a>
                                <span style="background:#E6F7EE;color:#0A6B3A;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:600;flex-shrink:0;">Dispo</span>
                            </div>

                            <div style="font-size:13px;font-weight:700;color:#0D2137;margin-bottom:6px;">{{ $service->titre }}</div>

                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <span style="font-size:13px;font-weight:700;color:#1A9B5A;">
                                    {{ $service->tarif ? number_format($service->tarif, 0, ',', ' ').' GNF' : 'À négocier' }}
                                </span>
                                <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:600;">
                                    {{ $service->categorie->nom ?? '' }}
                                </span>
                            </div>

                            <div style="display:flex;gap:8px;">
                                @auth
                                    <a href="{{ route('profil.show', $service->user_id) }}"
                                        onclick="event.stopPropagation()"
                                        style="flex:1;background:#1A9B5A;color:#fff;padding:8px;border-radius:8px;font-size:12px;font-weight:700;text-align:center;text-decoration:none;">
                                        Contacter
                                    </a>
                                @else
                                    <button onclick="event.stopPropagation(); afficherAlerte()"
                                        style="flex:1;background:#1A9B5A;color:#fff;border:none;padding:8px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">
                                        Contacter
                                    </button>
                                @endauth
                                <a href="{{ route('profil.show', $service->user_id) }}"
                                    onclick="event.stopPropagation()"
                                    style="flex:1;background:transparent;color:#1A4B7A;border:1.5px solid #1A4B7A;padding:8px;border-radius:8px;font-size:12px;font-weight:700;text-align:center;text-decoration:none;">
                                    Voir profil
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $services->withQueryString()->links() }}</div>
            @else
                <div style="text-align:center;padding:60px;color:#5a6a7a;">
                    <div style="font-size:48px;margin-bottom:16px;">🔍</div>
                    <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucun service trouvé</div>
                    <div style="font-size:14px;">Essayez avec d'autres mots-clés ou filtres</div>
                </div>
            @endif

        {{-- OFFRES --}}
        @else
            @if($offres->count() > 0)
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
                    @foreach($offres as $offre)
                        <div onclick="window.location='{{ route('offre.show', $offre->id) }}'"
                            style="background:#fff;border-radius:10px;border:1px solid #E2E8F0;padding:16px;border-left:4px solid #1A4B7A;cursor:pointer;"
                            onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.10)'"
                            onmouseout="this.style.boxShadow='none'">

                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                <span style="background:#E8F0F9;color:#1A4B7A;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                    {{ ucfirst(str_replace('_', ' ', $offre->type)) }}
                                </span>
                                <span style="font-size:11px;color:#5a6a7a;">{{ $offre->created_at->diffForHumans() }}</span>
                            </div>

                            <div style="font-size:14px;font-weight:700;color:#0D2137;margin-bottom:6px;">{{ $offre->titre }}</div>

                            <div style="font-size:12px;color:#5a6a7a;margin-bottom:10px;line-height:1.5;">
                                {{ Str::limit($offre->description, 80) }}
                            </div>

                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <span style="font-size:12px;color:#5a6a7a;">📍 {{ $offre->user->profile->localisation ?? 'Conakry' }}</span>
                                <span style="font-size:13px;font-weight:700;color:#1A9B5A;">
                                    {{ $offre->budget ? number_format($offre->budget, 0, ',', ' ').' GNF' : 'À négocier' }}
                                </span>
                            </div>

                            @auth
                                @if(Auth::user()->isOffreur())
                                    <form method="POST" action="{{ route('candidature.store') }}"
                                        onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="offre_id" value="{{ $offre->id }}">
                                        <button type="submit"
                                            style="width:100%;background:#1A4B7A;color:#fff;border:none;padding:9px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
                                            Postuler
                                        </button>
                                    </form>
                                @endif
                            @else
                                <button onclick="event.stopPropagation(); afficherAlerte()"
                                    style="width:100%;background:#1A4B7A;color:#fff;border:none;padding:9px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
                                    Postuler
                                </button>
                            @endauth
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:24px;">{{ $offres->withQueryString()->links() }}</div>
            @else
                <div style="text-align:center;padding:60px;color:#5a6a7a;">
                    <div style="font-size:48px;margin-bottom:16px;">📋</div>
                    <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Aucune offre trouvée</div>
                    <div style="font-size:14px;">Essayez avec d'autres mots-clés ou filtres</div>
                </div>
            @endif
        @endif
    </div>
</div>

{{-- MODAL ALERTE CONNEXION --}}
<div id="modal-alerte-connexion"
    style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:32px 28px;width:100%;max-width:400px;margin:20px;text-align:center;">
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
</script>
@endpush

@endsection