@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div style="background:linear-gradient(160deg,#0D2137 0%,#1A4B7A 55%,#0A6B3A 100%);min-height:calc(100vh - 64px);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;">

    {{-- LOGO + TITRE --}}
    <div style="text-align:center;margin-bottom:28px;">
        <h1 style="color:#fff;font-size:22px;font-weight:700;margin-bottom:6px;">Bon retour sur JobLinkGN !</h1>
        <p style="color:#B5C8D8;font-size:14px;">Connectez-vous pour accéder à votre espace personnel</p>
    </div>

    {{-- CARTE FORMULAIRE --}}
    <div style="width:100%;max-width:420px;background:#fff;border-radius:14px;padding:32px;box-shadow:0 8px 40px rgba(0,0,0,0.25);">

        {{-- ERREURS --}}
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>⚠ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- EMAIL --}}
            <div style="margin-bottom:18px;">
                <label style="font-size:13px;font-weight:600;color:#0D2137;display:block;margin-bottom:7px;">Adresse email <span style="color:#c0392b;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);font-size:16px;">📧</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@email.com" required autofocus
                        style="width:100%;padding:13px 14px 13px 42px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                </div>
            </div>

            {{-- MOT DE PASSE --}}
            <div style="margin-bottom:18px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">
                    <label style="font-size:13px;font-weight:600;color:#0D2137;">Mot de passe <span style="color:#c0392b;">*</span></label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:12px;color:#1A4B7A;font-weight:600;">Mot de passe oublié ?</a>
                    @endif
                </div>
                <div style="position:relative;">
                    <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);font-size:16px;">🔒</span>
                    <input type="password" name="password" id="input-mdp" placeholder="Votre mot de passe" required
                        style="width:100%;padding:13px 44px 13px 42px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:14px;outline:none;">
                    <span onclick="toggleMdp()" style="position:absolute;right:13px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:16px;">👁️</span>
                </div>
            </div>

            {{-- SE SOUVENIR --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:24px;">
                <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;">
                <label for="remember" style="font-size:13px;color:#5a6a7a;cursor:pointer;">Se souvenir de moi</label>
            </div>

            {{-- BOUTON --}}
            <button type="submit" style="background:#1A9B5A;color:#fff;border:none;width:100%;padding:14px;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;margin-bottom:20px;">
                Se connecter
            </button>

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <div style="flex:1;height:1px;background:#E2E8F0;"></div>
                <span style="font-size:12px;color:#5a6a7a;">ou</span>
                <div style="flex:1;height:1px;background:#E2E8F0;"></div>
            </div>

            <p style="text-align:center;font-size:14px;color:#5a6a7a;">
                Pas encore de compte ? <a href="{{ route('register') }}" style="color:#1A9B5A;font-weight:700;">S'inscrire gratuitement →</a>
            </p>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleMdp(){
    const i = document.getElementById('input-mdp');
    i.type = i.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
@endsection