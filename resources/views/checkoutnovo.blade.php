<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Checkout DentalGO</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/dentalgo.css') }}">
  <!-- Scripts da Iugu removidos - processamento via API DentalGo -->

  <style>
    .step.hidden,
    .auth-form.hidden {
      display: none;
    }

        /* Estilos para a animação e aparência do cartão */
        .credit-card-container {
            perspective: 1000px;
        }
        .credit-card {
            width: 100%;
            max-width: 400px;
            height: 220px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            margin: 0 auto;
        }
        .credit-card.flipped {
            transform: rotateY(180deg);
        }
        .credit-card-front, .credit-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 1rem;
            background: linear-gradient(180deg, #444, #111);
            color: white;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-family: 'Courier New', Courier, monospace;
        }
        .card-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.5;
            border-radius: 1rem;
        }
        .credit-card-back {
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card-mag-stripe {
            width: 100%;
            height: 50px;
            background: #000;
            margin-top: 1.5rem;
        }
        .card-cvv-box {
            margin-top: 1rem;
            width: 85%;
            height: 40px;
            background: #fff;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 1rem;
            border-radius: 0.25rem;
        }
        .card-cvv-display {
            color: #333;
            font-style: italic;
            letter-spacing: 2px;
        }
        .card-chip {
            width: 50px;
            height: 40px;
            background: linear-gradient(135deg, #d4af37, #b48811);
            border-radius: 0.25rem;
        }
        .card-number-display {
            font-size: 1.5rem;
            letter-spacing: 3px;
            margin-top: 1rem;
            z-index: 1;
        }
        .card-details-display {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            text-transform: uppercase;
            z-index: 1;
        }
        .card-label {
            font-size: 0.6rem;
            display: block;
            color: #aaa;
        }
        .card-brand-logo {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 60px;
            height: auto;
            transition: opacity 0.3s;
            opacity: 0.5;
        }
        .card-brand-logo.visible {
            opacity: 1;
        }
        .hidden {
            display: none;
        }
  </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
  <style id="global-loading-overlay-style">
    #global-loading-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); display: none; align-items: center; justify-content: center; z-index: 99999; backdrop-filter: blur(1px); }
    #global-loading-overlay .spinner { width: 56px; height: 56px; border: 4px solid rgba(255,255,255,0.35); border-top-color: #fff; border-radius: 50%; animation: spin 1s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }
    html.overlay-lock, body.overlay-lock { overflow: hidden !important; }
  </style>
  <div id="global-loading-overlay" aria-hidden="true"><div class="spinner" aria-label="Carregando"></div></div>
  <script>
    (function(){
      var overlay = null;
      function ensureOverlay(){
        if (!overlay) overlay = document.getElementById('global-loading-overlay');
        return overlay;
      }
      function showLoadingOverlay(){
        var el = ensureOverlay();
        if (el){
          el.style.display = 'flex';
          try { document.documentElement.classList.add('overlay-lock'); document.body.classList.add('overlay-lock'); } catch(e){}
        }
      }
      function hideLoadingOverlay(){
        var el = ensureOverlay();
        if (el){
          el.style.display = 'none';
          try { document.documentElement.classList.remove('overlay-lock'); document.body.classList.remove('overlay-lock'); } catch(e){}
        }
      }
      window.showLoadingOverlay = showLoadingOverlay;
      window.hideLoadingOverlay = hideLoadingOverlay;

      window.addEventListener('beforeunload', function(){
        try { showLoadingOverlay(); } catch(e) {}
      });

      if (window.location && typeof window.location.reload === 'function') {
        try {
          var _origReload = window.location.reload.bind(window.location);
          window.location.reload = function(){
            try { showLoadingOverlay(); } catch(e) {}
            var args = Array.prototype.slice.call(arguments);
            setTimeout(function(){ _origReload.apply(window.location, args); }, 50);
          };
        } catch(e){}
      }
    })();
  </script>
       <?php

$linguagem = request('language');
if(!$linguagem){
  $linguagem = session('lang_code', app()->getLocale());
}

   ?>
  <div class="max-w-none md:max-w-5xl lg:max-w-6xl xl:max-w-7xl 2xl:max-w-7xl mx-auto px-0 sm:px-4 md:px-6 py-6">
    <div class="w-full bg-white rounded-2xl shadow-2xl p-4 md:p-8 relative">
      <div class="flex items-center justify-end w-full gap-1 md:gap-2 text-xs md:text-sm text-gray-600 md:absolute md:top-4 md:right-4">
        <span class="hidden sm:inline">{{ __('messages.CheckoutSelecionarIdioma') }}:</span>
        <a class="inline-flex items-center gap-1 md:gap-2 px-3 py-2 whitespace-nowrap rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 shadow-sm hover:shadow-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1" href="#" id="checkoutLanguageDropdown" role="button" aria-expanded="false">
          <span class="inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 rounded-full overflow-hidden ring-1 ring-gray-200">
            @if(session()->has('lang_code') && session()->get('lang_code')=='pt')
              <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                <rect width="24" height="24" fill="#009b3a"></rect>
                <polygon points="12,3 21,12 12,21 3,12" fill="#ffdf00"></polygon>
                <circle cx="12" cy="12" r="4.2" fill="#002776"></circle>
              </svg>
            @elseif(session()->has('lang_code') && session()->get('lang_code')=='en')
              <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                <rect width="24" height="24" fill="#ffffff"></rect>
                <g fill="#b22234">
                  <rect y="0" width="24" height="2"/>
                  <rect y="4" width="24" height="2"/>
                  <rect y="8" width="24" height="2"/>
                  <rect y="12" width="24" height="2"/>
                  <rect y="16" width="24" height="2"/>
                  <rect y="20" width="24" height="2"/>
                </g>
                <rect width="10" height="7" fill="#3c3b6e"></rect>
              </svg>
            @elseif(session()->has('lang_code') && session()->get('lang_code')=='es')
              <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                <rect width="24" height="24" fill="#aa151b"></rect>
                <rect y="6" width="24" height="12" fill="#f1bf00"></rect>
              </svg>
            @else
              <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                <circle cx="12" cy="12" r="10" fill="#e5e7eb"></circle>
                <path d="M2 12h20M12 2a15 15 0 010 20M12 2a15 15 0 000 20" stroke="#9ca3af" stroke-width="1.5" fill="none"></path>
              </svg>
            @endif
          </span>
          <span class="font-medium hidden md:inline">
            {{session()->has('lang_code')?(session()->get('lang_code')=='pt'?'PT-BR':''):''}} {{session()->has('lang_code')?(session()->get('lang_code')=='en'?'EN':''):''}} {{session()->has('lang_code')?(session()->get('lang_code')=='es'?'ES':''):''}}
          </span>
          <span class="text-gray-400 text-sm transition-transform lang-arrow hidden md:inline">▾</span>
        </a>
        <ul class="dropdown-menu z-50 hidden py-1" aria-labelledby="checkoutLanguageDropdown">
          <li>
            <a onclick="changeLanguage('pt')" class="dropdown-item flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{session()->has('lang_code')?(session()->get('lang_code')=='pt'?'font-semibold text-blue-600 bg-blue-50':''):''}}">
              <span class="inline-flex w-5 h-5 mr-1 overflow-hidden rounded-sm ring-1 ring-gray-200" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20">
                  <rect width="24" height="24" fill="#009b3a"></rect>
                  <polygon points="12,3 21,12 12,21 3,12" fill="#ffdf00"></polygon>
                  <circle cx="12" cy="12" r="4.2" fill="#002776"></circle>
                </svg>
              </span>
              PT-BR
            </a>
          </li>
          <li>
            <a onclick="changeLanguage('en')" class="dropdown-item flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{session()->has('lang_code')?(session()->get('lang_code')=='en'?'font-semibold text-blue-600 bg-blue-50':''):''}}">
              <span class="inline-flex w-5 h-5 mr-1 overflow-hidden rounded-sm ring-1 ring-gray-200" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20">
                  <rect width="24" height="24" fill="#ffffff"></rect>
                  <g fill="#b22234">
                    <rect y="0" width="24" height="2"/>
                    <rect y="4" width="24" height="2"/>
                    <rect y="8" width="24" height="2"/>
                    <rect y="12" width="24" height="2"/>
                    <rect y="16" width="24" height="2"/>
                    <rect y="20" width="24" height="2"/>
                  </g>
                  <rect width="10" height="7" fill="#3c3b6e"></rect>
                </svg>
              </span>
              English
            </a>
          </li>
          <li>
            <a onclick="changeLanguage('es')" class="dropdown-item flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md {{session()->has('lang_code')?(session()->get('lang_code')=='es'?'font-semibold text-blue-600 bg-blue-50':''):''}}">
              <span class="inline-flex w-5 h-5 mr-1 overflow-hidden rounded-sm ring-1 ring-gray-200" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20">
                  <rect width="24" height="24" fill="#aa151b"></rect>
                  <rect y="6" width="24" height="12" fill="#f1bf00"></rect>
                </svg>
              </span>
              Español
            </a>
          </li>
        </ul>
      </div>
      <script>
      (function(){
        if (typeof window.changeLanguage !== 'function') {
          window.changeLanguage = function(lang){
            try { window.location = '{{ url("change-language") }}' + '/' + lang; }
            catch(e){ window.location.href = '/change-language/' + lang; }
          };
        }
        document.addEventListener('DOMContentLoaded', function(){
          var toggle = document.getElementById('checkoutLanguageDropdown');
          var menu = document.querySelector('ul[aria-labelledby="checkoutLanguageDropdown"]');
          if (!toggle || !menu) return;
          menu.classList.add('hidden');
          toggle.style.cursor = 'pointer';
          toggle.addEventListener('click', function(ev){
            ev.preventDefault();
            var rect = toggle.getBoundingClientRect();
            menu.style.position = 'fixed';
            var top = rect.bottom + 6;
            if (top < 8) top = 8;
            menu.style.top = top + 'px';
            var menuWidth = Math.max(140, menu.offsetWidth || 0);
            var left = rect.left;
            left = Math.min(Math.max(8, left), (window.innerWidth - menuWidth - 8));
            menu.style.left = left + 'px';
            menu.style.right = 'auto';
            menu.style.zIndex = '9999';
            menu.style.background = '#ffffff';
            menu.style.border = '1px solid #e5e7eb';
            menu.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
            menu.style.borderRadius = '10px';
            menu.style.padding = '6px 0';
            menu.style.minWidth = '140px';
            menu.classList.toggle('hidden');
            var arrow = toggle.querySelector('.lang-arrow');
            if (arrow){
              if (menu.classList.contains('hidden')){ arrow.style.transform = 'rotate(0deg)'; }
              else { arrow.style.transform = 'rotate(180deg)'; }
            }
            var onClickOutside = function(e){
              if (!menu.contains(e.target) && !toggle.contains(e.target)){
                menu.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
                document.removeEventListener('click', onClickOutside);
              }
            };
            setTimeout(function(){ document.addEventListener('click', onClickOutside); }, 0);
          });
        });
      })();
      </script>
      <div class="w-full flex justify-center mb-6 md:mb-8 lg:mb-10">
        <img src="{{ asset('imagens/LOGODENTALGO.fw.png') }}" alt="DentalGO" style="margin-bottom: 20px;" class="h-16 md:h-20 lg:h-24 xl:h-28 w-auto max-w-full select-none" draggable="false"/>
      </div>
      <div class="flex flex-wrap justify-between gap-2 mb-6">
        <div class="flex-1 text-center">
          <div class="w-8 h-8 mx-auto mb-1 rounded-full bg-green-500 text-white flex items-center justify-center" id="step-label-1">1</div>
          <div class="text-sm font-semibold text-gray-600">{{ __('messages.CheckoutPassoIdentificacao') }}</div>
        </div>
        <div class="flex-1 text-center">
          <div class="w-8 h-8 mx-auto mb-1 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center" id="step-label-2">2</div>
          <div class="text-sm font-semibold text-gray-600" id="step-name-2">
  @if(!empty($partialItems))
    {{ __('messages.CheckoutPassoParcial') }}
  @elseif(($checkoutType ?? 'plan') === 'product')
    {{ __('messages.CheckoutPassoProduto') }}
  @else
    {{ __('messages.CheckoutPassoPlano') }}
  @endif
</div>
        </div>
        <div class="flex-1 text-center">
          <div class="w-8 h-8 mx-auto mb-1 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center" id="step-label-3">3</div>
          <div class="text-sm font-semibold text-gray-600">{{ __('messages.CheckoutPassoPagamento') }}</div>
        </div>
      </div>
   
      <form id="checkout-form" novalidate onsubmit="return false;">
        @csrf
        <div id="step-1" class="step {{ $initialStep == 1 ? '' : 'hidden' }}">
          <style>
            #auth-choice { transition: transform 280ms cubic-bezier(0.22, 0.61, 0.36, 1), opacity 280ms cubic-bezier(0.22, 0.61, 0.36, 1); transform-origin: center center; will-change: transform, opacity; }
            .auth-collapse { transform: scaleX(0.80); opacity: 0; }
            #auth-section { transition: transform 320ms cubic-bezier(0.22, 0.61, 0.36, 1), opacity 320ms cubic-bezier(0.22, 0.61, 0.36, 1); transform-origin: center top; will-change: transform, opacity; }
            .auth-section-anim { transform: translateY(1px); opacity: 0.98; }
            /* Forçar padding à direita nos inputs de login */
            #login-password { padding-right: 6.25rem !important; padding-inline-end: 6.25rem !important; }
          </style>
          <div id="auth-section">
          <div id="auth-controls" class="mb-3 hidden" aria-live="polite">
            <button id="auth-back" type="button" onclick="authBackToChoice()" class="inline-flex items-center gap-2 text-sm md:text-base font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 rounded-md px-3.5 py-2.5 shadow-sm transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
              <span>{{ __('messages.CheckoutVoltar') }}</span>
            </button>
          </div>
          <h3 id="auth-title" class="text-xl font-semibold text-gray-800 mb-3 text-center">{{ __('messages.CheckoutTituloOpcao') }}</h3>
          <div id="auth-choice" class="flex flex-col sm:flex-row items-stretch space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
            <div class="flex-1 border rounded-lg p-4 bg-gray-50 hover:bg-green-50 transition flex flex-col justify-between h-full min-h-[200px]">
              <div class="flex-1">
                <h3 class="font-semibold text-gray-800 mb-2">{{ __('messages.CheckoutJaTenhoConta') }}</h3>
                <p class="text-sm text-gray-600">{{ __('messages.CheckoutJaTenhoContaDesc') }}</p>
              </div>
              <button type="button" onclick="toggleAuth(true)" class="w-full bg-green-600 text-white py-2 rounded-lg shadow hover:bg-green-700">{{ __('messages.CheckoutEntrarContinuar') }}</button>
            </div>
            <div class="flex-1 border rounded-lg p-4 bg-gray-50 hover:bg-green-50 transition flex flex-col justify-between h-full min-h-[200px]">
              <div class="flex-1">
                <h3 class="font-semibold text-gray-800 mb-2">{{ __('messages.CheckoutCriarConta') }}</h3>
                <p class="text-sm text-gray-600">{{ __('messages.CheckoutCriarContaDesc') }}</p>
              </div>
              <button type="button" onclick="toggleAuth(false)" class="w-full bg-green-600 text-white py-2 rounded-lg shadow hover:bg-green-700">{{ __('messages.CheckoutCriarContinuar') }}</button>
            </div>
          </div>
          <!-- auth-controls moved above title -->
          <p id="auth-msg" class="text-[0.95rem] font-medium text-gray-700 mb-4"></p>
          <div id="login-form" class="auth-form hidden w-full" style="margin-right: 170px;">
            <input type="email" id="login-email" class="w-full border rounded-lg mb-3 px-4 sm:px-5 py-4 md:py-4 text-lg md:text-xl" required placeholder="{{ __('messages.CheckoutEmailPlaceholder') }}" />

            <div class="relative mb-4">
              <input type="password" id="login-password" class="w-full border rounded-lg px-4 sm:px-5 py-4 md:py-4 text-lg md:text-xl pr-24" required placeholder="{{ __('messages.CheckoutSenhaPlaceholder') }}" data-eye-initialized="true" />
              <button type="button" class="absolute inset-y-0 right-0 px-3 text-xl leading-none flex items-center text-gray-500 hover:text-gray-700 toggle-password" aria-label="Mostrar senha" title="Mostrar senha" aria-pressed="false" data-target="login-password" onclick="window.togglePasswordVisibility && window.togglePasswordVisibility('login-password', this)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-7 11-7c2.7 0 5.1.9 7 2.3"></path><path d="M23 12s-4 7-11 7c-2.7 0-5.1-.9-7-2.3"></path><path d="M1 1l22 22"></path><path d="M9.5 9.5a3 3 0 004.2 4.2"></path></svg></button>
            </div>
            <button type="button" id="validate-login" onclick="validateAndProceedLogin()" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">Entrar</button>
            <div id="login-errors" class="text-red-500 mt-2 text-sm text-center"></div>
          </div>

          <div id="register-form" class="auth-form hidden">
            <input type="text" id="register-name" class="w-full p-3 border rounded-lg mb-3" required placeholder="{{ __('messages.CheckoutNomePlaceholder') }}" />
            <input type="email" id="register-email" class="w-full p-3 border rounded-lg mb-3" required placeholder="{{ __('messages.CheckoutEmailPlaceholder') }}" />
            <div id="cpf-field-group">
              <input type="text" name="cpf" id="register-cpf" class="w-full p-3 border rounded-lg mb-3" required placeholder="{{ __('messages.CheckoutCpfPlaceholder') }}" />
            </div>
          <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-3 sm:space-y-0 mb-3">
              <div class="w-full sm:w-1/3">
                <label for="register-ddi" class="text-sm font-medium text-gray-700">{{ __('messages.CheckoutPaisLabel') }}</label>
                <select id="register-ddi" name="ddi" class="w-full p-3 border rounded-lg bg-white">
                    
                    <option value="" disabled selected>{{ __('messages.Checkoutselecionarpais') }}</option>

                    @foreach(config('countries.list') as $country)
                        <option data-countryCode="{{ $country['code'] }}" value="{{ $country['dial_code'] }}">
                            +{{ $country['dial_code'] }} {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
              </div>

              <div class="w-full sm:w-2/3">
                  <label for="register-phone" class="text-sm font-medium text-gray-700">{{ __('messages.CheckoutTelefoneLabel') }}</label>
                  <input type="tel" id="register-phone" class="w-full p-3 border rounded-lg" required placeholder="{{ __('messages.CheckoutTelefonePlaceholder') }}" />
              </div>
          </div>
            <div class="relative mb-4">
              <input type="password" id="register-password" class="w-full p-3 pr-12 border rounded-lg" required placeholder="{{ __('messages.CheckoutCriarSenhaPlaceholder') }}" data-eye-initialized="true" />
              <button type="button" class="absolute inset-y-0 right-0 px-3 text-xl leading-none flex items-center text-gray-500 hover:text-gray-700 toggle-password" aria-label="Mostrar senha" title="Mostrar senha" aria-pressed="false" data-target="register-password" onclick="window.togglePasswordVisibility && window.togglePasswordVisibility('register-password', this)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-7 11-7c2.7 0 5.1.9 7 2.3"></path><path d="M23 12s-4 7-11 7c-2.7 0-5.1-.9-7-2.3"></path><path d="M1 1l22 22"></path><path d="M9.5 9.5a3 3 0 004.2 4.2"></path></svg></button>
            </div>
            <button type="button" id="validate-register" onclick="validateAndProceedRegister()" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">{{ __('messages.CheckoutCadastrarContinuar') }}</button>
          
            <div id="register-errors" class="text-red-500 mt-2 text-sm text-center"></div>
          </div>
          </div>
        </div>

        {{-- AVISO DE ASSINATURA ATIVA E ETAPA 2 EM CONTAINER ÚNICO --}}
        <div id="step-2" class="step {{ $initialStep == 2 ? '' : 'hidden' }}">
            @if(($checkoutType ?? 'plan') === 'plan' && $subscriptionStatus === 'active')
                <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 mb-6 rounded-r-lg" style="padding-right: 164px !important;">
                    <div class="flex">
                        <div class="py-1">
                            {{-- Ícone de Alerta --}}
                            <svg class="h-6 w-6 text-yellow-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-yellow-800">{{ __('messages.CheckoutAssinaturaAtiva') }}</p>
                            <p class="text-sm text-yellow-700">{{ __('messages.CheckoutAssinaturaAtivaDesc') }}</p>
                        </div>
                    </div>
                </div>
            @else
                <h3 id="step-2-title" class="text-xl font-semibold text-gray-800 mb-4">
  @if(!empty($partialItems))
    {{ __('messages.CheckoutItensSelecionados') }}
  @elseif(($checkoutType ?? 'plan') === 'product')
    {{ __('messages.CheckoutEscolhaProduto') }}
  @else
    {{ __('messages.CheckoutEscolhaPlano') }}
  @endif
</h3>
                <div id="plan-list" class="space-y-4">
                    @forelse($plans->plans as $plan)
                        <div class="plan-option border p-4 rounded-lg shadow cursor-pointer hover:border-green-500 transition-all" 
                            data-plan-id="{{ $plan->id }}">
                            <div class="flex flex-col sm:flex-row items-start gap-4">
                                @if(($checkoutType ?? 'plan') === 'product' && !empty($plan->cover))
                                <img src="{{ $plan->cover }}" alt="{{ $plan->title }}" class="rounded object-contain max-w-full h-auto" style="max-height:150px;" />
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-semibold plan-title">{{ $plan->title }}</h4>
                                    <p class="text-sm text-gray-600 plan-description">
                                        @if(!empty($plan->description))
                                            {{ $plan->description }}
                                        @elseif(($checkoutType ?? 'plan') === 'product')
                                            {{ __('messages.Checkoutdescindisp') }}
                                        @else
                                            Assinatura com renovação automática.
                                        @endif
                                    </p>
                                    <p class="text-sm text-green-600 plan-description"></p>
                                    <p class="text-green-600 font-bold mt-2 plan-price">
                                        @php $priceCents = $plan->price ?? 0; @endphp
                                        R$ {{ number_format(($priceCents / 100), 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="border p-4 rounded-lg bg-gray-50 text-gray-700">
                            <p>@if(($checkoutType ?? 'plan') === 'product')Não foi possível carregar o produto no momento.@else Não foi possível carregar os planos no momento.@endif</p>
                        </div>
                    @endforelse
                </div>
                <button type="button" onclick="selectPlanAndProceed()" class="mt-6 w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">{{ __('messages.CheckoutContinuarPagamento') }}</button>
                <div id="plan-errors" class="text-red-500 mt-2 text-sm text-center"></div>
            @endif
        </div>


        <!-- ETAPA 3: PAGAMENTO (COM ANIMAÇÃO E OPÇÃO PIX) -->
        <div id="step-3" class="step {{ $initialStep == 3 ? '' : 'hidden' }}">
            <h2 class="text-xl font-bold mb-4 text-gray-800">{{ __('messages.CheckoutTituloPagamento') }}</h2>

            <!-- Layout Step 3: Resumo + Cartão lado a lado -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-start">
                <!-- Coluna Esquerda: Resumo do Pedido -->
                <div class="md:col-span-7 lg:col-span-6">
                    <div class="border rounded-lg p-6 mb-6 md:mb-0 bg-gray-50">
                        <h3 class="font-semibold text-lg mb-3">{{ __('messages.CheckoutResumoTitulo') }}</h3>
                        <div id="summary-plan-row" class="flex justify-between items-center" @if(!empty($partialItems)) style="display:none" @endif>
                            <span id="summary-plan-title" class="text-gray-700"></span>
                            <span id="summary-plan-price" class="font-bold text-gray-900"></span>
                        </div>

                        <div id="partial-items-summary" class="mt-2" @if(empty($partialItems)) style="display:none" @endif>
                            @if(!empty($partialItems))
                                @foreach($partialItems as $item)
                                    <div class="flex items-center gap-3 py-2 border-b border-gray-200 last:border-b-0">
                                        @if(!empty($item->cover))
                                            <img src="{{ $item->cover }}" alt="{{ $item->title ?? 'Item' }}" class="w-12 h-12 object-cover rounded max-w-full" />
                                        @endif
                                        <div class="flex-1 text-sm text-gray-700">{{ $item->title ?? 'Item' }}</div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="pt-3 text-right">
                                <span class="text-gray-600 mr-2">{{ __('messages.CheckoutTotal') }}</span>
                                <span id="partial-total-price" class="text-xl font-bold text-gray-900">
                                    @if(!empty($partialTotalPrice))
                                        R$ {{ number_format((($partialTotalPrice ?? 0) / 100), 2, ',', '.') }}
                                    @else
                                        R$ 0,00
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if(isset($subscriptionStatus) && $subscriptionStatus === 'active' && !empty($subscriberPurchaseDiscountPercent) && $subscriberPurchaseDiscountPercent > 0)
                            <!-- <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r">
                                <p class="text-green-800 text-sm">
                                    {{ __('messages.CheckoutBeneficioAssinante') }} {{ rtrim(rtrim(number_format($subscriberPurchaseDiscountPercent / 100, 2, ',', '.'), '0'), ',') }}% {{ __('messages.CheckoutBeneficioAssinanteDesc') }}
                                </p>
                            </div> -->
                        @endif
                    </div>
                </div>
                
                <!-- Coluna Direita: Cartão / Abas de Pagamento -->
                <div class="md:col-span-5 lg:col-span-6">
                    <!-- Abas de Pagamento -->
                    <div class="mb-6 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="payment-tabs">
                            <li class="mr-2">
                                <button class="payment-tab inline-block p-4 border-b-2 border-green-600 rounded-t-lg text-green-600" data-target="credit-card-content">{{ __('messages.CheckoutCartaoCredito') }}</button>
                            </li>
                            <li class="mr-2" style="display: none;">
                                <button class="payment-tab inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-target="pix-content">{{ __('messages.CheckoutPix') }}</button>
                            </li>
                        </ul>
                    </div>

                    <!-- Conteúdo das Abas -->
                    <div id="payment-tab-content">
                        <!-- Conteúdo Cartão de Crédito -->
                        <div id="credit-card-content" class="payment-tab-pane">
                            
                            <!-- Container para o cartão jQuery -->
                            <div class="card-wrapper mb-6"></div>
                            
                            <!-- Cartão Interativo -->
                            <style>
                              @media (max-width: 420px) { .credit-card-container { transform: scale(0.9); transform-origin: top center; } }
                              @media (max-width: 360px) { .credit-card-container { transform: scale(0.82); transform-origin: top center; } }
                            </style>
                            <div class="credit-card-container mb-8">
                                <div class="credit-card">
                                    <div class="credit-card-front">
                                        <div class="card-pattern"></div>
                                        <div class="card-chip"></div>
                                        <img id="card-brand-logo" class="card-brand-logo" src="{{ asset('imagens/cartaobandeira/Logo-dentalgo-branca-ATUALIZAADAAAANOVA.fw.png') }}" alt="Bandeira do Cartão" />
                                        <div class="card-number-display">•••• •••• •••• ••••</div>
                                        <div class="card-details-display">
                                            <div>
                                                <span class="card-label">{{ __('messages.Checkoutcartaonome') }}</span>
                                                <span class="card-holder-display">{{ __('messages.Checkoutcartaoseunome') }}</span>
                                            </div>
                                            <div>
                                                <span class="card-label">{{ __('messages.Checkoutcartaovalidade') }}</span>
                                                <span class="card-expiry-display">MM/AA</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="credit-card-back">
                                        <div class="card-mag-stripe"></div>
                                        <div class="card-cvv-box">
                                            <span class="card-cvv-display"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulário de Pagamento -->
                            <form id="payment-form" action="{{ route('checkoutnovo.processPayment') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="itemType" id="itemType" value="{{ ($checkoutType ?? (request()->has('productItemsIds') || request()->has('q.productItemsIds') || (is_array(request()->input('q')) && array_key_exists('productItemsIds', request()->input('q'))) ? 'product' : 'plan')) }}">
                                <input type="hidden" name="plan_id" id="plan_id" value="">
                                <!-- Suporte a compra parcial: product_id explícito e contêiner para itens -->
                                <input type="hidden" name="product_id" id="product_id" value="">
                                <div id="partialHiddenContainer"></div>
                                <input type="text" style="margin-bottom: 10px;" name="number" id="input-card-number" class="w-full p-3 border rounded-lg" data-iugu="number" placeholder="{{ __('messages.CheckoutNumeroCartao') }}" maxlength="19" />
                                <input type="text" style="margin-bottom: 10px;" name="name" id="input-card-holder" class="w-full p-3 border rounded-lg" data-iugu="full_name" placeholder="{{ __('messages.CheckoutNomeCartao') }}" />
                                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                    <input type="text" id="input-card-expiry" name="expiry" class="w-full sm:w-1/2 p-3 border rounded-lg" data-iugu="expiration" placeholder="{{ __('messages.CheckoutValidadeCartao') }}" maxlength="5" />
                                    <input type="text" id="input-card-cvv" name="cvc" class="w-full sm:w-1/2 p-3 border rounded-lg" placeholder="{{ __('messages.CheckoutCvvCartao') }}" data-iugu="verification_value" maxlength="4" />
                                </div>
                                <!-- 👇 ADICIONE ESTE CAMPO OCULTO EXATAMENTE AQUI 👇 -->
                                <input type="hidden" name="token" id="token" />

                                <div id="payment-errors" class="text-red-500 pt-2 text-sm text-center"></div>
                                <div id="payment-status" class="text-blue-500 pt-2 text-sm text-center hidden"></div>
                                
                                <!-- Sistema de Logs Visuais para Debug -->
                                <!-- <div id="debug-logs" class="mt-4 border rounded-lg" style="display: none">
                                    <div class="bg-gray-100 px-3 py-2 border-b flex justify-between items-center">
                                        <h6 class="text-sm font-semibold text-gray-700 mb-0">🔍 Debug Logs</h6>
                                        <div>
                                            <button type="button" class="text-xs bg-blue-500 text-white px-2 py-1 rounded mr-1" onclick="clearDebugLogs()">Limpar</button>
                                            <button type="button" class="text-xs bg-gray-500 text-white px-2 py-1 rounded" onclick="toggleDebugLogs()">Toggle</button>
                                        </div>
                                    </div>
                                    <div id="debug-logs-content" class="p-3" style="max-height: 250px; overflow-y: auto; font-family: 'Courier New', monospace; font-size: 11px; background-color: #f8f9fa; line-height: 1.3;">
                                        <div class="text-gray-500 text-center">Logs aparecerão aqui...</div>
                                    </div>
                                </div> -->
                            </form>
                        </div>

                        <!-- Conteúdo Pix -->
                        <div id="pix-content" class="payment-tab-pane hidden">
                            <div class="text-center p-6 border rounded-lg bg-gray-50">
                                <h3 class="text-lg font-semibold mb-4">{{ __('messages.CheckoutPixTitulo') }}</h3>
                                <p class="text-gray-600 mb-4">{{ __('messages.CheckoutPixDescricao') }}</p>
                                <div class="w-48 h-48 bg-gray-300 mx-auto mb-4 flex items-center justify-center">
                                    <span class="text-gray-500">{{ __('messages.CheckoutPixQrCode') }}</span>
                                </div>
                                <button class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-900 transition">{{ __('messages.CheckoutPixCopiar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 md:mt-6 lg:mt-8"></div>

            <!-- Botão de Finalizar (col-12) -->
            <button type="submit" id="payment-submit-btn" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition relative mt-4">
                <span id="btn-text">{{ __('messages.CheckoutFinalizarPagamento') }}</span>
                <div id="loading-spinner" style="margin-right: 216px;" class="hidden absolute inset-0 flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
        </div>
  </div>
</div>
<script>
    window.serverPartialItems = @json($partialItems ?? []);
    // Disponibiliza também os itens de produto vindos do backend (lista exibida na Etapa 2) para reidratação do parcial pós-login
    window.productItems = @json(($plans->plans ?? []) ?: []);
    if (!window.product || typeof window.product !== 'object') { window.product = {}; }
    window.product.items = window.productItems;
    window.product.productItems = window.productItems;
    
    // Variáveis globais (somente para exibição visual do desconto de assinante em produto/compra parcial)
    window.subscriptionStatus = @json($subscriptionStatus ?? null);
    window.subscriberPurchaseDiscountPercent = {{ $subscriberPurchaseDiscountPercent ?? 0 }};
    window.checkoutType = @json(($checkoutType ?? (request()->has('productItemsIds') || request()->has('q.productItemsIds') || (is_array(request()->input('q')) && array_key_exists('productItemsIds', request()->input('q'))) ? 'product' : 'plan')));
</script>
<script>
    window.currentLocale = @json($linguagem ?? app()->getLocale());
    window.i18n = {
        total: @json(__('messages.CheckoutTotal')),
        unavailable: @json(__('messages.CheckoutIndisponivel')),
        noneSelected: @json(__('messages.CheckoutNenhumItem')),
        someUnavailable: @json(__('messages.CheckoutItensIndisponiveis')),
        goToPayment: @json(__('messages.CheckoutIrPagamento')),
        qty: @json(__('messages.CheckoutQuantidade')),
        price: @json(__('messages.CheckoutPreco')),
        processingPayment: @json(__('messages.CheckoutProcessandoPagamento')),
        finishPayment: @json(__('messages.CheckoutFinalizarPagamento')),
        statusPayment: @json(__('messages.CheckoutStatusPagamento'))
    };
</script>
<script src="{{ asset('js/checkoutnovo_partial.js') }}"></script>
<script>
// Patch visual de desconto para assinantes (apenas UI)
(function(){
  function asPercent(){ return Number(window.subscriberPurchaseDiscountPercent||0)/100; }
  function asPercentText(){
    var p = asPercent();
    try { return p.toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).replace(/,0$/, ''); } catch(_) { return String(p).replace('.', ','); }
  }
  function fmtBRL(cents){
    try { return (Number(cents||0)/100).toLocaleString('pt-BR', {style:'currency', currency:'BRL'}); } catch(_) { return 'R$ ' + (Number(cents||0)/100).toFixed(2).replace('.', ','); }
  }
  function isSubscriberActive(){
    if (window.subscriptionStatus === 'active') return true;
    try {
      var raw = sessionStorage.getItem('user_data');
      if (!raw) return false;
      var u = JSON.parse(raw);
      var s = u && u.subscription;
      return !!(s && s.status === 'active' && s.plan && s.plan.status === true && (!s.canceledAt || s.canceledAt === null));
    } catch(_) { return false; }
  }
  function getCheckoutFlavor(){
    var type = String(window.checkoutType || '').toLowerCase();
    if (!type || type === 'plan') {
      var el = document.getElementById('itemType');
      var v = el ? (el.value || '').toLowerCase() : '';
      if (v) type = v;
    }
    if ((!type || type === 'plan') && Array.isArray(window.serverPartialItems) && window.serverPartialItems.length > 0) {
      type = 'product';
    }
    return type;
  }
  function canApply(){
    var isActive = isSubscriberActive();
    var type = getCheckoutFlavor();
    return isActive && (type === 'product' || type === 'produto') && Number(window.subscriberPurchaseDiscountPercent||0) > 0;
  }
  function calcDiscount(baseCents){
    var percent = Number(window.subscriberPurchaseDiscountPercent || 0); // ex: 1000 = 10%
    return Math.round((Number(baseCents||0) * percent) / 10000);
  }
  function ensureInfoBelow(el, id){
    if (!el) return null;
    var info = document.getElementById(id);
    if (!info){
      info = document.createElement('div');
      info.id = id;
      info.className = 'text-xs text-gray-600 mt-1';
      if (el.parentNode) el.parentNode.insertBefore(info, el.nextSibling);
    }
    return info;
  }
  function ensureBannerAfter(target, id){
    if (!target) return;
    if (!document.getElementById(id)){
      var warn = document.createElement('div');
      warn.id = id;
      warn.className = 'mt-2 text-sm text-green-700 bg-green-50 border-l-4 border-green-500 p-3 rounded-r';
      warn.textContent = (t ? t('CheckoutBannerAssinanteAplicado','Assinante DentalGO: desconto de {percent} aplicado automaticamente no pagamento.') : 'Assinante DentalGO: desconto de {percent} aplicado automaticamente no pagamento.').replace('{percent}', asPercentText());
      target.parentNode.insertBefore(warn, target.nextSibling);
    }
  }
  function applyOnStep2(){
    if (!canApply()) return;
    var totalEl = document.getElementById('partial-total-price-dynamic');
    if (!totalEl || !window.partialCheckoutState) return;
    var base = Number(window.partialCheckoutState.totalCents||0);
    var disc = calcDiscount(base);
    var finalV = base - disc;
    totalEl.textContent = fmtBRL(finalV);
    var info = ensureInfoBelow(totalEl, 'partial-total-price-formula');
    if (info) info.textContent = fmtBRL(base) + ' - ' + asPercentText() + '% = ' + fmtBRL(finalV);
    ensureBannerAfter(document.getElementById('partial-items-list'), 'partial-discount-banner');
  }
  function applyOnStep3(){
    if (!canApply()) return;
    var totalEl = document.getElementById('partial-total-price');
    if (!totalEl || !window.partialCheckoutState) return;
    var base = Number(window.partialCheckoutState.totalCents||0);
    var disc = calcDiscount(base);
    var finalV = base - disc;
    try {
       var already = (totalEl.dataset && totalEl.dataset.discountApplied === '1');
       totalEl.innerHTML = '<s class="text-gray-500" style="text-decoration: line-through; text-decoration-color:#6b7280; text-decoration-thickness:1.5px; margin-right: 8px; display:inline-block;">' + fmtBRL(base) + '</s>'+
                            '<span aria-hidden="true" style="display:inline-block;width:6px;"></span>'+
                            '<span class="text-green-700 font-bold" style="font-weight:700; color:#047857; display:inline-block;">' + fmtBRL(finalV) + '</span>';
       if (!already) { totalEl.dataset.discountApplied = '1'; }
     } catch(_) {
       totalEl.textContent = fmtBRL(finalV);
     }
    try {
      var info = document.getElementById('partial-total-price-formula-step3');
      if (info) info.remove();
    } catch(_){}
    var wrap = document.getElementById('partial-items-summary');
    if (wrap && !document.getElementById('partial-discount-banner-step3')) {
      var infoBanner = document.createElement('div');
      infoBanner.id = 'partial-discount-banner-step3';
      infoBanner.className = 'mt-2 text-sm text-green-700 bg-green-50 border-l-4 border-green-500 p-3 rounded-r';
      infoBanner.textContent = (t ? t('CheckoutBannerAssinanteVisual','Assinante DentalGO: desconto de {percent} (visual)') : 'Assinante DentalGO: desconto de {percent} (visual)').replace('{percent}', asPercentText());
      wrap.insertBefore(infoBanner, wrap.firstChild);
    }
  }
  // Monkey-patch para aplicar após cada renderização
  var _renderPartialStep = window.renderPartialStep;
  window.renderPartialStep = function(){ if (typeof _renderPartialStep === 'function') { _renderPartialStep.apply(this, arguments); } try{ applyOnStep2(); }catch(e){} };
  var _updateStep3 = window.updateStep3PartialSummaryFromState;
  window.updateStep3PartialSummaryFromState = function(){ if (typeof _updateStep3 === 'function') { _updateStep3.apply(this, arguments); } try{ applyOnStep3(); }catch(e){} };
  // Escuta eventos de variação de itens/quantidades e recálculo
  document.addEventListener('partial:recalc', function(){ try{ applyOnStep2(); applyOnStep3(); }catch(e){} });
  document.addEventListener('partial:render', function(){ try{ applyOnStep2(); }catch(e){} });
  // Tentativa periódica enquanto elementos ainda não existem
  var tries = 0, t = setInterval(function(){
    tries++;
    try { applyOnStep2(); applyOnStep3(); } catch(e){}
    if (tries > 20) clearInterval(t);
  }, 300);
  document.addEventListener('DOMContentLoaded', function(){ try{ applyOnStep2(); applyOnStep3(); }catch(e){} });
})();
</script>
<script>
// UI: aplicar desconto visual para produto completo (não parcial) nas Etapas 2 e 3
(function(){
  function percentBps(){ return Number(window.subscriberPurchaseDiscountPercent||0); }
  function asPercentText(){
    var p = percentBps()/100;
    try { return p.toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).replace(/,0$/, ''); } catch(_) { return String(p).replace('.', ','); }
  }
  function fmtBRL(cents){
    try { return (Number(cents||0)/100).toLocaleString('pt-BR', {style:'currency', currency:'BRL'}); } catch(_) { return 'R$ ' + (Number(cents||0)/100).toFixed(2).replace('.', ','); }
  }
  function parseBRLToCents(txt){
    try {
      txt = (txt||'').toString();
      txt = txt.replace(/[^0-9,\.]/g, '');
      if (!txt) return NaN;
      var parts = txt.split(',');
      var intPart = parts[0].replace(/\./g, '');
      var decPart = (parts[1]||'00').padEnd(2,'0').slice(0,2);
      var cents = parseInt(intPart,10)*100 + parseInt(decPart,10);
      return Number.isFinite(cents) ? cents : NaN;
    } catch(_) { return NaN; }
  }
  function isSubscriberActive(){
    if (window.subscriptionStatus === 'active') return true;
    try {
      var raw = sessionStorage.getItem('user_data');
      if (!raw) return false;
      var u = JSON.parse(raw);
      var s = u && u.subscription;
      return !!(s && s.status === 'active' && s.plan && s.plan.status === true && (!s.canceledAt || s.canceledAt === null));
    } catch(_) { return false; }
  }
  function isProductContext(){
    var type = String(window.checkoutType||'').toLowerCase();
    if (!type || type === 'plan'){
      var el = document.getElementById('itemType');
      var v = el ? (el.value||'').toLowerCase() : '';
      if (v) type = v;
    }
    return (type === 'product' || type === 'produto');
  }
  function isPartialActive(){
    return !!(window.partialCheckoutState && window.partialCheckoutState.valid);
  }
  function canApply(){
    return isSubscriberActive() && isProductContext() && percentBps() > 0 && !isPartialActive();
  }
  function computeDiscounted(baseCents){
    var bps = percentBps(); // ex: 1000 = 10%
    return Math.round(Number(baseCents||0) * (10000 - bps) / 10000);
  }
  function applyOnStep2Product(){
    if (!canApply()) return;
    try {
      var cards = document.querySelectorAll('#plan-list .plan-option .plan-price');
      cards.forEach(function(el){
        if (!el || el.dataset && el.dataset.discountApplied === '1') return;
        var baseCents = parseBRLToCents(el.textContent || '');
        if (!Number.isFinite(baseCents) || baseCents <= 0) return;
        var discounted = computeDiscounted(baseCents);
        // guarda preço base formatado para reutilização nas próximas etapas
        try { el.dataset.basePrice = fmtBRL(baseCents); } catch(_){ }
        el.innerHTML = '<span class="line-through mr-2 text-gray-500">' + fmtBRL(baseCents) + '</span>' +
                       '<span class="text-green-700 font-bold">' + fmtBRL(discounted) + '</span>';
        el.dataset.discountApplied = '1';
        // Banner informativo após descrição (uma única vez por card)
        var container = el.closest('.plan-option');
        if (container && !container.querySelector('.product-discount-banner')){
          var desc = container.querySelector('.plan-description') || el;
          var wrap = document.createElement('div');
          wrap.className = 'product-discount-banner mt-1 text-xs text-green-700';
          wrap.textContent = ((typeof t==='function')? t('CheckoutDescontoAssinante','Desconto de assinante: {percent}%.') : 'Desconto de assinante: {percent}%.').replace('{percent}', asPercentText());

          if (desc && desc.parentNode) desc.parentNode.insertBefore(wrap, el);
        }
      });
    } catch(_){}}
  function applyOnStep3Product(){
    if (!canApply()) return;
    try {
      var priceEl = document.getElementById('summary-plan-price');
      if (!priceEl) return;
      // evita aplicar duas vezes: se já existir <s>, já está formatado
      if (priceEl.querySelector('s')) return;
      // tenta usar valor base persistido (se existir) para não concatenar números
      var baseTxt = (priceEl.dataset && priceEl.dataset.basePrice) ? priceEl.dataset.basePrice : (priceEl.textContent || '');
      var baseCents = parseBRLToCents(baseTxt);
      if (!Number.isFinite(baseCents) || baseCents <= 0) return;
      var discounted = computeDiscounted(baseCents);
      priceEl.innerHTML = '<span class="line-through mr-2 text-gray-500">' + fmtBRL(baseCents) + '</span>' +
                           '<span class="text-green-700 font-bold">' + fmtBRL(discounted) + '</span>';
      // garantir espaçamento/alinhamento do container
      try { priceEl.style.display = 'inline-flex'; priceEl.style.alignItems = 'baseline'; priceEl.style.gap = '6px'; } catch(_){}
      priceEl.dataset.discountApplied = '1';
      // Fórmula explícita abaixo do resumo (ex.: R$ 1,73 - 10% = R$ 1,56)
      var formula = document.getElementById('product-total-price-formula-step3');
      if (!formula) {
        formula = document.createElement('div');
        formula.id = 'product-total-price-formula-step3';
        formula.className = 'text-xs text-gray-600 mt-1';
        var row = document.getElementById('summary-plan-row');
        if (row && row.parentNode) row.parentNode.insertBefore(formula, row.nextSibling);
      // }
      formula.textContent = fmtBRL(baseCents) + ' - ' + asPercentText() + '% = ' + fmtBRL(discounted);
      // Banner informativo no resumo
      var row = document.getElementById('summary-plan-row');
      if (row && !document.getElementById('product-discount-banner-step3')){
        var info = document.createElement('div');
        info.id = 'product-discount-banner-step3';
        info.className = 'mt-2 text-sm text-green-700 bg-green-50 border-l-4 border-green-500 p-3 rounded-r';
        info.textContent = (t ? t('CheckoutBannerAssinanteAplicadoResumo','{{ __('messages.CheckoutBannerAssinanteAplicadoResumo') }}') : '{{ __('messages.CheckoutBannerAssinanteAplicadoResumo') }}').replace('{percent}', asPercentText());
        var wrap = row.parentNode; // container do resumo
        if (wrap) wrap.insertBefore(info, row.nextSibling);
      }
    } catch(_){ }
  }
  function tryApplyAll(){
    try { applyOnStep2Product(); } catch(_){}
    try { applyOnStep3Product(); } catch(_){}
  }
  // Hooks em ações comuns
  var _next2 = window.nextStep;
  window.nextStep = function(step){
    if (typeof _next2 === 'function') { _next2.apply(this, arguments); }
    try { if (step === 2) applyOnStep2Product(); if (step === 3) applyOnStep3Product(); } catch(_){ }
  };
  var _select = window.selectPlanAndProceed;
  window.selectPlanAndProceed = function(){
    var r = (typeof _select === 'function') ? _select.apply(this, arguments) : undefined;
    setTimeout(function(){ tryApplyAll(); }, 50);
    return r;
  };
  document.addEventListener('DOMContentLoaded', function(){ tryApplyAll(); });
  var tries = 0, timer = setInterval(function(){ tries++; tryApplyAll(); if (tries > 20) clearInterval(timer); }, 300);
  try { window.applyOnStep3Product = applyOnStep3Product; } catch(e) {}
})();
</script>
<script>
// Expor traduções para o JavaScript
window.messages = window.messages || {
  CheckoutBannerAssinanteAplicado: "{{ __('messages.CheckoutBannerAssinanteAplicado') }}",
  CheckoutBannerAssinanteVisual: "{{ __('messages.CheckoutBannerAssinanteVisual') }}",
  CheckoutDescontoAssinante: "{{ __('messages.CheckoutDescontoAssinante') }}",
  CheckoutErroPreenchaCampos: "{{ __('messages.CheckoutErroPreenchaCampos') }}",
  CheckoutErroEmailInvalido: "{{ __('messages.CheckoutErroEmailInvalido') }}",
  CheckoutValidando: "{{ __('messages.CheckoutValidando') }}",
  CheckoutErroEmailNaoLocalizado: "{{ __('messages.CheckoutErroEmailNaoLocalizado') }}",
  CheckoutSenhaIncorreta: "{{ __('messages.CheckoutSenhaIncorreta') }}",
  CheckoutCredenciaisInvalidas: "{{ __('messages.CheckoutCredenciaisInvalidas') }}",
  CheckoutErroComunicacao: "{{ __('messages.CheckoutErroComunicacao') }}",
  CheckoutEntrar: "{{ __('messages.CheckoutEntrar') }}"
};
(function(){
  function t(key, fallback){
    var v = (window.messages && window.messages[key]) || '';
    if (!v || /^messages\./.test(v)) return fallback;
    return v;
  }
  function asPercentText(){
    try { return (Number(window.subscriberPurchaseDiscountPercent||0)/100).toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).replace(/,0$/, ''); } catch(_) { return String(Number(window.subscriberPurchaseDiscountPercent||0)/100).replace('.', ','); }
  }
  function applyLocalization(){
    try {
      var b1 = document.getElementById('partial-discount-banner');
      if (b1) b1.textContent = t('CheckoutBannerAssinanteAplicado', b1.textContent).replace('{percent}', asPercentText());
      var b2 = document.getElementById('partial-discount-banner-step3');
      if (b2) b2.textContent = t('CheckoutBannerAssinanteVisual', b2.textContent).replace('{percent}', asPercentText());
      var b3 = document.querySelector('.product-discount-banner');
      if (b3) b3.textContent = t('CheckoutDescontoAssinante', b3.textContent).replace('{percent}', asPercentText());
      var b4 = document.getElementById('product-discount-banner-step3');
      if (b4) b4.textContent = t('CheckoutBannerAssinanteAplicado', b4.textContent).replace('{percent}', asPercentText());
      var loginBtn = document.getElementById('validate-login');
      if (loginBtn && !loginBtn.dataset.i18nSet) { loginBtn.textContent = t('CheckoutEntrar', loginBtn.textContent); loginBtn.dataset.i18nSet = '1'; }
    } catch(e){}
  }
  document.addEventListener('DOMContentLoaded', applyLocalization);
  document.addEventListener('partial:render', applyLocalization);
})();
</script>
<script>



        document.addEventListener('DOMContentLoaded', function() {
            updateStepIndicator(<?php echo isset($initialStep) ? $initialStep : 1; ?>);
            try { if (typeof nextStep === 'function') { nextStep(<?php echo isset($initialStep) ? $initialStep : 1; ?>); } } catch (e) { console.warn('Falha ao inicializar step:', e); }
            // Armazena o conteúdo original do step-2 para possível restauração
            storeOriginalStep2Content();
            
            // Verifica status do usuário apenas no carregamento inicial
            checkUserSubscriptionAndUpdateUI();
            
            // Configuração do campo DDI e CPF
            const ddiSelect = document.getElementById('register-ddi');
            const cpfGroup = document.getElementById('cpf-field-group');

            // Função para verificar e alternar a visibilidade do campo CPF
            function toggleCpfField() {
                if (ddiSelect && ddiSelect.value === '55') {
                    // Se o DDI for 55 (Brasil), mostra o campo CPF
                    if (cpfGroup) cpfGroup.style.display = 'block';
                } else {
                    // Se for qualquer outro DDI, esconde o campo CPF
                    if (cpfGroup) cpfGroup.style.display = 'none';
                }
            }

            // Adiciona um "ouvinte" que chama a função sempre que o DDI for alterado
            if (ddiSelect) {
                ddiSelect.addEventListener('change', toggleCpfField);
                // Chama a função uma vez no início para definir o estado inicial correto
                toggleCpfField();
            }

            // Cleanup de seleção parcial: se a URL não contém itens parciais e não há indicação server-side, limpa sessionStorage
            try {
              const usp = new URLSearchParams(window.location.search || '');
              const hasUrlPartial = usp.has('productItemsIds') || (usp.getAll('q[productItemsIds][]') || []).length > 0;
              const hasServerPartial = !!(window.serverPartialItems && Array.isArray(window.serverPartialItems) && window.serverPartialItems.length) || !!document.getElementById('server-partial-items');
              if (!hasUrlPartial && !hasServerPartial) {
                ['checkout_product_items_ids','partialProductItemsIds','pendingPartialIds','partial_product_items','partialProductItems','checkout_partial_state'].forEach(function(k){
                  try { sessionStorage.removeItem(k); } catch(_) {}
                });
                try { window.__partialInitDone = false; } catch(_) {}
              }
            } catch(_) {}

            // Atualiza a UI de acordo com o contexto detectado (Plano/Produto/Parcial)
            if (typeof updateUIForContext === 'function') { updateUIForContext(); }
         });

async function validateAndProceedLogin() {
    const emailInput = document.getElementById('login-email');
    const passwordInput = document.getElementById('login-password');
    const errorDiv = document.getElementById('login-errors');
    const loginButton = document.getElementById('validate-login');

    const email = emailInput.value.trim();
    const password = passwordInput.value;

    // Validações básicas
    if (!email || !password) {
        errorDiv.textContent = 'Por favor, preencha todos os campos.';
        return;
    }

    if (!isValidEmail(email)) {
        errorDiv.textContent = 'Por favor, insira um e-mail válido.';
        return;
    }

    errorDiv.textContent = '';
    loginButton.disabled = true;
    loginButton.textContent = 'Validando...';

    // Esconde o aviso de e-mail não localizado a cada nova tentativa
    const emailNotFoundEl = document.getElementById('login-email-not-found');
    if (emailNotFoundEl) emailNotFoundEl.classList.add('hidden');

    try {
        const response = await fetch('/checkout/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            credentials: 'same-origin',
            body: JSON.stringify({ email, password })
        });

        const contentType = response.headers.get('content-type') || '';
        const isJson = contentType.includes('application/json');
        let data = null;
        if (isJson) {
            try { data = await response.json(); } catch (_) { data = null; }
        }

        if (response.ok) {
            const payload = isJson ? (data || {}) : {};
            console.log("Login realizado com sucesso:", payload);
            
            // Armazena dados do usuário na sessão
            if (payload.user) {
                sessionStorage.setItem('user_data', JSON.stringify(payload.user));
            }
            
            // Atualiza UI e avança para Step 2
            try { await checkUserSubscriptionAndUpdateUI(); } catch (e) { console.warn('Falha ao atualizar UI pós-login:', e); }
            nextStep(2);
            if (typeof updateUIForContext === 'function') { try { updateUIForContext(); } catch(_) {} }
            try { document.dispatchEvent(new CustomEvent('login:success', { detail: { source: 'checkoutnovo', method: 'login', user: payload.user || null } })); } catch (e) { console.warn('Falha ao disparar login:success', e); }
            try {
              const usp = new URLSearchParams(window.location.search || '');
              const hasUrlPartial = usp.has('productItemsIds') || (usp.getAll('q[productItemsIds][]') || []).length > 0 || (usp.getAll('productItemsIds[]') || []).length > 0;
              const hasServerPartial = !!(window.serverPartialItems && Array.isArray(window.serverPartialItems) && window.serverPartialItems.length) || !!document.getElementById('server-partial-items');
              if (hasUrlPartial || hasServerPartial) {
                document.dispatchEvent(new CustomEvent('partial:init-request', { detail: { step: 2, context: 'post-login' } }));
              }
            } catch (e) { console.warn('Falha ao disparar partial:init-request', e); }
            try { sessionStorage.setItem('post_auth_refresh_needed', '1'); } catch(_) {}
            try { window.location.reload(); } catch(_) {}
        } else {
            // Tratar especificamente e-mail inexistente (404/409) ou retorno equivalente da API (userNotFound)
            const emailInexistente = response.status === 404 || response.status === 409 ||
                (data && (data.code === 'userNotFound'
                    || /usu[aá]rio n[aã]o encontrado/i.test(data?.message || '')
                    || /e-?mail n[aã]o localizado/i.test(data?.message || '')
                    || /n[aã]o existe/i.test(data?.message || '')
                    || /not found/i.test(data?.message || '')));

            if (emailInexistente) {
                // Mostrar como os outros erros (vermelho), abaixo do botão Entrar
                errorDiv.textContent = 'E-mail não localizado. Verifique se digitou corretamente ou crie uma conta.';
                document.getElementById('login-email')?.focus();
                loginButton.disabled = false;
                loginButton.textContent = 'Entrar';
                return; // Exibe apenas este aviso para este caso
            }

            // Demais erros: trata senha incorreta explicitamente e mantém fallback
            const wrongPassword = (response.status === 401) || (data && (data.code === 'wrongPassword' || /(senha|password)/i.test(data?.message || '')));
            if (wrongPassword) {
                errorDiv.textContent = (data && data.message) ? data.message : 'Senha incorreta.';
            } else {
                errorDiv.textContent = (data && data.message) ? data.message : 'Credenciais inválidas.';
            }
            loginButton.disabled = false;
            loginButton.textContent = 'Entrar';
        }

    } catch (error) {
        console.error('Erro na requisição de login:', error);
        errorDiv.textContent = 'Ocorreu um erro de comunicação. Tente novamente.';
        loginButton.disabled = false;
        loginButton.textContent = 'Entrar';
    }
}

// Função para verificar assinatura do usuário e atualizar a UI dinamicamente
// Flag para evitar múltiplas execuções
let validationInProgress = false;

async function checkUserSubscriptionAndUpdateUI() {
    // Evita execução múltipla
    if (validationInProgress) {
        console.log('Validação já em andamento, ignorando chamada');
        return;
    }
    
    validationInProgress = true;
    
    try {
        console.log('=== INICIANDO VALIDAÇÃO DO USUÁRIO ===');
        
        // Obtém dados do usuário diretamente do PHP e faz fallback para sessionStorage
        const userDataServer = @json(session()->get('usuario'));
        let userData = (userDataServer && typeof userDataServer === 'object' && Object.keys(userDataServer).length) ? userDataServer : null;
        if (!userData) { try { userData = JSON.parse(sessionStorage.getItem('user_data') || 'null'); } catch(_) { userData = null; } }
        console.log('Dados do usuário:', userData);
        
        // Se não há dados do usuário na sessão, permanece no step 1 (login)
        if (!userData) {
            console.log('Usuário não logado - permanecendo no step 1 para login');
            try { if (typeof nextStep === 'function') { nextStep(1); } } catch (e) { console.warn('Falha ao voltar para step 1:', e); }
            return;
        }

        // NOVA VERIFICAÇÃO: Valida o token via backend apenas se há dados do usuário
        console.log('Validando token via API backend...');
        try {
            const tokenValidationResponse = await fetch('/api/validate-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            });
            
            // Verifica se a resposta é válida
            if (!tokenValidationResponse.ok) {
                console.log('Resposta de validação não OK, permanecendo no step 1');
                try { if (typeof nextStep === 'function') { nextStep(1); } } catch (e) { console.warn('Falha ao voltar para step 1:', e); }
                return;
            }
            
            const tokenValidation = await tokenValidationResponse.json();
            console.log('Resultado da validação do token:', tokenValidation);
            
            // Se o token é inválido, permanece no step 1
            if (!tokenValidation.valid) {
                console.log('Token inválido - permanecendo no step 1 para novo login');
                // Limpa dados da sessão sem recarregar a página
                sessionStorage.clear();
                try { if (typeof nextStep === 'function') { nextStep(1); } } catch (e) { console.warn('Falha ao voltar para step 1:', e); }
                return;
            }
            
            console.log('Token válido - prosseguindo com verificação de assinatura');
            
        } catch (tokenError) {
            console.error('Erro ao validar token:', tokenError);
            console.log('Erro na validação do token - permanecendo no step 1');
            try { if (typeof nextStep === 'function') { nextStep(1); } } catch (e) { console.warn('Falha ao voltar para step 1:', e); }
            return;
        }

        // Verifica se o usuário tem assinatura ativa
        const hasActiveSubscription = userData.subscription && 
            userData.subscription.status === 'active' && 
            userData.subscription.plan && 
            userData.subscription.plan.status === true && 
            (!userData.subscription.canceledAt || userData.subscription.canceledAt === null);

        // Verifica se há flag de validação de pagamento pendente
        const paymentValidationRequired = @json(session()->get('payment_validation_required', false));
        
        console.log('Assinatura ativa:', hasActiveSubscription);
        console.log('Validação de pagamento necessária:', paymentValidationRequired);

        // Respeita o tipo de checkout e detecta fluxo parcial pela URL
        const itemTypeEl = document.getElementById('itemType');
        let itemType = itemTypeEl ? (itemTypeEl.value || '').toLowerCase() : 'plan';

        // Detecta fluxo PARCIAL pela querystring para não sobrescrever Step 2
        let isParcial = false;
        try {
            const usp = new URLSearchParams(window.location.search || '');
            let urlIds = [];
            const arr1 = usp.getAll('q[productItemsIds][]');
            const arr2 = usp.getAll('productItemsIds[]');
            const arr3 = usp.getAll('q[productItemsIds]');
            if (arr1 && arr1.length) urlIds = urlIds.concat(arr1);
            if (arr2 && arr2.length) urlIds = urlIds.concat(arr2);
            if (arr3 && arr3.length) urlIds = urlIds.concat(arr3);
            const flat = usp.get('productItemsIds');
            if (flat) urlIds = urlIds.concat(String(flat).split(/[\s,;]+/));
            const nums = urlIds.map(v => String(v).trim()).filter(v => /^\d+$/.test(v)).map(v => parseInt(v, 10));
            isParcial = nums.length > 0;
            if (isParcial) {
                if (itemTypeEl) itemTypeEl.value = 'product';
                itemType = 'product';
            }
        } catch(e) {}

        if (isParcial) {
            console.log('Fluxo PARCIAL detectado - reidratando UI parcial e evitando sobrescrita');
            if (typeof updateUIForContext === 'function') { try { updateUIForContext(); } catch(_) {} }
        } else if (itemType === 'product' || itemType === 'produto') {
            console.log('Checkout de produto - exibindo seleção de itens/produtos (sem aviso de assinatura ativa)');
            showPlanSelection();
        } else {
            if (hasActiveSubscription && !paymentValidationRequired) {
                console.log('Mostrando aviso de assinatura ativa (checkout de plano)');
                showActiveSubscriptionWarning();
            } else {
                console.log('Mostrando seleção de planos (checkout de plano)');
                showPlanSelection();
            }
        }
        
        // Não forçar avanço de etapa aqui; o fluxo respeita o initialStep do backend e ações do usuário
        console.log('Validação concluída - UI atualizada sem forçar avanço de etapa');
        console.log('=== VALIDAÇÃO CONCLUÍDA ===');
        
    } catch (error) {
        console.error('Erro ao verificar status do usuário:', error);
        // Em caso de erro, permanece no step 1
        console.log('Erro detectado - permanecendo no step 1');
    } finally {
        // Reset da flag para permitir futuras validações
        validationInProgress = false;
    }
}

// Função para mostrar o aviso de assinatura ativa
function showActiveSubscriptionWarning() {
    const step2 = document.getElementById('step-2');
    step2.innerHTML = `
        <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 mb-6 rounded-r-lg" style="padding-right:164px;">
            <div class="flex">
                <div class="py-1">
                    <svg class="h-6 w-6 text-yellow-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-yellow-800">{{ __('messages.CheckoutAssinaturaAtiva') }}</p>
                    <p class="text-sm text-yellow-700">{{ __('messages.CheckoutAssinaturaAtivaDesc') }}</p>
                </div>
            </div>
        </div>
    `;
}

// Armazena o conteúdo original do step-2 para restauração
let originalStep2Content = null;

// Função para armazenar o conteúdo original do step-2
function storeOriginalStep2Content() {
    if (!originalStep2Content) {
        const step2 = document.getElementById('step-2');
        if (step2) {
            originalStep2Content = step2.innerHTML;
        }
    }
}

// Função para mostrar a seleção de planos
function showPlanSelection() {
    const step2 = document.getElementById('step-2');
    
    // Restaura o conteúdo original da seleção de planos
    if (originalStep2Content) {
        step2.innerHTML = originalStep2Content;
        // Reativa os event listeners para os planos
        reactivatePlanListeners();
        // Auto-seleção inteligente quando é produto: prioriza ID vindo da URL
        const plans = step2.querySelectorAll('.plan-option');
        let preselected = false;
        const itemTypeEl = document.getElementById('itemType');
        const itemType = itemTypeEl ? (itemTypeEl.value || '').toLowerCase() : '';
        if ((itemType === 'product' || itemType === 'produto') && plans.length > 0) {
            const parts = (window.location.pathname || '').split('/').filter(Boolean);
            const maybeId = parts[parts.length - 1] || '';
            if (/^\d+$/.test(maybeId)) {
                const productId = maybeId;
                const target = Array.from(plans).find(el => (el.dataset.planId || '') === productId);
                if (target) {
                    // Não disparar click automático para não avançar de etapa sem consentimento
                    step2.querySelectorAll('.plan-option').forEach(p => p.classList.remove('border-green-500','border-2','bg-green-50'));
                    target.classList.add('border-green-500','border-2','bg-green-50');
                    window.selectedPlan = {
                      id: target.dataset.planId,
                      title: target.querySelector('.plan-title') ? target.querySelector('.plan-title').textContent : '',
                      price: target.querySelector('.plan-price') ? target.querySelector('.plan-price').textContent : ''
                    };
                    const planHidden = document.getElementById('plan_id');
                    if (planHidden) planHidden.value = window.selectedPlan.id;
                    const titleEl = document.getElementById('summary-plan-title');
                    const priceEl = document.getElementById('summary-plan-price');
                    if (titleEl) titleEl.textContent = window.selectedPlan.title || '';
                    if (priceEl) priceEl.textContent = window.selectedPlan.price || '';
                    preselected = true;
                }
            }
        }
        // Fallback: auto-seleciona se houver apenas um plano
        if (!preselected && plans.length === 1) {
            plans[0].click();
        }
        // Se já existia um plano selecionado globalmente, re-hidrata visual e hidden
        if (window.selectedPlan && window.selectedPlan.id) {
            const selectedEl = step2.querySelector(`[data-plan-id="${window.selectedPlan.id}"]`);
            if (selectedEl) {
                step2.querySelectorAll('.plan-option').forEach(p => p.classList.remove('border-green-500','border-2','bg-green-50'));
                selectedEl.classList.add('border-green-500','border-2','bg-green-50');
            }
            const planHidden = document.getElementById('plan_id');
            if (planHidden) planHidden.value = window.selectedPlan.id;
            const titleEl = document.getElementById('summary-plan-title');
            const priceEl = document.getElementById('summary-plan-price');
            if (titleEl && priceEl) {
                titleEl.textContent = window.selectedPlan.title || '';
                priceEl.textContent = window.selectedPlan.price || '';
            }
            if (typeof updateUIForContext === 'function') { updateUIForContext(); }
        }
    }
}

// Função para reativar os event listeners dos planos
function reactivatePlanListeners() {
    document.querySelectorAll('.plan-option').forEach(plan => {
        plan.addEventListener('click', function() {
            // Remove seleção anterior
            document.querySelectorAll('.plan-option').forEach(p => p.classList.remove('border-green-500', 'bg-green-50'));
            
            // Adiciona seleção atual
            this.classList.add('border-green-500', 'bg-green-50');
            
            // Armazena o plano selecionado (sincroniza local e global)
            const priceNode = this.querySelector('.plan-price');
            const basePrice = priceNode ? (priceNode.dataset.basePrice || priceNode.textContent) : '';
            selectedPlan = window.selectedPlan = {
                id: this.dataset.planId,
                title: this.querySelector('.plan-title') ? this.querySelector('.plan-title').textContent : '',
                price: basePrice
            };
            
            // Sincroniza campo oculto e resumo
            const planHidden = document.getElementById('plan_id');
            if (planHidden) planHidden.value = selectedPlan.id;
            const titleEl = document.getElementById('summary-plan-title');
            const priceEl = document.getElementById('summary-plan-price');
            if (titleEl) titleEl.textContent = selectedPlan.title || '';
            if (priceEl) { priceEl.textContent = basePrice || ''; try { priceEl.dataset.basePrice = basePrice || ''; } catch(_){} }
            const itemTypeEl = document.getElementById('itemType');
            if (itemTypeEl && ((itemTypeEl.value || '').toLowerCase() !== 'product')) itemTypeEl.value = 'plan';

            const err = document.getElementById('plan-errors');
            if (err) err.textContent = '';

            if (typeof updateUIForContext === 'function') { updateUIForContext(); }
        });
    });
}


async function validateAndProceedRegister() {
    const name = document.getElementById('register-name').value.trim();
    const email = document.getElementById('register-email').value.trim();
    const cpf = document.getElementById('register-cpf').value.trim();
    const ddi = document.getElementById('register-ddi').value;
    const phone = document.getElementById('register-phone').value.trim();
    const password = document.getElementById('register-password').value;
    const errorDiv = document.getElementById('register-errors');
    const registerButton = document.getElementById('validate-register');

    errorDiv.textContent = '';
    
    // Validações aprimoradas
    if (!name || name.length < 2) {
        errorDiv.textContent = 'Por favor, insira um nome válido (mínimo 2 caracteres).';
        return;
    }

    if (!email || !isValidEmail(email)) {
        errorDiv.textContent = 'Por favor, insira um e-mail válido.';
        return;
    }

    if (!ddi) {
        errorDiv.textContent = 'Por favor, selecione o país.';
        return;
    }

    if (!phone || phone.length < 8) {
        errorDiv.textContent = 'Por favor, insira um telefone válido.';
        return;
    }

    if (!password || password.length < 6) {
        errorDiv.textContent = 'A senha deve ter pelo menos 6 caracteres.';
        return;
    }

    // Validação específica para Brasil
    if (ddi === '55' && (!cpf || !isValidCPF(cpf))) {
        errorDiv.textContent = 'Para o Brasil, é necessário um CPF válido.';
        return;
    }

    registerButton.disabled = true;
    registerButton.textContent = 'Cadastrando...';

    try {
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            body: JSON.stringify({ name, email, cpf, ddi, phone, password })
        });

        const data = await response.json();

        if (response.ok) {
            console.log('Cadastro realizado com sucesso:', data);
            
            // Armazena dados do usuário
            if (data.user) {
                sessionStorage.setItem('user_data', JSON.stringify(data.user));
            }
            
            // Atualiza UI e avança para Step 2
            try { await checkUserSubscriptionAndUpdateUI(); } catch (e) { console.warn('Falha ao atualizar UI pós-cadastro:', e); }
            nextStep(2);
            if (typeof updateUIForContext === 'function') { try { updateUIForContext(); } catch(_) {} }
            try { document.dispatchEvent(new CustomEvent('login:success', { detail: { source: 'checkoutnovo', method: 'register', user: data.user || null } })); } catch (e) { console.warn('Falha ao disparar login:success (register)', e); }
            try {
              const usp = new URLSearchParams(window.location.search || '');
              const hasUrlPartial = usp.has('productItemsIds') || (usp.getAll('q[productItemsIds][]') || []).length > 0 || (usp.getAll('productItemsIds[]') || []).length > 0;
              const hasServerPartial = !!(window.serverPartialItems && Array.isArray(window.serverPartialItems) && window.serverPartialItems.length) || !!document.getElementById('server-partial-items');
              if (hasUrlPartial || hasServerPartial) {
                document.dispatchEvent(new CustomEvent('partial:init-request', { detail: { step: 2, context: 'post-register' } }));
              }
            } catch (e) { console.warn('Falha ao disparar partial:init-request (register)', e); }
            try { sessionStorage.setItem('post_auth_refresh_needed', '1'); } catch(_) {}
            try { window.location.reload(); } catch(_) {}
        } else {
            if (data.errors) {
                const firstError = Object.values(data.errors)[0];
                errorDiv.textContent = Array.isArray(firstError) ? firstError[0] : firstError;
            } else {
                errorDiv.textContent = data.message || 'Erro no cadastro. Tente novamente.';
            }
            registerButton.disabled = false;
            registerButton.textContent = 'Cadastrar e continuar';
        }

    } catch (error) {
        console.error('Erro na requisição de cadastro:', error);
        errorDiv.textContent = 'Ocorreu um erro de comunicação. Tente novamente.';
        registerButton.disabled = false;
        registerButton.textContent = 'Cadastrar e continuar';
    }
}


    // Atualiza rótulos/títulos/resumo conforme contexto (Plano/Produto/Parcial)
    function updateUIForContext() {
      try {
        const itemTypeEl = document.getElementById('itemType');
        let itemType = itemTypeEl ? (itemTypeEl.value || 'plan').toLowerCase() : 'plan';

        // Detecta itens parciais via querystring
        const usp = new URLSearchParams(window.location.search || '');
        let productItemIds = [];
        const arr = usp.getAll('q[productItemsIds][]');
        if (arr && arr.length > 0) {
          productItemIds = arr.map(v => String(v).trim()).filter(v => /^\d+$/.test(v)).map(v => parseInt(v, 10));
        } else {
          const flat = usp.get('productItemsIds');
          if (flat) {
            productItemIds = String(flat).split(/[\s,;]+/).map(v => v.trim()).filter(v => /^\d+$/.test(v)).map(v => parseInt(v, 10));
          }
        }
        // Persiste ids se vieram pela URL; se não vieram, NÃO restaura do sessionStorage para evitar sobreposição indevida
        try {
          const hasUrlPartial = Array.isArray(productItemIds) && productItemIds.length > 0;
          if (hasUrlPartial) {
            sessionStorage.setItem('checkout_product_items_ids', JSON.stringify(productItemIds));
          } else {
            try { sessionStorage.removeItem('checkout_product_items_ids'); } catch(_) {}
            productItemIds = [];
          }
        } catch(_) {}
        // Deduplica para evitar itens repetidos
        productItemIds = Array.from(new Set(productItemIds));
        const isParcial = productItemIds.length > 0;
        if (isParcial && itemType === 'plan') itemType = 'product';
        // Alinha o campo oculto para evitar que outras rotinas sobrescrevam o Step 2
        if (isParcial && itemTypeEl) { itemTypeEl.value = 'product'; }

        const stepName2 = document.getElementById('step-name-2');
        if (stepName2) {
          stepName2.textContent = isParcial
            ? t('CheckoutPassoParcial','Parcial')
            : (itemType === 'product' ? t('CheckoutPassoProduto',{{ __('messages.CheckoutPassoProduto') }}) : t({{ __('messages.CheckoutPassoPlano') }}));
        }

        const step2Title = document.getElementById('step-2-title');
        if (step2Title) {
          if (isParcial) {
            step2Title.textContent = t('CheckoutItensSelecionados','{{ __('messages.CheckoutItensSelecionados') }}');
          } else if (itemType === 'product') {
            step2Title.textContent = t('CheckoutEscolhaProduto','{{ __('messages.CheckoutEscolhaProduto') }}');
          } else {
            step2Title.textContent = t('CheckoutEscolhaPlano','{{ __('messages.CheckoutEscolhaPlano') }}');
          }
        }

        if (isParcial) {
          const titleEl = document.getElementById('summary-plan-title');
          const priceEl = document.getElementById('summary-plan-price');
          if (titleEl) titleEl.textContent = `Itens selecionados (${productItemIds.length})`;
          if (priceEl) priceEl.textContent = '';
          // Inicializa a UI da Etapa 2 (Conferência parcial)
          try { initPartialStep(productItemIds); } catch (err) { try { addDebugLog('Falha ao inicializar Etapa 2 parcial: ' + (err && err.message ? err.message : err), 'warn'); } catch(_) {} }
        }
      } catch (e) {
        try {
          addDebugLog('⚠️ updateUIForContext falhou: ' + (e && e.message ? e.message : e), 'warn');
        } catch(err) {
          console.warn('updateUIForContext falhou:', e);
        }
      }
    }

    function updateStepIndicator(currentStep) {
      const totalSteps = 3;
      for (let i = 1; i <= totalSteps; i++) {
        const label = document.getElementById(`step-label-${i}`);
        // Reseta as classes de todos
        label.classList.remove('bg-green-500', 'text-white', 'bg-gray-300', 'text-gray-600');

        if (i === currentStep) {
          // Aplica classes de etapa ativa
          label.classList.add('bg-green-500', 'text-white');
        } else {
          // Aplica classes de etapa inativa
          label.classList.add('bg-gray-300', 'text-gray-600');
        }
      }
    }

    function nextStep(step) {
      // Esconde todas as seções de etapas
      for (let i = 1; i <= 3; i++) {
        document.getElementById(`step-${i}`).classList.add('hidden');
      }
      // Mostra apenas a etapa atual
      document.getElementById(`step-${step}`).classList.remove('hidden');
      
      // Chama a função para atualizar as cores dos indicadores
      updateStepIndicator(step);
      // Quando entrar na etapa 2, atualiza rótulos/títulos conforme contexto e reidrata parcial
      if (step === 2 && typeof updateUIForContext === 'function') { try { updateUIForContext(); } catch(e) { console.warn('updateUIForContext falhou ao entrar na Etapa 2', e); } }
      if (step === 2) { try { 
          const usp = new URLSearchParams(window.location.search || '');
          const hasUrlPartial = usp.has('productItemsIds') || (usp.getAll('q[productItemsIds][]') || []).length > 0 || (usp.getAll('productItemsIds[]') || []).length > 0;
          const hasServerPartial = !!(window.serverPartialItems && Array.isArray(window.serverPartialItems) && window.serverPartialItems.length) || !!document.getElementById('server-partial-items');
          if (hasUrlPartial || hasServerPartial) {
            document.dispatchEvent(new CustomEvent('partial:init-request', { detail: { step: 2, context: 'navigation' } }));
          }
        } catch (e) { console.warn('Falha ao disparar partial:init-request (navigation)', e); } }
    }

    function toggleAuth(isLogin) {
      // Mensagem de contexto
      document.getElementById('auth-msg').textContent = isLogin ?
        '{{ __('messages.Checkoutlogindados') }}' :
        '{{ __('messages.Checkoutcadastrodados') }}';
      var titleEl = document.getElementById('auth-title');
      if (titleEl) titleEl.textContent = isLogin ? '{{ __('messages.Checkoutfacalogin') }}' : '{{ __('messages.Checkoutcrieconta') }}';
      const choice = document.getElementById('auth-choice');
      const controls = document.getElementById('auth-controls');
      const loginForm = document.getElementById('login-form');
      const registerForm = document.getElementById('register-form');
      const section = document.getElementById('auth-section');
      if (section) {
        section.classList.add('auth-section-anim');
        setTimeout(() => section.classList.remove('auth-section-anim'), 320);
      }

      if (choice) {
        choice.classList.add('auth-collapse');
        setTimeout(() => {
          choice.classList.add('hidden');
          // Formularios
          loginForm.classList.toggle('hidden', !isLogin);
          registerForm.classList.toggle('hidden', isLogin);
          // Mostrar controles
          if (controls) controls.classList.remove('hidden');
        }, 200);
      } else {
        // Fallback sem animação
        // Formularios
        loginForm.classList.toggle('hidden', !isLogin);
        registerForm.classList.toggle('hidden', isLogin);
        // Esconder opções se existirem
        if (choice) choice.classList.add('hidden');
        // Mostrar controles
        if (controls) controls.classList.remove('hidden');
      }
    }


    function authBackToChoice() {
      // Efeito no container geral
      var section = document.getElementById('auth-section');
      if (section) {
        section.classList.add('auth-section-anim');
        setTimeout(() => section.classList.remove('auth-section-anim'), 320);
      }
      // Mostrar opções com animação reversa
      var choice = document.getElementById('auth-choice');
      if (choice) {
        choice.classList.remove('hidden');
        // Preparar animação (aparece vindo do scaleX 0.85 para 1)
        choice.classList.add('auth-collapse');
        // Próximo tick remove a classe para animar a expansão
        setTimeout(() => { choice.classList.remove('auth-collapse'); }, 10);
      }
      // Esconder formulários
      document.getElementById('login-form').classList.add('hidden');
      document.getElementById('register-form').classList.add('hidden');
      // Esconder controles (botão voltar)
      var controls = document.getElementById('auth-controls');
      if (controls) controls.classList.add('hidden');
      // Restaurar mensagem padrão
      var msg = document.getElementById('auth-msg');
      if (msg) msg.textContent = '';
      var titleEl = document.getElementById('auth-title');
      if (titleEl) titleEl.textContent = '{{ __('messages.CheckoutTituloOpcao') }}';
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Função para validar CPF
    function isValidCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/\D/g, '');
        
        // Verifica se tem 11 dígitos
        if (cpf.length !== 11) return false;
        
        // Verifica se todos os dígitos são iguais
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        // Validação do primeiro dígito verificador
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let remainder = 11 - (sum % 11);
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;
        
        // Validação do segundo dígito verificador
        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        remainder = 11 - (sum % 11);
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(10))) return false;
        
        return true;
    }

    const cpfInput = document.getElementById('register-cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function (e) {
          var value = e.target.value;
          var cpfPattern = value.replace(/\D/g, '')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1-$2')
            .replace(/(-\d{2})\d+?$/, '$1');
          e.target.value = cpfPattern;
        });
    }



// =======================================================================
// NOVA LÓGICA PARA A ETAPA 2: SELEÇÃO DE PLANO (SEM CHAMADA AO SERVIDOR)
// =======================================================================

// Objeto para guardar os detalhes do plano que o usuário selecionou
let selectedPlan = null;

document.addEventListener('DOMContentLoaded', function() {
    // Adiciona o evento de clique a todos os planos
    document.querySelectorAll('.plan-option').forEach(item => {
        item.addEventListener('click', event => {
            // Remove a borda de seleção de todos os outros
            document.querySelectorAll('.plan-option').forEach(el => {
                el.classList.remove('border-green-500', 'border-2');
            });

            const currentPlanDiv = event.currentTarget;
            currentPlanDiv.classList.add('border-green-500', 'border-2');
            
            // Guarda o objeto completo com os detalhes do plano
            selectedPlan = {
                id: currentPlanDiv.dataset.planId,
                title: currentPlanDiv.querySelector('.plan-title').textContent,
                price: currentPlanDiv.querySelector('.plan-price').textContent
            };
            // Também mantém uma cópia global para cenários em que listeners são reativados
            window.selectedPlan = selectedPlan;
            
            document.getElementById('plan-errors').textContent = '';
        });
    });

    // Auto-seleção inteligente: prioriza o produto da URL quando o tipo for produto
    const plans = document.querySelectorAll('.plan-option');
    let preselected = false;
    const itemTypeEl = document.getElementById('itemType');
    const itemType = itemTypeEl ? (itemTypeEl.value || '').toLowerCase() : '';
    if ((itemType === 'product' || itemType === 'produto') && plans.length > 0) {
        const parts = (window.location.pathname || '').split('/').filter(Boolean);
        const maybeId = parts[parts.length - 1] || '';
        if (/^\d+$/.test(maybeId)) {
            const productId = maybeId;
            const target = Array.from(plans).find(el => (el.dataset.planId || '') === productId);
            if (target) {
                // Não disparar click automático para não avançar de etapa sem consentimento
                const step2El = document.getElementById('step-2');
                if (step2El) {
                    step2El.querySelectorAll('.plan-option').forEach(p => p.classList.remove('border-green-500','border-2','bg-green-50'));
                }
                target.classList.add('border-green-500','border-2','bg-green-50');
                const priceNode = target.querySelector('.plan-price');
                const basePrice = priceNode ? (priceNode.dataset.basePrice || priceNode.textContent) : '';
                window.selectedPlan = {
                  id: target.dataset.planId,
                  title: target.querySelector('.plan-title') ? target.querySelector('.plan-title').textContent : '',
                  price: basePrice
                };
                const planHidden = document.getElementById('plan_id');
                if (planHidden) planHidden.value = window.selectedPlan.id;
                const titleEl = document.getElementById('summary-plan-title');
                const priceEl = document.getElementById('summary-plan-price');
                if (titleEl) titleEl.textContent = window.selectedPlan.title || '';
                if (priceEl) { priceEl.textContent = basePrice || ''; try { priceEl.dataset.basePrice = basePrice || ''; } catch(_){} }
                preselected = true;
            }
        }
    }

    // Fallback: se existir apenas um item, seleciona automaticamente
    if (!preselected && plans.length === 1) {
        plans[0].click();
    }
});

/**
 * Nova função: Apenas avança para a etapa 3 e preenche o resumo.
 */
function selectPlanAndProceed() {
    const errorDiv = document.getElementById('plan-errors');
    
    // 1. Verifica se um plano foi selecionado (usa local ou global como fallback)
    const plan = (typeof selectedPlan !== 'undefined' && selectedPlan) ? selectedPlan : (window.selectedPlan || null);
    if (!plan) {
        errorDiv.textContent = 'Por favor, selecione um plano para continuar.';
        return;
    }

    // 2. Preenche o resumo do pedido na Etapa 3 com os dados guardados
    document.getElementById('summary-plan-title').textContent = plan.title;
    const _priceEl = document.getElementById('summary-plan-price');
    _priceEl.textContent = plan.price;
    try { _priceEl.dataset.basePrice = plan.price; } catch(_){}
    
    // 3. Define o plan_id no formulário de pagamento
    document.getElementById('plan_id').value = plan.id;

    // 4. Aplica desconto visual imediatamente (se necessário)
    setTimeout(function() {
        // Trigger discount application on Step 3
        try {
            if (typeof window.applyOnStep3Product === 'function') {
                window.applyOnStep3Product();
            }
        } catch(e) {}
    }, 10);

    // 5. Avança para a Etapa 3 (Pagamento)
    nextStep(3);
}



document.addEventListener('DOMContentLoaded', function() {
    // Inicializa plan_id (product_id) a partir da URL quando o contexto for produto (inclui casos parciais)
    try {
      const planHidden = document.getElementById('plan_id');
      const itemTypeEl = document.getElementById('itemType');
      const itemType = itemTypeEl ? (itemTypeEl.value || '').toLowerCase() : '';
      if (planHidden && !planHidden.value && (itemType === 'product' || itemType === 'produto')) {
        const parts = (window.location.pathname || '').split('/').filter(Boolean);
        const last = parts[parts.length - 1] || '';
        const prev = parts[parts.length - 2] || '';
        if (/^\d+$/.test(last) && (prev === 'produto' || prev === 'product' || parts.includes('checkoutnovo'))) {
          planHidden.value = last;
        }
      }
    } catch(e) { /* no-op */ }

    // Seletores dos elementos
    const cardNumberInput = document.getElementById('input-card-number');
    const cardHolderInput = document.getElementById('input-card-holder');
    const cardExpiryInput = document.getElementById('input-card-expiry');
    const cardCvvInput = document.getElementById('input-card-cvv');
    
    const cardNumberDisplay = document.querySelector('.card-number-display');
    const cardHolderDisplay = document.querySelector('.card-holder-display');
    const cardExpiryDisplay = document.querySelector('.card-expiry-display');
    const cardCvvDisplay = document.querySelector('.card-cvv-display');
    const cardBrandLogo = document.getElementById('card-brand-logo');
    
    const creditCard = document.querySelector('.credit-card');

    // URLs dos logos das bandeiras - SUBSTITUA PELAS SUAS IMAGENS
    const brandLogos = {
        visa: 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg',
        mastercard: 'https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg',
        amex: 'https://upload.wikimedia.org/wikipedia/commons/f/fa/American_Express_logo_%282018%29.svg',
        elo: 'https://upload.wikimedia.org/wikipedia/commons/d/da/Elo_card_association_logo_-_black_text.svg',
        hipercard: 'https://upload.wikimedia.org/wikipedia/commons/8/89/Hipercard_logo.svg',
        diners: 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Diners_Club_Logo3.svg',
        default: '{{ asset("imagens/cartaobandeira/Logo-dentalgo-branca-ATUALIZAADAAAANOVA.fw.png") }}'
    };

    // --- CÓDIGO ROBUSTO COM VERIFICAÇÕES ---

    // Função para formatar o número do cartão com espaços
    if (cardNumberInput && cardNumberDisplay && cardBrandLogo) {
        cardNumberInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value;
            cardNumberDisplay.textContent = value || '•••• •••• •••• ••••';
            
            const cleanedValue = value.replace(/\s/g, '');
            let brand = 'default';

            if (/^4/.test(cleanedValue)) brand = 'visa';
            else if (/^5[1-5]/.test(cleanedValue)) brand = 'mastercard';
            else if (/^3[47]/.test(cleanedValue)) brand = 'amex';
            else if (/^3(?:0[0-5]|[68]\d)/.test(cleanedValue)) brand = 'diners';
            else if (/^606282/.test(cleanedValue)) brand = 'hipercard';
            else if (/^(4011(78|79)|43(1274|8935)|45(1416|7393|763(1|2))|50(4175|6699|67|90[4-7])|627780|63(6297|6368)|650(03([^4])|04|05|06|07|08|09|1|2|3|4|5|6|7|8|9)|6516|6550)/.test(cleanedValue)) brand = 'elo';
            
            cardBrandLogo.src = brandLogos[brand] || brandLogos.default;
            if (brand !== 'default') {
                cardBrandLogo.classList.add('visible');
            } else {
                cardBrandLogo.classList.remove('visible');
            }
        });
    }

    // Atualiza o nome no cartão
    if (cardHolderInput && cardHolderDisplay) {
        cardHolderInput.addEventListener('input', (e) => {
            cardHolderDisplay.textContent = e.target.value.toUpperCase() || 'SEU NOME';
        });
    }

    // Formata e atualiza a data de validade
    if (cardExpiryInput && cardExpiryDisplay) {
        cardExpiryInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
            cardExpiryDisplay.textContent = value || 'MM/AA';
        });
    }

    // Atualiza o CVV no verso do cartão
    if (cardCvvInput && cardCvvDisplay) {
        cardCvvInput.addEventListener('input', (e) => {
            cardCvvDisplay.textContent = e.target.value;
        });
    }

    // Animação de virar o cartão
    if (cardCvvInput && creditCard) {
        cardCvvInput.addEventListener('focus', () => {
            creditCard.classList.add('flipped');
        });

        cardCvvInput.addEventListener('blur', () => {
            creditCard.classList.remove('flipped');
        });
    }

    // Lógica das abas de pagamento
    const tabs = document.querySelectorAll('.payment-tab');
    const panes = document.querySelectorAll('.payment-tab-pane');
    if (tabs.length > 0 && panes.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('border-green-600', 'text-green-600');
                    t.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });
                panes.forEach(p => p.classList.add('hidden'));

                tab.classList.add('border-green-600', 'text-green-600');
                tab.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                const targetPane = document.getElementById(tab.dataset.target);
                if(targetPane) {
                    targetPane.classList.remove('hidden');
                }
            });
        });
    }
});

 

// =======================================================================
// INTEGRAÇÃO IUGU EXATAMENTE COMO O ORIGINAL
// =======================================================================
// O formulário agora usa o padrão jQuery original da Iugu
// A lógica de tokenização está no script jQuery abaixo

  </script>
  
  <!-- Scripts exatamente como no original -->
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://www.jqueryscript.net/demo/Interactive-Credit-Card-Form-In-jQuery/jquery.card.js"></script>
  <script type="text/javascript" src="https://js.iugu.com/v2"></script>
  <script>
    $('#payment-form').card({
          // a selector or DOM element for the container
          // where you want the card to appear
          container: '.card-wrapper', // *required*

          // all of the other options from above
      });
  </script>

      <script type="text/javascript"> 
      
       (function() {
        const ENABLE_DEBUG_LOGS = true;
        const prefix = '[CHECKOUT]';

        const logger = {
            log: function() { if (!ENABLE_DEBUG_LOGS) return; console.log(prefix, ...arguments); },
            info: function() { if (!ENABLE_DEBUG_LOGS) return; console.info(prefix, ...arguments); },
            warn: function() { if (!ENABLE_DEBUG_LOGS) return; console.warn(prefix, ...arguments); },
            error: function() { if (!ENABLE_DEBUG_LOGS) return; console.error(prefix, ...arguments); },
            group: function(label) { if (!ENABLE_DEBUG_LOGS) return; console.group(prefix + ' ' + label); },
            groupEnd: function() { if (!ENABLE_DEBUG_LOGS) return; console.groupEnd(); },
        };

        window.__checkoutLogger = logger;

        // Erros globais
        window.addEventListener('error', function(e) {
            logger.error('Window error:', {
                message: e.message,
                filename: e.filename,
                lineno: e.lineno,
                colno: e.colno,
                error: e.error
            });
        });

        // Promises rejeitadas sem catch
        window.addEventListener('unhandledrejection', function(e) {
            logger.error('Unhandled promise rejection:', e.reason);
        });
    })();

    $(document).ready(function () {
        const logger = window.__checkoutLogger || console;

        // CSRF global
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
        logger.info('CSRF configurado globalmente', { hasToken: !!csrfToken });

        // Interceptadores globais de AJAX
        $(document).ajaxSend(function (event, jqXHR, settings) {
            logger.group('AJAX SEND');
            logger.info('URL:', settings.url);
            logger.info('Método:', settings.type);
            logger.info('Dados:', settings.data);
            logger.info('CSRF header definido:', !!csrfToken);
            logger.groupEnd();
        });

        $(document).ajaxSuccess(function (event, xhr, settings) {
            logger.group('AJAX SUCCESS');
            logger.info('URL:', settings.url);
            logger.info('Status:', xhr.status);
            try {
                const body = xhr.responseJSON ?? JSON.parse(xhr.responseText || '{}');
                logger.info('Resposta:', body);
            } catch (e) {
                logger.warn('Resposta não JSON. Tamanho do texto:', (xhr.responseText || '').length);
            }
            logger.groupEnd();
        });

        $(document).ajaxError(function (event, xhr, settings, thrownError) {
            logger.group('AJAX ERROR');
            logger.error('URL:', settings.url);
            logger.error('Status:', xhr.status, xhr.statusText);
            logger.error('Erro lançado:', thrownError);
            logger.error('ResponseText:', xhr.responseText);
            logger.groupEnd();
        });

        $(document).ajaxComplete(function (event, xhr, settings) {
            logger.group('AJAX COMPLETE');
            logger.info('URL:', settings.url);
            logger.info('Status:', xhr.status);
            logger.groupEnd();
        });

        // Logs de interação nos campos (com máscara)
        const inputs = [
            '#input-card-number',
            '#input-card-holder',
            '#input-card-expiry',
            '#input-card-cvv',
            '#plan_id'
        ];

        inputs.forEach(function (selector) {
            $(document).on('focus blur change input', selector, function (ev) {
                let val = $(this).val();

                if (selector === '#input-card-number') {
                    const raw = (val || '').replace(/\s/g, '');
                    if (raw.length > 4) {
                        val = raw.replace(/\d(?=\d{4})/g, '•');
                    }
                }
                if (selector === '#input-card-cvv') {
                    val = val ? '***' : val;
                }

                logger.log('Campo', selector, 'evento:', ev.type, 'valor:', val);
            });
        });

        // Clique no botão "Finalizar Pagamento" - LOG DETALHADO
        $(document).on('click', '#payment-submit-btn', function (e) {
            addDebugLog('🖱️ CLIQUE NO BOTÃO FINALIZAR PAGAMENTO', 'info');
            addDebugLog('Button disabled: ' + $(this).prop('disabled'), 'info');
            addDebugLog('Form exists: ' + ($('#payment-form').length > 0), 'info');

            // Fallback: tentar localizar o form pelo ancestral próximo
            if ($('#payment-form').length === 0) {
                const $btn = $(this);
                const $closestForm = $btn.closest('form');
                addDebugLog('Fallback: closest("form") encontrado: ' + ($closestForm.length > 0 ? 'SIM' : 'NÃO'), $closestForm.length > 0 ? 'warning' : 'error');
                
                if ($closestForm.length > 0) {
                    const currentId = $closestForm.attr('id');
                    addDebugLog('Fallback: ID atual do form: ' + (currentId || 'NENHUM'), 'info');
                    
                    if (!currentId || currentId !== 'payment-form') {
                        $closestForm.attr('id', 'payment-form');
                        addDebugLog('Fallback: atribuído id="payment-form" ao form', 'success');
                        
                        // Verificar se a atribuição funcionou
                        const verifyId = $closestForm.attr('id');
                        addDebugLog('Fallback: verificação - ID atual: ' + verifyId, verifyId === 'payment-form' ? 'success' : 'error');
                        
                        // Força uma nova verificação do seletor
                        const formFoundNow = $('#payment-form').length > 0;
                        addDebugLog('Fallback: #payment-form encontrado após atribuição: ' + (formFoundNow ? 'SIM' : 'NÃO'), formFoundNow ? 'success' : 'error');
                    } else {
                        addDebugLog('Fallback: form já possui id="payment-form"', 'info');
                    }
                }
            }
            
            // Verifica se o botão está desabilitado
            if ($(this).prop('disabled')) {
                addDebugLog('AVISO: Botão está desabilitado, clique ignorado', 'warning');
                e.preventDefault();
                return false;
            }

            // Exigir plano selecionado antes de permitir continuar
            var currentPlanId = $('#plan_id').val();
            if (!currentPlanId) {
                addDebugLog('⚠️ Clique bloqueado: Nenhum plano selecionado', 'warning');
                $('#plan-errors').text('Por favor, selecione um plano para continuar.');
                // Voltar para Step-2
                $('.step').addClass('hidden');
                $('#step-2').removeClass('hidden');
                e.preventDefault();
                return false;
            }
            
            // Se ainda não houver form, evita navegação padrão
            if ($('#payment-form').length === 0) {
                addDebugLog('Erro: Form ainda não encontrado após fallback. Cancelando submit padrão.', 'error');
                e.preventDefault();
                return false;
            }

            // Se chegou aqui, há form; garante envio pelo próprio form
            const $formNow = $('#payment-form');
            if ($formNow.length) {
                addDebugLog('✅ Form localizado. Disparando submit do formulário.', 'success');
                // Não impedir o submit neste ponto; o handler delegador do submit cuidará do fluxo
            }
            
            addDebugLog('✓ Clique processado, continuando...', 'success');
        });

        // Tap no submit do formulário (sem interferir na lógica existente)
        const $form = $('#payment-form');
        if ($form.length) {
            $form.on('submit.__logTap', function (e) {
                logger.group('SUBMIT FORM');
                logger.info('Action:', this.action || '/checkout/process-payment');
                logger.info('Method:', (this.method || 'POST').toUpperCase());
                logger.groupEnd();
            });
        }

        logger.info('Sistema de logs inicializado');
    });
      
      </script>

  <script type="text/javascript">
      Iugu.setAccountID("0F1DB94596ED4E4388BFF71A7A1C79AC");
      
      // Aguarda o DOM estar completamente carregado
      // Sistema de Logs Visuais
      var debugMode = true; // Ativar/desativar logs visuais
      
      function addDebugLog(message, type = 'info') {
          if (!debugMode) return;
          
          var timestamp = new Date().toLocaleTimeString();
          var typeClass = {
              'info': 'text-blue-600',
              'success': 'text-green-600', 
              'warning': 'text-yellow-600',
              'error': 'text-red-600'
          }[type] || 'text-gray-600';
          
          var logEntry = '<div class="mb-1 ' + typeClass + '">' +
              '<span class="text-gray-400">[' + timestamp + ']</span> ' +
              '<strong>' + type.toUpperCase() + ':</strong> ' + message +
              '</div>';
          
          var logsContainer = $('#debug-logs-content');
          if (logsContainer.length > 0) {
              if (logsContainer.find('.text-gray-500').length > 0) {
                  logsContainer.empty(); // Remove mensagem inicial
              }
              
              logsContainer.append(logEntry);
              logsContainer.scrollTop(logsContainer[0].scrollHeight);
              
              // Mostra o painel de logs se estiver oculto
              $('#debug-logs').show();
          }
          
          // Log também no console
          console.log('[' + timestamp + '] ' + type.toUpperCase() + ': ' + message);
      }
      
      function clearDebugLogs() {
          $('#debug-logs-content').html('<div class="text-gray-500 text-center">Logs aparecerão aqui...</div>');
      }
      
      function toggleDebugLogs() {
          $('#debug-logs-content').toggle();
      }
      
      $(document).ready(function() {
        addDebugLog('Sistema de checkout inicializado', 'success');
        addDebugLog('jQuery version: ' + $.fn.jquery, 'info');
        addDebugLog('Document ready state: ' + document.readyState, 'info');
        
        var formExists = $('#payment-form').length > 0;
        var buttonExists = $('#payment-submit-btn').length > 0;
        
        addDebugLog('Payment form exists: ' + (formExists ? 'SIM' : 'NÃO'), formExists ? 'success' : 'error');
        addDebugLog('Payment button exists: ' + (buttonExists ? 'SIM' : 'NÃO'), buttonExists ? 'success' : 'error');
        
        // Verificar visibilidade das abas de pagamento
        var creditCardContent = $('#credit-card-content');
        var isVisible = creditCardContent.is(':visible');
        var hasHiddenClass = creditCardContent.hasClass('hidden');
        var displayStyle = creditCardContent.css('display');
        
        addDebugLog('Credit card content exists: ' + (creditCardContent.length > 0 ? 'SIM' : 'NÃO'), creditCardContent.length > 0 ? 'success' : 'error');
        addDebugLog('Credit card content visible: ' + (isVisible ? 'SIM' : 'NÃO'), isVisible ? 'success' : 'warning');
        addDebugLog('Has hidden class: ' + (hasHiddenClass ? 'SIM' : 'NÃO'), hasHiddenClass ? 'warning' : 'success');
        addDebugLog('Display style: ' + displayStyle, displayStyle === 'none' ? 'warning' : 'success');
        
        // Verificar se está na etapa de pagamento
        var step3 = $('#step-3');
        var step3Visible = step3.is(':visible');
        var step3HasHidden = step3.hasClass('hidden');
        
        addDebugLog('Step-3 exists: ' + (step3.length > 0 ? 'SIM' : 'NÃO'), step3.length > 0 ? 'success' : 'error');
        addDebugLog('Step-3 visible: ' + (step3Visible ? 'SIM' : 'NÃO'), step3Visible ? 'success' : 'warning');
        addDebugLog('Step-3 has hidden class: ' + (step3HasHidden ? 'SIM' : 'NÃO'), step3HasHidden ? 'warning' : 'success');
        
        // Verificar todas as etapas do checkout
        var step1 = $('#step-1');
        var step2 = $('#step-2');
        
        addDebugLog('Step-1 visible: ' + (step1.is(':visible') ? 'SIM' : 'NÃO'), step1.is(':visible') ? 'info' : 'success');
        addDebugLog('Step-2 visible: ' + (step2.is(':visible') ? 'SIM' : 'NÃO'), step2.is(':visible') ? 'info' : 'success');
        
        // Verificar se há plano selecionado antes de navegar automaticamente
        var planSelected = $('#plan_id').val();
        addDebugLog('Plan ID atual: ' + (planSelected ? planSelected : 'VAZIO'), planSelected ? 'success' : 'warning');

        // Controlar avanço automático apenas quando explicitamente desejado
        var initialStepBlade = parseInt('{{ $initialStep ?? 1 }}', 10);
        var urlParams = new URLSearchParams(window.location.search);
        var autoProceed = urlParams.get('autoProceed') === '1';

        if ((!step3Visible || step3HasHidden) && planSelected && (initialStepBlade === 3 || autoProceed)) {
            addDebugLog('Avanço automático habilitado (initialStep==3 ou autoProceed=1) - indo para pagamento...', 'warning');

            // Esconder todas as etapas
            $('.step').addClass('hidden');
            // Mostrar apenas step-3
            $('#step-3').removeClass('hidden');

            addDebugLog('✅ Navegação forçada para step-3 concluída', 'success');

            // Verificar novamente se o formulário está visível agora
            setTimeout(function() {
                var formExistsNow = $('#payment-form').length > 0;
                var formVisibleNow = $('#payment-form').is(':visible');
                addDebugLog('Após navegação - Form exists: ' + (formExistsNow ? 'SIM' : 'NÃO'), formExistsNow ? 'success' : 'error');
                addDebugLog('Após navegação - Form visible: ' + (formVisibleNow ? 'SIM' : 'NÃO'), formVisibleNow ? 'success' : 'error');
            }, 100);
        } else {
            addDebugLog('Mantendo usuário na etapa atual (respeitando backend). Avanço automático desabilitado.', 'info');
            // Respeita a etapa inicial definida pelo backend e não força Step-2 para usuários não logados
            if (!step3Visible || step3HasHidden) {
                $('.step').addClass('hidden');
                if (initialStepBlade === 1) {
                    $('#step-1').removeClass('hidden');
                } else {
                    $('#step-2').removeClass('hidden');
                }
            }
        }
        
        if (formExists) {
            addDebugLog('Form action: ' + $('#payment-form').attr('action'), 'info');
            addDebugLog('Form method: ' + $('#payment-form').attr('method'), 'info');
        }
        
        var csrfExists = $('meta[name="csrf-token"]').length > 0;
        addDebugLog('CSRF token exists: ' + (csrfExists ? 'SIM' : 'NÃO'), csrfExists ? 'success' : 'error');
        
        // Verifica se todos os campos necessários existem
        var requiredFields = ['#input-card-number', '#input-card-holder', '#input-card-expiry', '#input-card-cvv', '#plan_id', '#token'];
        addDebugLog('Verificando campos obrigatórios...', 'info');
        
        var missingFields = [];
        requiredFields.forEach(function(field) {
            var exists = $(field).length > 0;
            if (!exists) {
                missingFields.push(field);
            }
            addDebugLog('Campo ' + field + ': ' + (exists ? 'EXISTE' : 'NÃO EXISTE'), exists ? 'success' : 'error');
        });
        
        if (missingFields.length > 0) {
            addDebugLog('ATENÇÃO: ' + missingFields.length + ' campos obrigatórios não encontrados!', 'error');
        } else {
            addDebugLog('Todos os campos obrigatórios encontrados!', 'success');
        }
        
        // Verifica se o Iugu está carregado
        var iuguAvailable = typeof Iugu !== 'undefined';
        addDebugLog('Iugu disponível: ' + (iuguAvailable ? 'SIM' : 'NÃO'), iuguAvailable ? 'success' : 'error');
        
        if (iuguAvailable) {
            var tokenFunctionAvailable = typeof Iugu.createPaymentToken === 'function';
            addDebugLog('Iugu.createPaymentToken disponível: ' + (tokenFunctionAvailable ? 'SIM' : 'NÃO'), tokenFunctionAvailable ? 'success' : 'error');
        }
        
        // ===== Utilitários de UI do botão e overlay de resultado =====
        function setProcessingState(isProcessing) {
            var $btn = $('#payment-submit-btn');
            var $btnText = $('#btn-text');
            var $spinner = $('#loading-spinner');
            if ($btn.length === 0) return;
            if (isProcessing) {
                $btn.prop('disabled', true)
                    .removeClass('bg-green-600 hover:bg-green-700')
                    .addClass('bg-blue-600 hover:bg-blue-700');
                $btnText.text('{{ __('messages.CheckoutProcessandoPagamento') }}');
                $spinner.removeClass('hidden');
            } else {
                $btn.prop('disabled', false)
                    .removeClass('bg-blue-600 hover:bg-blue-700')
                    .addClass('bg-green-600 hover:bg-green-700');
                $btnText.text('Finalizar Pagamento');
                $spinner.addClass('hidden');
            }
        }
        
        var paymentRedirectTimer = null;
        function hidePaymentResult() {
            if (paymentRedirectTimer) {
                clearTimeout(paymentRedirectTimer);
                paymentRedirectTimer = null;
            }
            $('#payment-result-overlay').addClass('hidden');
        }
        
        function showPaymentResult(success, message) {
            var $overlay = $('#payment-result-overlay');
            var $icon = $('#payment-result-icon');
            var $title = $('#payment-result-title');
            var $msg = $('#payment-result-message');
            var $primary = $('#payment-result-primary');
            var $secondary = $('#payment-result-secondary');
            
            if (success) {
                $icon.html('<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>');
                $title.text('Pagamento aprovado!');
                var baseMsg = message || 'Sua assinatura foi ativada com sucesso.';
                $msg.text(baseMsg + ' Você será redirecionado para a página inicial em instantes.');
                $primary.text('Ir para Home agora').attr('href', '/').off('click');
            } else {
                $icon.html('<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>');
                $title.text('{{ __('messages.Checkoutnaoaprovado') }}');
                $msg.text(message || 'Não foi possível processar seu pagamento. Tente novamente.');
                $primary.text('{{ __('messages.SignBladeTry') }}').attr('href', '#').off('click').on('click', function(e){ e.preventDefault(); if (paymentRedirectTimer) { clearTimeout(paymentRedirectTimer); paymentRedirectTimer = null; } window.location.reload(); });
            }
            
            if (success) {
                $secondary.off('click').on('click', function(){ hidePaymentResult(); });
            } else {
                $secondary.off('click').on('click', function(){ if (paymentRedirectTimer) { clearTimeout(paymentRedirectTimer); paymentRedirectTimer = null; } window.location.reload(); });
            }
            $overlay.removeClass('hidden');
             
            if (success) {
                if (paymentRedirectTimer) {
                    clearTimeout(paymentRedirectTimer);
                }
                paymentRedirectTimer = setTimeout(function(){
                    window.location.href = '/';
                }, 3000);
            }
        }
        
        // ===== Humanização de mensagens =====
        function humanizeIuguErrors(errors) {
            try {
                var msgs = [];
                if (!errors || typeof errors !== 'object') {
                    return 'Não foi possível validar os dados do cartão. Verifique as informações e tente novamente.';
                }
                var getCode = function(v){
                    if (!v) return '';
                    if (Array.isArray(v)) return (v[0] || '').toString();
                    if (typeof v === 'string') return v;
                    if (typeof v === 'object') return (v.message || v.code || '').toString();
                    return v.toString();
                };
                // Número do cartão
                if (errors.number) {
                    var c = getCode(errors.number).toLowerCase();
                    if (c.includes('invalid')) msgs.push('Número do cartão é inválido. Verifique os números e tente novamente.');
                    else msgs.push('Número do cartão inválido.');
                }
                // CVV
                if (errors.verification_value || errors.cvv) {
                    var cvvErr = getCode(errors.verification_value || errors.cvv).toLowerCase();
                    if (cvvErr.includes('required')) msgs.push('Informe o código de segurança (CVV) do cartão.');
                    else msgs.push('Código de segurança (CVV) inválido. Verifique e tente novamente.');
                }
                // Validade
                if (errors.expiration || errors.expiry || errors.month || errors.year) {
                    var expErr = getCode(errors.expiration || errors.expiry || errors.month || errors.year).toLowerCase();
                    if (expErr.includes('past') || expErr.includes('expired')) msgs.push('Seu cartão está expirado. Use outro cartão.');
                    else msgs.push('Data de validade do cartão é inválida. Verifique mês e ano.');
                }
                // Titular
                if (errors.holder_name || errors.name) {
                    var nameErr = getCode(errors.holder_name || errors.name).toLowerCase();
                    if (nameErr.includes('required')) msgs.push('Informe o nome do titular do cartão.');
                    else msgs.push('Nome do titular do cartão inválido. Digite como está no cartão.');
                }
                // Outros campos comuns
                if (errors.brand) msgs.push('Bandeira do cartão não reconhecida. Tente outro cartão.');
                if (errors.address) msgs.push('Endereço do cartão incompleto ou inválido.');
                if (errors.country) msgs.push('País do cartão inválido.');
                
                if (msgs.length === 0) {
                    return 'Alguns dados do cartão parecem inválidos. Revise as informações e tente novamente.';
                }
                return msgs.join(' ');
            } catch (e) {
                return 'Não foi possível validar os dados do cartão. Verifique as informações e tente novamente.';
            }
        }
        
        function humanizeBackendError(xhr, rawMsg) {
            try {
                var status = xhr && xhr.status ? xhr.status : 0;
                var payload = (xhr && xhr.responseJSON) ? xhr.responseJSON : {};
                var msg = (rawMsg || payload.message || payload.error || '').toString();
                var low = msg.toLowerCase();
                
                if (status === 401 || low.includes('unauthorized')) {
                    return 'Sua sessão expirou. Faça login novamente e tente finalizar a compra.';
                }
                if (status === 402 || low.includes('purchasepaymenterror') || low.includes('payment')) {
                    return '{{ __('messages.Checkoutnaoaprovadoverifique') }}';
                }
                if (low.includes('planrequired')) {
                    return 'Selecione um plano antes de finalizar a compra.';
                }
                if (low.includes('subscriptionexpired')) {
                    return 'Sua assinatura expirou. Faça uma nova assinatura para continuar.';
                }
                if (low.includes('verificação do status do pagamento')) {
                    return 'Pagamento aprovado, mas ainda estamos confirmando sua assinatura. Atualize a página em instantes ou acesse Minha Conta.';
                }
                if (low.includes('iugu') && low.includes('token')) {
                    return 'Não foi possível validar o cartão. Gere o token novamente e tente outra vez.';
                }
                if (low.includes('coupon') || low.includes('cupom')) {
                    return 'Cupom inválido ou expirado. Verifique as regras do cupom e tente novamente.';
                }
                if (msg) return msg;
                return 'Não foi possível processar seu pagamento no momento. Verifique os dados e tente novamente.';
            } catch (e) {
                return 'Não foi possível processar seu pagamento no momento. Tente novamente em alguns instantes.';
            }
        }
        // ===== Fim utilitários =====
        
        $(document).on('submit', '#payment-form', function(evt) {
            evt.preventDefault();
            
            addDebugLog('🚀 INICIANDO PROCESSO DE PAGAMENTO', 'info');
            
            // Validação básica dos campos
            var cardNumber = $('#input-card-number').val().replace(/\s/g, '');
            var cardHolder = $('#input-card-holder').val();
            var cardExpiry = $('#input-card-expiry').val();
            var cardCvv = $('#input-card-cvv').val();
            var planId = $('#plan_id').val();
            var itemType = ($('#itemType').val() || 'plan').toLowerCase();
            addDebugLog('📦 Contexto do checkout -> itemType: ' + itemType + ', planId: ' + planId, 'info');
            
            if (!cardNumber || cardNumber.length < 13) {
                showPaymentResult(false, (typeof t==='function'? t('CheckoutErroNumCartaoInvalido','Número do Cartão é inválido. Verifique os números e tente novamente.') : 'Número do Cartão é inválido. Verifique os números e tente novamente.'));
                return false;
            }
            
            if (!cardHolder || cardHolder.trim().length < 2) {
                showPaymentResult(false, (typeof t==='function'? t('CheckoutErroNomeCartaoObrigatorio','Informe o Nome do Titular do Cartão.') : 'Informe o Nome do Titular do Cartão.'));
                return false;
            }
            
            if (!cardExpiry || cardExpiry.length < 5) {
                showPaymentResult(false, (typeof t==='function'? t('CheckoutErroValidadeInvalida','Validade do Cartão inválida. Revise o mês e o ano informados.') : 'Validade do Cartão inválida. Revise o mês e o ano informados.'));
                return false;
            }
            
            if (!cardCvv || cardCvv.length < 3) {
                showPaymentResult(false, (typeof t==='function'? t('CheckoutErroCvvInvalido','Código de Segurança (CVV) inválido. Confira os dígitos do verso do cartão.') : 'Código de Segurança (CVV) inválido. Confira os dígitos do verso do cartão.'));
                return false;
            }
            
            // Exigir plano apenas quando itemType for assinatura
            if (itemType === 'plan' && !planId) {
                showPaymentResult(false, (typeof t==='function'? t('CheckoutErroSelecionePlano','Selecione um Plano de Assinatura.') : 'Selecione um Plano de Assinatura.'));
                return false;
            }
            
            addDebugLog('✅ Todos os campos validados com sucesso', 'success');
            addDebugLog('🔄 Criando token de pagamento...', 'info');
            
            // Atualiza estado do botão para processando
            setProcessingState(true);
            
            var form = this;
            var tokenResponseHandler = function(data) {
                if (data.errors) {
                    addDebugLog('❌ ERRO na tokenização: ' + JSON.stringify(data.errors), 'error');
                    setProcessingState(false);
                    var tokenErrorMsg = humanizeIuguErrors(data.errors);
                    showPaymentResult(false, tokenErrorMsg);
                } else {
                    addDebugLog('✅ Token criado com sucesso: ' + data.id, 'success');
                    $("#token").val(data.id);
                    addDebugLog('📤 Preparando payload para backend...', 'info');

                    var postData = {
                        token: data.id,
                        itemType: (($("#itemType").val() || 'plan') + '').toLowerCase(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };
                    var planIdVal = $('input[name="plan_id"]').val();
                    if (planIdVal) { postData.plan_id = planIdVal; }

                    // product_id: prioriza campo oculto específico; fallback para planId quando itemType=product
                    var productIdHidden = $('input[name="product_id"]').val();
                    if (productIdHidden) {
                        postData.product_id = productIdHidden;
                    } else if (postData.itemType === 'product' && planIdVal) {
                        postData.product_id = planIdVal;
                    }

                    // Captura venda parcial priorizando estado salvo (quantidades/remoções da Etapa 2)
                    try {
                        var stateRaw = null, state = null;
                        try { stateRaw = sessionStorage.getItem('checkout_partial_state'); } catch(err) { stateRaw = null; }
                        if (stateRaw) {
                            try { state = JSON.parse(stateRaw); } catch(err) { state = null; }
                        }

                        let productItemIds = [];
                        if (state && Array.isArray(state.items)) {
                            state.items.forEach(function(it){
                                if (!it || !it.available || !it.qty || it.qty <= 0) return;
                                var id = parseInt(it.itemId, 10);
                                if (!Number.isFinite(id)) return;
                                for (var i = 0; i < it.qty; i++) { productItemIds.push(id); }
                            });
                            if (Number.isFinite(state.totalCents)) { postData.orderTotal = state.totalCents; }
                            if (Number.isFinite(state.productId)) { if (!postData.product_id) postData.product_id = state.productId; }
                            addDebugLog('🧩 Itens parciais do estado (sessionStorage) considerados: ' + JSON.stringify(productItemIds), 'info');
                        }

                        // Fallback: se não houver estado válido, usa querystring
                        if (!productItemIds.length) {
                            const usp = new URLSearchParams(window.location.search || '');
                            const arr = usp.getAll('q[productItemsIds][]');
                            if (arr && arr.length > 0) {
                                productItemIds = arr.map(v => String(v).trim()).filter(v => /^\d+$/.test(v)).map(v => parseInt(v, 10));
                            } else {
                                const flat = usp.get('productItemsIds');
                                if (flat) {
                                    productItemIds = String(flat).split(/[\s,;]+/).map(v => v.trim()).filter(v => /^\d+$/.test(v)).map(v => parseInt(v, 10));
                                }
                            }
                            if (productItemIds.length) {
                                addDebugLog('🧩 Detectados productItemsIds no query: ' + JSON.stringify(productItemIds), 'info');
                            }
                        }

                        if (productItemIds.length > 0) {
                            postData.productItemsIds = productItemIds;
                            if (!postData.itemType || postData.itemType === 'plan') { postData.itemType = 'product'; }
                        }
                    } catch (e) {
                        addDebugLog('⚠️ Erro ao processar productItemsIds: ' + (e && e.message ? e.message : e), 'warn');
                    }

                    // Desconto para PRODUTO COMPLETO (não parcial), no mesmo modelo do parcial
                    try {
                        var hasActiveSubscription = @json(isset($subscriptionStatus) && $subscriptionStatus === 'active');
                        var subscriberDiscountPercentBps = @json($subscriberPurchaseDiscountPercent ?? 0);
                        var isPartialFlow = Array.isArray(postData.productItemsIds) && postData.productItemsIds.length > 0;
                        if (!isPartialFlow && (postData.itemType === 'product' || postData.itemType === 'produto')) {
                            // Obtém o preço base a partir do resumo exibido na Etapa 3
                            var priceTextEl = document.getElementById('summary-plan-price');
                            var priceText = priceTextEl ? (((priceTextEl.dataset||{}).basePrice) || (priceTextEl.textContent || '')) : '';
                            var baseCents = (function(txt){
                                try {
                                    // Remove caracteres não numéricos exceto vírgula e ponto
                                    txt = (txt || '').toString();
                                    // Remove R$, espaços e outros símbolos
                                    txt = txt.replace(/[^0-9,\.]/g, '');
                                    if (!txt) return NaN;
                                    var parts = txt.split(',');
                                    var intPart = parts[0].replace(/\./g, '');
                                    var decPart = (parts[1] || '00').padEnd(2,'0').slice(0,2);
                                    var cents = parseInt(intPart, 10) * 100 + parseInt(decPart, 10);
                                    return Number.isFinite(cents) ? cents : NaN;
                                } catch(_){ return NaN; }
                            })(priceText);
                            
                            if (Number.isFinite(baseCents) && baseCents > 0) {
                                var discountedCents = baseCents;
                                if (hasActiveSubscription && Number.isFinite(subscriberDiscountPercentBps) && subscriberDiscountPercentBps > 0) {
                                    // subscriberDiscountPercentBps em basis points de percent (ex.: 500 = 5%)
                                    discountedCents = Math.round(baseCents * (10000 - subscriberDiscountPercentBps) / 10000);
                                    addDebugLog('🏷️ Desconto de assinante aplicado em produto completo: ' + (subscriberDiscountPercentBps/100) + '%. De ' + baseCents + ' para ' + discountedCents + ' centavos.', 'info');
                                } else {
                                    addDebugLog('ℹ️ Sem desconto de assinante aplicável para produto completo. Total permanece: ' + baseCents + ' centavos.', 'info');
                                }
                                // Define o total final a ser enviado ao backend
                                postData.orderTotal = discountedCents;
                            } else {
                                addDebugLog('⚠️ Não foi possível interpretar o preço do produto completo para aplicar desconto.', 'warn');
                            }
                        }
                    } catch (e) {
                        addDebugLog('⚠️ Erro ao calcular desconto de produto completo: ' + (e && e.message ? e.message : e), 'warn');
                    }

                    addDebugLog('📦 Payload a ser enviado: ' + JSON.stringify(postData), 'info');
                    addDebugLog('📤 Enviando pagamento via AJAX POST...', 'info');
                    
                    // Envia via AJAX POST para o controller
                    $.ajax({
                        url: '{{ route("checkoutnovo.processPayment") }}',
                        method: 'POST',
                        data: postData,
                        success: function(response) {
                            addDebugLog('✅ Pagamento processado com sucesso!', 'success');
                            setProcessingState(false);
                            var successMsg = (response && (response.message || response.msg)) ? (response.message || response.msg) : 'Pagamento realizado com sucesso!';
                            showPaymentResult(true, successMsg);
                        },
                        error: function(xhr) {
                            var rawMsg = 'Erro no pagamento';
                            if (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) {
                                rawMsg = xhr.responseJSON.message || xhr.responseJSON.error;
                            } else if (xhr.responseText) {
                                rawMsg = xhr.responseText;
                            }
                            var errorMsg = humanizeBackendError(xhr, rawMsg);
                            addDebugLog('❌ Erro no pagamento (humanizado): ' + errorMsg, 'error');
                            setProcessingState(false);
                            showPaymentResult(false, errorMsg);
                        }
                    });
                }
            };
            
            try {
                if (typeof Iugu === 'undefined') {
                    throw new Error('Iugu não está carregado');
                }
                
                Iugu.createPaymentToken(form, tokenResponseHandler);
                addDebugLog('✅ Iugu.createPaymentToken chamado com sucesso', 'success');
            } catch (error) {
                addDebugLog('❌ ERRO AO CHAMAR IUGU: ' + error.message, 'error');
                setProcessingState(false);
                showPaymentResult(false, (typeof t==='function'? t('CheckoutErroIntegracaoPagamento','Erro na integração de pagamento. Tente novamente.') : 'Erro na integração de pagamento. Tente novamente.'));
            }
            
            return false;
        });
      });
  </script>
  <!-- Overlay de Resultado do Pagamento -->
  <div id="payment-result-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="min-h-screen flex items-center justify-center p-4">
      <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 text-center">
        <div id="payment-result-icon" class="mx-auto mb-4">
          <!-- Ícone será inserido via JS -->
        </div>
        <h2 id="payment-result-title" class="text-2xl font-bold mb-2">{{ __('messages.CheckoutStatusPagamento') }}</h2>
        <p id="payment-result-message" class="text-gray-700 mb-6">{{ __('messages.CheckoutAguarde') }}</p>
        <div class="space-y-2">
          <a id="payment-result-primary" href="/minhaconta" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded font-semibold">{{ __('messages.CheckoutIrMinhaConta') }}</a>
          <button id="payment-result-secondary" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded font-semibold">{{ __('messages.CheckoutFechar') }}</button>
        </div>
      </div>
    </div>
  </div>

<script>
(function(){
  function formatCurrencyPairsInStep3(){
    try {
      var container = document.querySelector('#step-3');
      if(!container) return;
      var regexPair = /R\$\s*\d{1,3}(?:\.\d{3})*,\d{2}\s*R\$\s*\d{1,3}(?:\.\d{3})*,\d{2}/;
      var regexSingle = /R\$\s*\d{1,3}(?:\.\d{3})*,\d{2}/g;
      var walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, {
        acceptNode: function(node){
          var txt = (node.nodeValue || '').trim();
          if(!txt) return NodeFilter.FILTER_REJECT;
          return regexPair.test(txt) ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
        }
      });
      var nodes = [];
      while(walker.nextNode()) nodes.push(walker.currentNode);
      nodes.forEach(function(textNode){
        var txt = textNode.nodeValue || '';
        var matches = txt.match(regexSingle);
        if(!matches || matches.length < 2) return;
        var first = matches[0];
        var second = matches[1];
        var wrapper = document.createElement('span');
        wrapper.setAttribute('data-price-formatted','true');
        wrapper.innerHTML = '<s style="text-decoration:line-through; text-decoration-thickness:1.5px; color:#6b7280; margin-right:6px; display:inline-block;">'+ first +'</s>'+
                            '<span aria-hidden="true" style="display:inline-block; width:6px;"></span>'+
                            '<span style="font-weight:700; color:#111827;">'+ second +'</span>';
        if(textNode.parentNode){
          textNode.parentNode.replaceChild(wrapper, textNode);
        }
      });
    } catch(e) { /* silencioso */ }
  }
  document.addEventListener('DOMContentLoaded', function(){ setTimeout(formatCurrencyPairsInStep3, 300); });
  window.addEventListener('load', function(){ setTimeout(formatCurrencyPairsInStep3, 600); });
  window.applyDiscountFormattingInStep3 = formatCurrencyPairsInStep3;
})();
</script>

<!-- Toggle de visibilidade de senha (reutilizável) -->
<script>
(function(){
  function togglePasswordVisibility(inputOrId, btn){
    try {
      var input = null;
      if (typeof inputOrId === 'string') {
        input = document.getElementById(inputOrId);
      } else if (inputOrId && inputOrId.nodeType === 1) {
        input = inputOrId;
      }
      if (!input) return;

      // Ícones SVG simples (olho e olho cortado)
      var ICON_EYE = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-7 11-7c2.7 0 5.1.9 7 2.3"/><path d="M23 12s-4 7-11 7c-2.7 0-5.1-.9-7-2.3"/><path d="M1 1l22 22"/><path d="M9.5 9.5a3 3 0 004.2 4.2"/></svg>';
      var ICON_EYE_OFF = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    

      var wasText = input.type === 'text';
      input.type = wasText ? 'password' : 'text';
      if (btn) {
        var isNowText = input.type === 'text';
        btn.setAttribute('aria-pressed', String(isNowText));
        btn.title = isNowText ? 'Ocultar senha' : 'Mostrar senha';
        btn.setAttribute('aria-label', btn.title);
        try { btn.innerHTML = isNowText ? ICON_EYE_OFF : ICON_EYE; } catch(e){}
      }
    } catch(e) { /* silencioso */ }
  }
  window.togglePasswordVisibility = togglePasswordVisibility;
})();
</script>

<script>
// ===== Etapa 2 (Conferência Parcial) - Estado e Funções =====
window.partialCheckoutState = { productId: null, items: [], totalCents: 0, valid: false };

function formatBRLFromCents(cents) {
    try {
        return (Number(cents || 0) / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    } catch (e) {
        return 'R$ 0,00';
    }
}

function initPartialStep(productItemIds) {
    try {
        // Deriva productId do path
        var m = (location.pathname || '').match(/\/checkoutnovo\/(?:produto|product)\/(\d+)/i);
        window.partialCheckoutState.productId = m ? parseInt(m[1], 10) : null;
        
        // Consolida quantidades
        var counts = {};
        (Array.isArray(productItemIds) ? productItemIds : []).forEach(function(id) {
            var n = parseInt(id, 10);
            if (!Number.isFinite(n)) return;
            counts[n] = (counts[n] || 0) + 1;
        });
        
        // Indexa detalhes providos pelo backend
        var details = Array.isArray(window.serverPartialItems) ? window.serverPartialItems : [];
        var byId = {};
        details.forEach(function(it) {
            var id = parseInt(it.id || it.itemId || it.productItemId, 10);
            if (Number.isFinite(id)) byId[id] = it;
        });
        
        // Monta itens do estado
        window.partialCheckoutState.items = Object.keys(counts).map(function(k) {
            var id = parseInt(k, 10), qty = counts[k] || 0;
            var d = byId[id] || {};
            var title = d.title || d.name || 'Item';
            var cover = d.cover || d.thumbnail || null;
            var priceCents = parseInt((d.priceCents != null ? d.priceCents : d.price), 10) || 0;
            var available = (typeof d.available === 'boolean') ? d.available : (typeof d.status === 'boolean' ? d.status : true);
            return { itemId: id, title: title, cover: cover, priceCents: priceCents, qty: qty, available: available, subtotalCents: 0 };
        });
        
        recalcPartialTotals();
        renderPartialStep();
        
        try {
            if (typeof addDebugLog === 'function') {
                addDebugLog('Etapa 2 parcial iniciada. Itens: ' + JSON.stringify(window.partialCheckoutState.items), 'info');
            }
        } catch (_) {}
    } catch (e) {
        try {
            if (typeof addDebugLog === 'function') {
                addDebugLog('Falha em initPartialStep: ' + (e && e.message ? e.message : e), 'warn');
            }
        } catch (_) {}
    }
}

function recalcPartialTotals() {
    var total = 0;
    window.partialCheckoutState.items.forEach(function(it) {
        if (it.available && it.qty > 0) {
            it.subtotalCents = (it.priceCents || 0) * it.qty;
            total += it.subtotalCents;
        } else {
            it.subtotalCents = 0;
        }
    });
    window.partialCheckoutState.totalCents = total;
    window.partialCheckoutState.valid = window.partialCheckoutState.items.some(function(it) {
        return it.available && it.qty > 0;
    });
}

// i18n helper (defensivo): usa window.messages se disponível
function t(key, fallback) {
    try {
        var v = (window.messages && window.messages[key]) || '';
        if (!v || /^messages\./.test(v)) return fallback;
        return v;
    } catch (_) { return fallback; }
}

function renderPartialStep() {
    var step2 = document.getElementById('step-2');
    if (!step2) return;
    
    var itemsHtml = window.partialCheckoutState.items.map(function(it, idx) {
        return '<div class="flex items-start gap-3 py-3 border-b border-gray-200 last:border-b-0" data-idx="' + idx + '">' +
               (it.cover ? '<img src="' + it.cover + '" alt="' + (it.title || t('CheckoutItemLabel','Item')) + '" class="w-16 h-16 object-cover rounded" />' : '') +
               '<div class="flex-1">' +
               '<div class="font-medium text-gray-800">' + (it.title || t('CheckoutItemLabel','Item')) + (!it.available ? '<span class="ml-2 text-xs px-2 py-0.5 rounded bg-red-100 text-red-700 align-middle">' + t('CheckoutIndisponivel','Indisponível') + '</span>' : '') + '</div>' +
               '<div class="text-sm text-gray-600">' + t('CheckoutPrecoUnitario','{{ __('messages.CheckoutPrecoUnitario') }}') + ' ' + formatBRLFromCents(it.priceCents) + '</div>' +
               '<div class="flex items-center gap-2 mt-2">' +
               '<label class="text-sm text-gray-700">' + t('CheckoutQuantidadeLabel','Qtd.') + '</label>' +
               '<input type="number" min="0" value="' + it.qty + '" ' + (!it.available ? 'disabled' : '') + ' class="qty-input w-20 p-2 border rounded" />' +
               '<button type="button" class="remove-item px-2 py-1 text-sm text-red-600 hover:text-red-800">' + t('CheckoutRemoverItem','{{ __('messages.CheckoutRemoverItem') }}') + '</button>' +
               '<div class="ml-auto font-semibold">' + t('CheckoutSubtotal','{{ __('messages.CheckoutSubtotal') }}') + ' <span class="item-subtotal">' + formatBRLFromCents(it.subtotalCents) + '</span></div>' +
               '</div>' +
               '</div>' +
               '</div>';
    }).join('');
    
    var emptyState = (!window.partialCheckoutState.items.length) ? '<div class="p-4 rounded bg-gray-50 text-gray-700">' + t('CheckoutNenhumItem','Nenhum item selecionado. Volte e selecione os itens desejados.') + '</div>' : '';
    var warning = window.partialCheckoutState.items.some(function(it) { return !it.available; }) ? '<div class="mt-2 text-sm text-yellow-700 bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-r">' + t('CheckoutItensIndisponiveis','Alguns itens estão indisponíveis e foram desconsiderados no total.') + '</div>' : '';
    
    var baseTotal = Number(window.partialCheckoutState.totalCents || 0);
    var pctInt = Number(window.subscriberPurchaseDiscountPercent || 0);
    var applyDisc = (window.subscriptionStatus === 'active') && pctInt > 0;
    var disc = applyDisc ? Math.round((baseTotal * pctInt) / 10000) : 0;
    var finalTotal = baseTotal - disc;
    var discountBannerHtml = applyDisc ? '<div id="partial-discount-banner" class="mt-2 text-sm text-green-700 bg-green-50 border-l-4 border-green-500 p-3 rounded-r">' + t('CheckoutBannerAssinanteAplicado','Assinante DentalGO: desconto de {percent}').replace('{percent}', (pctInt/100)) + '</div>' : '';
    var totalHtml = applyDisc
        ? '<div class="pt-3 text-right"><span class="text-gray-600 mr-2">' + t('CheckoutTotal','Total') + '</span><span id="partial-total-price-original" class="text-base text-gray-500 line-through mr-2">' + formatBRLFromCents(baseTotal) + '</span><span id="partial-total-price-dynamic" class="text-xl font-bold text-green-700">' + formatBRLFromCents(finalTotal) + '</span></div>'
        : '<div class="pt-3 text-right"><span class="text-gray-600 mr-2">' + t('CheckoutTotal','Total') + '</span><span id="partial-total-price-dynamic" class="text-xl font-bold text-gray-900">' + formatBRLFromCents(baseTotal) + '</span></div>';

    step2.innerHTML = '' +
        '<h3 id="step-2-title" class="text-xl font-semibold text-gray-800 mb-4">' + t('CheckoutItensSelecionados','{{ __('messages.CheckoutItensSelecionados') }}') + '</h3>' +
        '<div id="partial-items-list" class="mt-2">' + (itemsHtml || emptyState) + '</div>' +
        warning +
        discountBannerHtml +
        totalHtml +
        '<button id="partial-continue-btn" type="button" class="mt-6 w-full ' + (window.partialCheckoutState.valid ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 cursor-not-allowed') + ' text-white py-3 rounded-lg font-semibold transition" ' + (window.partialCheckoutState.valid ? '' : 'disabled') + '>' + t('CheckoutIrPagamento','{{ __('messages.CheckoutIrPagamento') }}') + '</button>' +
        '<div id="partial-errors" class="text-red-500 mt-2 text-sm text-center"></div>';
    
    // Ajuste inicial do total para assinante com desconto
    (function(){
        try {
            var baseTot = Number(window.partialCheckoutState.totalCents || 0);
            var pctInt = Number(window.subscriberPurchaseDiscountPercent || 0); // ex.: 1000 = 10%
            var applyDisc = (window.subscriptionStatus === 'active') && pctInt > 0;
            var disc = applyDisc ? Math.round((baseTot * pctInt) / 10000) : 0;
            var finalTot = baseTot - disc;
            var tEl = step2.querySelector('#partial-total-price-dynamic');
            if (tEl) tEl.textContent = formatBRLFromCents(applyDisc ? finalTot : baseTot);
        } catch(_){}
    })();

    // Bind eventos
    var list = step2.querySelector('#partial-items-list');
    if (list) {
        list.querySelectorAll('.qty-input').forEach(function(inp, idx) {
            inp.addEventListener('input', function(e) {
                var v = parseInt(e.target.value, 10);
                window.partialCheckoutState.items[idx].qty = (Number.isFinite(v) && v >= 0) ? v : 0;
                recalcPartialTotals();
                
                var row = e.target.closest('[data-idx]');
                if (row) {
                    var sub = row.querySelector('.item-subtotal');
                    if (sub) sub.textContent = formatBRLFromCents(window.partialCheckoutState.items[idx].subtotalCents);
                }
                
                var totalEl = document.getElementById('partial-total-price-dynamic');
                var baseTot = Number(window.partialCheckoutState.totalCents || 0);
                var pctInt = Number(window.subscriberPurchaseDiscountPercent || 0);
                var applyDisc = (window.subscriptionStatus === 'active') && pctInt > 0;
                var disc = applyDisc ? Math.round((baseTot * pctInt) / 10000) : 0;
                var finalTot = baseTot - disc;
                var origEl = document.getElementById('partial-total-price-original');
                if (origEl) origEl.textContent = formatBRLFromCents(baseTot);
                if (totalEl) totalEl.textContent = formatBRLFromCents(applyDisc ? finalTot : baseTot);
                
                var btn = document.getElementById('partial-continue-btn');
                if (btn) {
                    btn.disabled = !window.partialCheckoutState.valid;
                    btn.classList.toggle('bg-green-600', window.partialCheckoutState.valid);
                    btn.classList.toggle('hover:bg-green-700', window.partialCheckoutState.valid);
                    btn.classList.toggle('bg-gray-400', !window.partialCheckoutState.valid);
                    btn.classList.toggle('cursor-not-allowed', !window.partialCheckoutState.valid);
                }
            });
        });
        
        list.querySelectorAll('.remove-item').forEach(function(btn, idx) {
            btn.addEventListener('click', function() {
                window.partialCheckoutState.items.splice(idx, 1);
                recalcPartialTotals();
                renderPartialStep();
            });
        });
    }
    
    var cta = document.getElementById('partial-continue-btn');
    if (cta) cta.addEventListener('click', proceedToPaymentPartial);
}

function updateStep3PartialSummaryFromState() {
    var wrap = document.getElementById('partial-items-summary');
    var totalEl = document.getElementById('partial-total-price');
    if (!wrap) return;
    
    if (!window.partialCheckoutState.items.length) {
        wrap.innerHTML = '<div class="p-3 text-gray-600">' + t('CheckoutNenhumItem','Nenhum item selecionado. Volte e selecione os itens desejados.') + '</div>';
        if (totalEl) totalEl.textContent = formatBRLFromCents(0);
        return;
    }
    
    var html = window.partialCheckoutState.items.map(function(it) {
        return '<div class="flex items-center gap-3 py-2 border-b border-gray-200 last:border-b-0">' +
               (it.cover ? ('<img src="' + it.cover + '" alt="' + (it.title || t('CheckoutItemLabel','Item')) + '" class="w-12 h-12 object-cover rounded" />') : '') +
               '<div class="flex-1 text-sm text-gray-700">' + (it.title || t('CheckoutItemLabel','Item')) + ' <span class="text-gray-500">x' + it.qty + '</span></div>' +
               '<div class="text-sm font-medium text-gray-800">' + formatBRLFromCents(it.subtotalCents) + '</div>' +
               '</div>';
    }).join('');
    
    var baseTotal = Number(window.partialCheckoutState.totalCents || 0);
    var pctInt = Number(window.subscriberPurchaseDiscountPercent || 0);
    var applyDisc = (window.subscriptionStatus === 'active') && pctInt > 0;
    var disc = applyDisc ? Math.round((baseTotal * pctInt) / 10000) : 0;
    var finalTotal = baseTotal - disc;

    if (applyDisc) {
        html = '<div id="partial-discount-banner-step3" class="mt-2 text-sm text-green-700 bg-green-50 border-l-4 border-green-500 p-3 rounded-r">' + t('CheckoutBannerAssinanteVisual','Assinante DentalGO: desconto de {percent} (visual)').replace('{percent}', (pctInt/100)) + '</div>' + html;
    }

    if (applyDisc) {
        html += '<div class="pt-3 text-right"><span class="text-gray-600 mr-2">' + t('CheckoutTotal','Total') + '</span><span id="partial-total-price-original-step3" class="text-base text-gray-500 line-through mr-2">' + formatBRLFromCents(baseTotal) + '</span><span id="partial-total-price" class="text-xl font-bold text-gray-900">' + formatBRLFromCents(finalTotal) + '</span></div>';
    } else {
        html += '<div class="pt-3 text-right"><span class="text-gray-600 mr-2">' + t('CheckoutTotal','Total') + '</span><span id="partial-total-price" class="text-xl font-bold text-gray-900">' + formatBRLFromCents(baseTotal) + '</span></div>';
    }
    wrap.innerHTML = html;
}

function proceedToPaymentPartial() {
    if (!window.partialCheckoutState.valid) {
        var err = document.getElementById('partial-errors');
        if (err) err.textContent = t('CheckoutSelecioneAoMenosUmItem','Selecione ao menos 1 item válido.');
        return;
    }
    
    try {
        if (typeof addDebugLog === 'function') {
            addDebugLog('Prosseguindo para pagamento com itens parciais', 'info');
        }
    } catch (_) {}
    
    // Preenche campos ocultos do formulário de pagamento
    var itemTypeEl = document.getElementById('itemType');
    if (itemTypeEl) itemTypeEl.value = 'product';
    
    var pidEl = document.getElementById('product_id');
    if (pidEl) {
        pidEl.value = window.partialCheckoutState.productId || '';
    }
    
    var container = document.getElementById('partialHiddenContainer');
    if (container) {
        container.innerHTML = '';
    }
    
    window.partialCheckoutState.items.forEach(function(it) {
        if (!it.available || it.qty <= 0) return;
        for (var i = 0; i < it.qty; i++) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'productItemsIds[]';
            input.value = String(it.itemId);
            container.appendChild(input);
        }
    });
    
    // Persiste estado
    try {
        sessionStorage.setItem('checkout_partial_state', JSON.stringify({
            productId: window.partialCheckoutState.productId,
            items: window.partialCheckoutState.items,
            totalCents: window.partialCheckoutState.totalCents
        }));
    } catch (_) {}
    
    // Avança para etapa 3 e atualiza resumo
    if (typeof nextStep === 'function') {
        nextStep(3);
    }
    updateStep3PartialSummaryFromState();
}
</script>

</body>
</html>