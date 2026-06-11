<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobLinkGN — @yield('title', 'Plateforme de mise en relation')</title>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bleu-fonce:  #0D2137;
            --bleu-moyen:  #1A4B7A;
            --bleu-clair:  #E8F0F9;
            --vert-fonce:  #0A6B3A;
            --vert-moyen:  #1A9B5A;
            --vert-clair:  #E6F7EE;
            --orange:      #F0A500;
            --orange-clair:#FEF3DC;
            --gris-bg:     #F4F6F9;
            --gris-border: #E2E8F0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: var(--gris-bg); color: #1a2a3a; }
        a { text-decoration: none; }

        /* ── NAVBAR ─────────────────────────────────── */
        .navbar {
            background: var(--vert-clair);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            border-bottom: 3px solid var(--vert-moyen);
            position: sticky;
            top: 0;
            z-index: 200;
        }
        .navbar-logo { height: 48px; object-fit: contain; }

        /* Liens desktop */
        .navbar-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .navbar-links a { font-size: 14px; color: var(--bleu-fonce); font-weight: 500; }
        .navbar-links a.active {
            color: var(--bleu-fonce);
            border-bottom: 2px solid var(--orange);
            padding-bottom: 2px;
        }

        /* Boutons */
        .btn-primary  { background: var(--vert-moyen); color: #fff; border: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-primary:hover { background: var(--vert-fonce); }
        .btn-orange   { background: var(--orange); color: var(--bleu-fonce); border: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; display:inline-block; }
        .btn-outline  { background: transparent; color: var(--bleu-fonce); border: 2px solid var(--bleu-fonce); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; display:inline-block; }

        /* Actions desktop (avatar + boutons) */
        .navbar-actions { display: flex; align-items: center; gap: 10px; }

        /* ── BURGER ──────────────────────────────────── */
        .burger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
            background: transparent;
            border: none;
            z-index: 300;
        }
        .burger span {
            display: block;
            width: 24px;
            height: 2.5px;
            background: var(--bleu-fonce);
            border-radius: 2px;
            transition: all .3s;
        }
        /* Animation burger → croix */
        .burger.open span:nth-child(1) { transform: translateY(7.5px) rotate(45deg); }
        .burger.open span:nth-child(2) { opacity: 0; }
        .burger.open span:nth-child(3) { transform: translateY(-7.5px) rotate(-45deg); }

        /* ── MENU MOBILE ─────────────────────────────── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            background: #fff;
            border-bottom: 3px solid var(--vert-moyen);
            z-index: 190;
            padding: 16px 20px;
            flex-direction: column;
            gap: 0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        .mobile-menu.open { display: flex; }

        .mobile-menu a,
        .mobile-menu button {
            display: block;
            width: 100%;
            padding: 13px 0;
            font-size: 15px;
            font-weight: 600;
            color: var(--bleu-fonce);
            border-bottom: 1px solid var(--gris-border);
            background: transparent;
            border-left: none;
            border-right: none;
            border-top: none;
            text-align: left;
            cursor: pointer;
        }
        .mobile-menu a:last-child,
        .mobile-menu button:last-child { border-bottom: none; }
        .mobile-menu a.active { color: var(--vert-moyen); }

        /* Infos user dans le menu mobile */
        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0 16px;
            border-bottom: 2px solid var(--gris-border);
            margin-bottom: 4px;
        }

        /* ── ALERTS ──────────────────────────────────── */
        .alert-success { background: var(--vert-clair); border-left: 4px solid var(--vert-moyen); color: var(--vert-fonce); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-error   { background: #fdecea; border-left: 4px solid #c0392b; color: #7b1c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }

        /* ── FOOTER ──────────────────────────────────── */
        .footer {
            background: var(--bleu-fonce);
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: auto;
            flex-wrap: wrap;
            gap: 8px;
        }
        .footer span, .footer a { font-size: 12px; color: #6A8A9A; }
        .footer-links { display: flex; gap: 16px; }

        /* ── RESPONSIVE GLOBAL ───────────────────────── */

        /* Cartes en grille → colonne unique sur mobile */
        @media (max-width: 768px) {
            /* Grilles 2+ colonnes → 1 colonne */
            [style*="grid-template-columns: repeat(2"],
            [style*="grid-template-columns:repeat(2"],
            [style*="grid-template-columns: 1fr 1fr"],
            [style*="grid-template-columns:1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
            [style*="grid-template-columns: repeat(3"],
            [style*="grid-template-columns:repeat(3"],
            [style*="grid-template-columns: repeat(4"],
            [style*="grid-template-columns:repeat(4"] {
                grid-template-columns: 1fr !important;
            }
            /* Sidebar + contenu → colonne unique */
            [style*="grid-template-columns: 220px"],
            [style*="grid-template-columns:220px"] {
                grid-template-columns: 1fr !important;
            }
            /* Masquer sidebar sur mobile */
            [style*="grid-template-columns: 220px"] > div:first-child,
            [style*="grid-template-columns:220px"] > div:first-child {
                display: none !important;
            }
            /* Padding réduit */
            [style*="padding:24px"] { padding: 14px !important; }
            [style*="padding: 24px"] { padding: 14px !important; }
            /* Max-width full sur mobile */
            [style*="max-width:900px"],
            [style*="max-width: 900px"],
            [style*="max-width:580px"],
            [style*="max-width: 580px"] {
                margin-left: 12px !important;
                margin-right: 12px !important;
            }
        }

        /* Burger visible sur mobile, actions desktop masquées */
        @media (max-width: 640px) {
            .burger          { display: flex; }
            .navbar-links    { display: none; }
            .navbar-actions  { display: none; }
            .navbar          { padding: 0 16px; }
        }
    </style>
    @stack('styles')
</head>
<body style="min-height:100vh;display:flex;flex-direction:column;">

<!-- ── NAVBAR ───────────────────────────────────────── -->
<nav class="navbar">

    {{-- Logo --}}
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="JobLinkGN" class="navbar-logo"
             onerror="this.outerHTML='<span style=\'font-size:18px;font-weight:700;color:var(--bleu-fonce)\'>JobLink<span style=\'color:var(--orange)\'>GN</span></span>'">
    </a>

    {{-- Liens desktop --}}
    <div class="navbar-links">
        <a href="{{ route('home') }}"   class="{{ request()->routeIs('home')   ? 'active' : '' }}">Accueil</a>
        <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active' : '' }}">Rechercher</a>
    </div>

    {{-- Actions desktop --}}
    <div class="navbar-actions">
        @auth
            <div style="width:34px;height:34px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--bleu-fonce);">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}{{ strtoupper(substr(Auth::user()->profile->prenom ?? '', 0, 1)) }}
            </div>
            <div>
                <div style="font-size:13px;font-weight:700;color:var(--bleu-fonce);">{{ Auth::user()->profile->nom ?? 'Utilisateur' }}</div>
                <div style="font-size:11px;color:var(--orange);">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-outline">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-orange">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="btn-outline">Connexion</a>
            <a href="{{ route('register') }}" class="btn-orange">S'inscrire</a>
        @endauth
    </div>

    {{-- Burger mobile --}}
    <button class="burger" id="burger-btn" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

</nav>

<!-- ── MENU MOBILE ──────────────────────────────────── -->
<div class="mobile-menu" id="mobile-menu">
    @auth
        {{-- Infos utilisateur --}}
        <div class="mobile-user-info">
            <div style="width:42px;height:42px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--bleu-fonce);flex-shrink:0;">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}{{ strtoupper(substr(Auth::user()->profile->prenom ?? '', 0, 1)) }}
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:var(--bleu-fonce);">{{ Auth::user()->profile->nom ?? 'Utilisateur' }} {{ Auth::user()->profile->prenom ?? '' }}</div>
                <div style="font-size:12px;color:var(--orange);">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>

        <a href="{{ route('home') }}"      class="{{ request()->routeIs('home')      ? 'active' : '' }}">🏠 Accueil</a>
        <a href="{{ route('search') }}"    class="{{ request()->routeIs('search')    ? 'active' : '' }}">🔍 Rechercher</a>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('profil.edit') }}">👤 Mon profil</a>
        <a href="{{ route('favori.index') }}">🔖 Mes favoris</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="color:#c0392b !important;">🚪 Déconnexion</button>
        </form>
    @else
        <a href="{{ route('home') }}"      class="{{ request()->routeIs('home')   ? 'active' : '' }}">🏠 Accueil</a>
        <a href="{{ route('search') }}"    class="{{ request()->routeIs('search') ? 'active' : '' }}">🔍 Rechercher</a>
        <a href="{{ route('login') }}"     style="color:var(--vert-moyen);">🔐 Connexion</a>
        <a href="{{ route('register') }}"  style="color:var(--orange);">✨ S'inscrire gratuitement</a>
    @endauth
</div>

<!-- ── ALERTS ───────────────────────────────────────── -->
<div style="padding:0 16px;">
    @if(session('success'))
        <div class="alert-success" style="margin-top:12px;">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error" style="margin-top:12px;">⚠ {{ session('error') }}</div>
    @endif
</div>

<!-- ── CONTENU ──────────────────────────────────────── -->
<main style="flex:1;">
    @yield('content')
</main>

<!-- ── FOOTER ───────────────────────────────────────── -->
<footer style="background:#0D2137;padding:48px 28px 0;margin-top:auto;">

    {{-- CONTENU PRINCIPAL --}}
    <div style="max-width:1100px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;padding-bottom:40px;border-bottom:1px solid rgba(255,255,255,0.08);">

            {{-- COLONNE 1 — LOGO & DESCRIPTION --}}
            <div>
                <div style="margin-bottom:16px;">
                    <img src="{{ asset('images/logo.png') }}" alt="JobLinkGN"
                         style="height:52px;object-fit:contain;"
                         onerror="this.outerHTML='<span style=\'font-size:22px;font-weight:700;color:#fff\'>JobLink<span style=\'color:#F0A500\'>GN</span></span>'">
                </div>
                <p style="font-size:13px;color:#8AA4B8;line-height:1.8;margin-bottom:20px;max-width:280px;">
                    La première plateforme guinéenne de mise en relation professionnelle. Connecter les talents, créer des opportunités.
                </p>
                {{-- BADGE --}}
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(26,155,90,0.15);border:1px solid rgba(26,155,90,0.3);border-radius:20px;padding:6px 14px;">
                    <span style="font-size:14px;">🇬🇳</span>
                    <span style="font-size:12px;color:#1A9B5A;font-weight:600;">Made in Guinea</span>
                </div>
            </div>

            {{-- COLONNE 2 — NAVIGATION --}}
            <div>
                <h4 style="font-size:13px;font-weight:700;color:#fff;margin-bottom:16px;text-transform:uppercase;letter-spacing:1px;">
                    Navigation
                </h4>
                <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:10px;">
                    @foreach([
                        ['Accueil',               route('home')],
                        ['Rechercher',             route('search')],
                        ['Services disponibles',   route('search', ['tab' => 'services'])],
                        ['Offres d\'emploi',       route('search', ['tab' => 'offres'])],
                    ] as [$label, $url])
                        <li>
                            <a href="{{ $url }}"
                               style="font-size:13px;color:#8AA4B8;text-decoration:none;display:flex;align-items:center;gap:6px;transition:color .2s;"
                               onmouseover="this.style.color='#F0A500'"
                               onmouseout="this.style.color='#8AA4B8'">
                                <span style="color:#1A9B5A;font-size:10px;">▶</span> {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- COLONNE 3 — MON COMPTE --}}
            <div>
                <h4 style="font-size:13px;font-weight:700;color:#fff;margin-bottom:16px;text-transform:uppercase;letter-spacing:1px;">
                    Mon compte
                </h4>
                <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:10px;">
                    @auth
                        @foreach([
                            ['Tableau de bord', route('dashboard')],
                            ['Mon profil',      route('profil.edit')],
                            ['Mes favoris',     route('favori.index')],
                            ['Mes services',    route('service.create')],
                        ] as [$label, $url])
                            <li>
                                <a href="{{ $url }}"
                                   style="font-size:13px;color:#8AA4B8;text-decoration:none;display:flex;align-items:center;gap:6px;"
                                   onmouseover="this.style.color='#F0A500'"
                                   onmouseout="this.style.color='#8AA4B8'">
                                    <span style="color:#1A9B5A;font-size:10px;">▶</span> {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        @foreach([
                            ['Se connecter', route('login')],
                            ['S\'inscrire',  route('register')],
                        ] as [$label, $url])
                            <li>
                                <a href="{{ $url }}"
                                   style="font-size:13px;color:#8AA4B8;text-decoration:none;display:flex;align-items:center;gap:6px;"
                                   onmouseover="this.style.color='#F0A500'"
                                   onmouseout="this.style.color='#8AA4B8'">
                                    <span style="color:#1A9B5A;font-size:10px;">▶</span> {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    @endauth
                </ul>
            </div>

            {{-- COLONNE 4 — CONTACT --}}
            <div>
                <h4 style="font-size:13px;font-weight:700;color:#fff;margin-bottom:16px;text-transform:uppercase;letter-spacing:1px;">
                    Contact
                </h4>
                <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:12px;">
                    <li style="display:flex;align-items:flex-start;gap:10px;">
                        <span style="font-size:16px;margin-top:1px;">📍</span>
                        <span style="font-size:13px;color:#8AA4B8;line-height:1.6;">Conakry, Guinée<br>Université UGANC</span>
                    </li>
                    <li style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:16px;">📧</span>
                        <a href="mailto:contact@joblinkgn.com"
                           style="font-size:13px;color:#8AA4B8;text-decoration:none;"
                           onmouseover="this.style.color='#F0A500'"
                           onmouseout="this.style.color='#8AA4B8'">
                            contact@joblinkgn.com
                        </a>
                    </li>
                    <li style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:16px;">📱</span>
                        <span style="font-size:13px;color:#8AA4B8;">+224 620 000 000</span>
                    </li>
                </ul>

                {{-- RÉSEAUX SOCIAUX --}}
                <div style="display:flex;gap:10px;margin-top:20px;">
                    @foreach([
                        ['f', '#1877F2', 'Facebook'],
                        ['in', '#0A66C2', 'LinkedIn'],
                        ['tw', '#1DA1F2', 'Twitter'],
                    ] as [$letter, $color, $name])
                        <a href="#" title="{{ $name }}"
                           style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#8AA4B8;text-decoration:none;border:1px solid rgba(255,255,255,0.08);"
                           onmouseover="this.style.background='{{ $color }}';this.style.color='#fff'"
                           onmouseout="this.style.background='rgba(255,255,255,0.06)';this.style.color='#8AA4B8'">
                            {{ $letter }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- STATS RAPIDES --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:rgba(255,255,255,0.06);border-radius:8px;overflow:hidden;margin-bottom:28px;margin-top:32px;">
            @foreach([
                ['💼', $totalServices ?? '0', 'Services publiés'],
                ['📋', $totalOffres ?? '0',   'Offres actives'],
                ['👥', $totalUsers ?? '0',    'Membres inscrits'],
                ['🇬🇳', '100%',               'Gratuit'],
            ] as [$icon, $val, $label])
                <div style="background:#0D2137;padding:16px;text-align:center;">
                    <div style="font-size:22px;margin-bottom:4px;">{{ $icon }}</div>
                    <div style="font-size:20px;font-weight:700;color:#F0A500;">{{ $val }}+</div>
                    <div style="font-size:11px;color:#8AA4B8;margin-top:2px;">{{ $label }}</div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- BAS DU FOOTER --}}
    <div style="background:#080F1A;padding:16px 28px;">
        <div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <span style="font-size:12px;color:#4A6A7A;">
                © 2025–2026 JobLink GN — Licence 4 Génie Logiciel, UGANC — Tous droits réservés
            </span>
            <div style="display:flex;gap:20px;">
                @foreach(['Conditions d\'utilisation', 'Politique de confidentialité', 'Contact'] as $link)
                    <a href="#"
                       style="font-size:12px;color:#4A6A7A;text-decoration:none;"
                       onmouseover="this.style.color='#F0A500'"
                       onmouseout="this.style.color='#4A6A7A'">
                        {{ $link }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

</footer>

@stack('scripts')

<script>
// ── Burger menu ────────────────────────────────────────
const burgerBtn  = document.getElementById('burger-btn');
const mobileMenu = document.getElementById('mobile-menu');

burgerBtn.addEventListener('click', () => {
    burgerBtn.classList.toggle('open');
    mobileMenu.classList.toggle('open');
});

// Fermer le menu si on clique ailleurs
document.addEventListener('click', (e) => {
    if (!burgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
        burgerBtn.classList.remove('open');
        mobileMenu.classList.remove('open');
    }
});

// Fermer le menu si on clique sur un lien
mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        burgerBtn.classList.remove('open');
        mobileMenu.classList.remove('open');
    });
});
</script>
</body>
</html>