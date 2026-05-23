<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobLinkGN — @yield('title', 'Plateforme de mise en relation')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bleu-fonce: #0D2137;
            --bleu-moyen: #1A4B7A;
            --bleu-clair: #E8F0F9;
            --vert-fonce: #0A6B3A;
            --vert-moyen: #1A9B5A;
            --vert-clair: #E6F7EE;
            --orange: #F0A500;
            --orange-clair: #FEF3DC;
            --gris-bg: #F4F6F9;
            --gris-border: #E2E8F0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: var(--gris-bg); color: #1a2a3a; }
        a { text-decoration: none; }

        /* NAVBAR */
        .navbar {
            background: var(--vert-clair);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            border-bottom: 3px solid var(--vert-moyen);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-logo { height: 48px; object-fit: contain; }
        .navbar-links { display: flex; align-items: center; gap: 20px; }
        .navbar-links a { font-size: 14px; color: var(--bleu-fonce); }
        .navbar-links a:hover { color: var(--bleu-fonce); }
        .navbar-links a.active { color: var(--bleu-fonce); border-bottom: 2px solid var(--orange); padding-bottom: 2px; }
        .btn-primary { background: var(--vert-moyen); color: #fff; border: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-primary:hover { background: var(--vert-fonce); }
        .btn-orange { background: var(--orange); color: var(--bleu-fonce); border: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; }
        .btn-outline-blanc { background: transparent; color: #fff; border: 2px solid var(--bleu-fonce); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; }

        /* ALERTS */
        .alert-success { background: var(--vert-clair); border-left: 4px solid var(--vert-moyen); color: var(--vert-fonce); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-error { background: #fdecea; border-left: 4px solid #c0392b; color: #7b1c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }

        /* FOOTER */
        .footer { background: var(--bleu-fonce); padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.08); margin-top: auto; }
        .footer span, .footer a { font-size: 12px; color: #6A8A9A; }
        .footer-links { display: flex; gap: 16px; }
    </style>
    @stack('styles')
</head>
<body style="min-height:100vh;display:flex;flex-direction:column;">

<!-- NAVBAR -->
<nav class="navbar " >
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="JobLinkGN" class="navbar-logo"
             onerror="this.outerHTML='<span style=\'color:#fff;font-size:18px;font-weight:700;\'>JobLink<span style=\'color:var(--orange)\'>GN</span></span>'">
    </a>
    <div class="navbar-links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
        <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active' : '' }}">Rechercher</a>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        @auth
            <div style="width:34px;height:34px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--bleu-fonce);">
                {{ strtoupper(substr(Auth::user()->profile->nom ?? 'U', 0, 1)) }}{{ strtoupper(substr(Auth::user()->profile->prenom ?? '', 0, 1)) }}
            </div>
            <div>
                <div style="font-size:13px;font-weight:700;color:black;">{{ Auth::user()->profile->nom ?? 'Utilisateur' }}</div>
                <div style="font-size:11px;color:var(--orange);">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-outline-blanc" style="font-size:13px;color:#0D2137;margin-left:8px;">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-orange">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-outline-blanc" style="color: #0D2137;">Connexion</a>
            <a href="{{ route('register') }}" class="btn-orange">S'inscrire</a>
        @endauth
    </div>
</nav>

<!-- ALERTS GLOBALES -->
<div style="padding: 0 28px;">
    @if(session('success'))
        <div class="alert-success" style="margin-top:16px;">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error" style="margin-top:16px;">⚠ {{ session('error') }}</div>
    @endif
</div>

<!-- CONTENU -->
<main style="flex:1;">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
    <span>© 2025–2026 JobLinkGN — UGANC</span>
    <div class="footer-links">
        <a href="#">Conditions d'utilisation</a>
        <a href="#">Contact</a>
    </div>
</footer>

@stack('scripts')
</body>
</html>