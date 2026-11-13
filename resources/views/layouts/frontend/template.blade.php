<!DOCTYPE html>
<html lang="id">
@php
  if (!isset($cleanWa) || empty($cleanWa)) {
      $cleanWa = '';
      if (!empty($contact->no_wa)) {
          $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
          if (strpos($cleanWa, '08') === 0) {
              $cleanWa = '628' . substr($cleanWa, 2);
          } elseif (strpos($cleanWa, '8') === 0) {
              $cleanWa = '628' . substr($cleanWa, 1);
          }
      }
  }
  $isHome = request()->routeIs('homepage') || request()->routeIs('homepage.galeri');
@endphp
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="referrer" content="strict-origin-when-cross-origin">
  <title>@yield('title', 'Teknik Informatika (UIS) | Unggul, Profesional & Berintegritas')</title>
  <meta name="description" content="@yield('meta_description', 'Portal Resmi Teknik Informatika (UIS) — Menyelenggarakan Pendidikan Tinggi Berkualitas, Riset Terapan, dan Pengabdian Masyarakat Berdaya Saing Global.')">
  <meta name="keywords" content="@yield('meta_keywords', 'teknik informatika, uis, pmb uis, pendaftaran uis, kampus batam, perguruan tinggi batam, pendidikan tinggi, riset terpadu')">
  <meta name="author" content="@yield('meta_author', 'Teknik Informatika')">

  <!-- Open Graph / Facebook / WhatsApp / Telegram Preview -->
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'Teknik Informatika (UIS) | Unggul, Profesional & Berintegritas'))">
  <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Portal Resmi Teknik Informatika (UIS) — Menyelenggarakan Pendidikan Tinggi Berkualitas, Riset Terapan, dan Pengabdian Masyarakat Berdaya Saing Global.'))">
  <meta property="og:image" content="@yield('og_image', asset('assets/img/logouis.png'))">
  <meta property="og:image:secure_url" content="@yield('og_image', asset('assets/img/logouis.png'))">
  <meta property="og:image:width" content="@yield('og_image_width', '1200')">
  <meta property="og:image:height" content="@yield('og_image_height', '630')">
  <meta property="og:image:type" content="@yield('og_image_type', 'image/jpeg')">
  <meta property="og:site_name" content="Teknik Informatika">

  <!-- Twitter / X Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="{{ url()->current() }}">
  <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', 'Teknik Informatika (UIS) | Unggul, Profesional & Berintegritas'))">
  <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', 'Portal Resmi Teknik Informatika (UIS) — Menyelenggarakan Pendidikan Tinggi Berkualitas, Riset Terapan, dan Pengabdian Masyarakat Berdaya Saing Global.'))">
  <meta name="twitter:image" content="@yield('og_image', asset('assets/img/logouis.png'))">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logouis.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/logouis.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS Animation CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Swiper Slider CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

  <!-- Master Unified Frontend CSS -->
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v={{ file_exists(public_path('frontend/css/style.css')) ? filemtime(public_path('frontend/css/style.css')) : time() }}">

  @stack('styles')

  @php
    $thHdrBg = $themeSetting?->header_bg_color ?: '#f9dc4b';
    $thHdrTxt = $themeSetting?->header_text_color ?: '#ffffff';
    $thHdrActBg = $themeSetting?->header_active_bg_color ?: '#000000';
    $thHdrActTxt = $themeSetting?->header_active_text_color ?: '#ffffff';
    $thHdrLogBg = $themeSetting?->header_login_bg_color ?: '#000000';
    $thHdrLogTxt = $themeSetting?->header_login_text_color ?: '#ffffff';
    $thHdrLangBg = $themeSetting?->header_lang_bg_color ?: '#000000';
    $thHdrLangTxt = $themeSetting?->header_lang_text_color ?: '#ffffff';
    $thHdrShadow = $themeSetting?->header_shadow_color ?: $thHdrBg;
    $thHdrSticky = $themeSetting ? ($themeSetting->header_is_sticky ?? true) : true;
    $thTopBg = $themeSetting?->topbar_bg_color ?: '#000000';
    $thTopTxt = $themeSetting?->topbar_text_color ?: '#ffffff';
    $thTopSocBg = $themeSetting?->topbar_social_bg_color ?: '#ffffff';
    $thTopSocTxt = $themeSetting?->topbar_social_text_color ?: '#000000';
    $thAccent = $themeSetting?->accent_color ?: '#f9dc4b';
    $thFtrBg = $themeSetting?->footer_bg_color ?: '#000000';
    $thFtrTxt = $themeSetting?->footer_text_color ?: '#ffffff';
    $thFtrHead = $themeSetting?->footer_heading_color ?: '#f9dc4b';
    $thFtrBorder = $themeSetting?->footer_border_top_color ?: '#f9dc4b';
    $thFtrLink = $themeSetting?->footer_link_color ?: '#ffffff';
    $thFtrLinkHov = $themeSetting?->footer_link_hover_color ?: '#f9dc4b';
    $thFtrSocBg = $themeSetting?->footer_social_bg_color ?: '#f9dc4b';
    $thFtrSocTxt = $themeSetting?->footer_social_text_color ?: '#000000';
  @endphp
  <style id="dynamic-theme-styles">
    html, body {
      margin: 0 !important;
      padding: 0 !important;
      border: none !important;
      outline: none !important;
    }
    :root {
      --hdr-bg: {{ $thHdrBg }};
      --hdr-text: {{ $thHdrTxt }};
      --hdr-act-bg: {{ $thHdrActBg }};
      --hdr-act-text: {{ $thHdrActTxt }};
      --hdr-log-bg: {{ $thHdrLogBg }};
      --hdr-log-text: {{ $thHdrLogTxt }};
      --hdr-lang-bg: {{ $thHdrLangBg }};
      --hdr-lang-text: {{ $thHdrLangTxt }};
      --hdr-shadow: {{ $thHdrShadow }};
      --topbar-custom-bg: {{ $thTopBg }};
      --topbar-custom-text: {{ $thTopTxt }};
      --topbar-soc-bg: {{ $thTopSocBg }};
      --topbar-soc-txt: {{ $thTopSocTxt }};
      --accent-custom: {{ $thAccent }};
      --ftr-bg: {{ $thFtrBg }};
      --ftr-text: {{ $thFtrTxt }};
      --ftr-head: {{ $thFtrHead }};
      --ftr-border: {{ $thFtrBorder }};
      --ftr-link: {{ $thFtrLink }};
      --ftr-link-hov: {{ $thFtrLinkHov }};
      --ftr-soc-bg: {{ $thFtrSocBg }};
      --ftr-soc-txt: {{ $thFtrSocTxt }};
    }
    .topbar-main {
      background: var(--topbar-custom-bg) !important;
      color: var(--topbar-custom-text) !important;
    }
    .topbar-main a, .topbar-main .topbar-marquee-text {
      color: var(--topbar-custom-text) !important;
    }
    .topbar-main .topbar-sosmed-btn {
      background: var(--topbar-soc-bg) !important;
      color: var(--topbar-soc-txt) !important;
    }
    .topbar-main .topbar-search-btn {
      color: var(--topbar-soc-txt) !important;
    }
    .navbar-main {
      background: var(--hdr-bg) !important;
      border: none !important;
      border-top: none !important;
      border-bottom: none !important;
      outline: none !important;
      top: -2px !important;
      margin-top: -2px !important;
      padding-top: 22px !important;
      box-shadow: 0 -8px 0 0 var(--hdr-shadow), 0 4px 18px rgba(0, 0, 0, 0.12) !important;
      {{ $thHdrSticky ? 'position: sticky;' : 'position: relative;' }}
    }
    .brand-title-main {
      color: var(--hdr-text) !important;
    }
    .brand-subtitle-main {
      color: var(--hdr-text) !important;
      opacity: 0.88 !important;
    }
    .nav-link-custom {
      color: var(--hdr-text) !important;
    }
    .nav-link-custom:hover,
    .nav-link-custom.active,
    .show > .nav-link-custom {
      background: var(--hdr-act-bg) !important;
      color: var(--hdr-act-text) !important;
    }
    .btn-portal-nav {
      background: var(--hdr-log-bg) !important;
      color: var(--hdr-log-text) !important;
    }
    .btn-portal-nav:hover {
      background: var(--hdr-log-bg) !important;
      color: var(--hdr-log-text) !important;
      opacity: 0.88 !important;
    }
    .uis-lang-toggle {
      background: var(--hdr-lang-bg) !important;
      color: var(--hdr-lang-text) !important;
    }
    .uis-lang-toggle i,
    .uis-lang-toggle .uis-lang-name {
      color: var(--hdr-lang-text) !important;
    }
    .uis-lang-toggle:hover,
    .uis-lang-toggle:focus,
    .show > .uis-lang-toggle {
      background: var(--hdr-lang-bg) !important;
      color: var(--hdr-lang-text) !important;
      opacity: 0.88 !important;
    }
    .uis-lang-toggle:hover i,
    .show > .uis-lang-toggle i,
    .uis-lang-toggle:hover .uis-lang-name,
    .show > .uis-lang-toggle .uis-lang-name {
      color: var(--hdr-lang-text) !important;
    }
    /* Hero Header Dinamis mengikuti tema */
    .akademik-hero {
      border-bottom: 3px solid var(--accent-custom, #f9dc4b) !important;
    }
    .akademik-hero .badge {
      background: var(--accent-custom, #f9dc4b) !important;
      border-color: var(--accent-custom, #f9dc4b) !important;
    }
    .akademik-hero .breadcrumb-custom a:hover,
    .akademik-hero .breadcrumb-custom .active,
    .akademik-hero .breadcrumb-custom span.active {
      color: var(--accent-custom, #f9dc4b) !important;
    }
    .footer-main {
      background: var(--ftr-bg) !important;
      color: var(--ftr-text) !important;
      border-top: 4px solid var(--ftr-border) !important;
    }
    .footer-heading {
      color: var(--ftr-head) !important;
    }
    .footer-desc, .footer-contact-text, .footer-contact-text strong, .footer-bottom, .footer-bottom span, .footer-bottom a {
      color: var(--ftr-text) !important;
    }
    .footer-links a {
      color: var(--ftr-link) !important;
    }
    .footer-links a:hover {
      color: var(--ftr-link-hov) !important;
    }
    .footer-social a {
      background: var(--ftr-soc-bg) !important;
      color: var(--ftr-soc-txt) !important;
      border-color: var(--ftr-soc-bg) !important;
    }
  </style>
</head>

<body>

<!-- ═══════════════════════════════════════════════
     TOPBAR — MARQUEE & SOSMED
═══════════════════════════════════════════════ -->
@include('layouts.frontend.partials.topbar')

<!-- ═══════════════════════════════════════════════
     NAVBAR HEADER UTAMA
═══════════════════════════════════════════════ -->
@include('layouts.frontend.header')

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
@yield('content')

<!-- ═══════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════ -->
@include('layouts.frontend.footer')

<!-- Back to Top -->
<a href="#" class="back-to-top" id="backToTop">
  <i class="bi bi-chevron-up"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Swiper Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  AOS.init({
    once: true,
    duration: 400,
    offset: 20,
    delay: 0,
    disable: function() {
      return window.innerWidth < 768;
    }
  });

  const btn = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    btn.classList.toggle('show', window.scrollY > 400);
  });
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  function toggleFaq(id) {
    const item = document.getElementById(id);
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(f => f.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }
</script>

<!-- ═══════════════════════════════════════════════
     GOOGLE TRANSLATE MULTI-LANGUAGE SYSTEM
═══════════════════════════════════════════════ -->
<div id="google_translate_element" style="display:none; position:absolute; left:-9999px; top:-9999px;"></div>

@php
  $includedCodes = (isset($bahasaList) && $bahasaList->count() > 0)
      ? $bahasaList->pluck('kode')->implode(',')
      : 'id,en,ar,zh-CN,nl,tl,fr,de,hi,it,ko,ja';
@endphp

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'id',
      includedLanguages: '{{ $includedCodes }}',
      autoDisplay: false
    }, 'google_translate_element');
  }

  function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
    return match ? decodeURIComponent(match[3]) : null;
  }

  function clearGoogTransCookie() {
    var hostname = window.location.hostname;
    document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + hostname;
    var domainParts = hostname.split('.');
    while (domainParts.length > 1) {
      document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=." + domainParts.join('.');
      domainParts.shift();
    }
  }

  function setGoogTransCookie(langCode) {
    var val = '/id/' + langCode;
    var hostname = window.location.hostname;
    document.cookie = "googtrans=" + val + "; path=/;";
    document.cookie = "googtrans=" + val + "; path=/; domain=" + hostname;
    var domainParts = hostname.split('.');
    if (domainParts.length > 1) {
      document.cookie = "googtrans=" + val + "; path=/; domain=." + domainParts.slice(-2).join('.');
    }
  }

  function updateActiveLangUI(langCode, langName, flagUrl) {
    var nameEl = document.getElementById('uisCurrentName');
    var shortEl = document.getElementById('uisCurrentShort');
    var flagImgEl = document.getElementById('uisCurrentFlagImg');

    if (nameEl) nameEl.textContent = langName;
    if (shortEl) {
      var shortName = langName.indexOf(' ') !== -1 ? langName.split(' ')[1] : langName;
      shortEl.textContent = shortName;
    }
    if (flagImgEl && flagUrl) {
      flagImgEl.src = flagUrl;
    }

    document.querySelectorAll('.uis-lang-item').forEach(function(item) {
      item.classList.remove('active-lang');
    });
    document.querySelectorAll('.uis-check-icon').forEach(function(icon) {
      icon.classList.add('d-none');
    });

    var activeItem = document.querySelector('.uis-lang-item[data-code="' + langCode + '"]');
    if (activeItem) {
      activeItem.classList.add('active-lang');
      var checkIcon = document.getElementById('check-lang-' + langCode);
      if (checkIcon) checkIcon.classList.remove('d-none');
    }
  }

  function uisChangeLanguage(langCode, langName, flagUrl) {
    if (langCode === 'id') {
      clearGoogTransCookie();
      localStorage.setItem('uis_selected_lang', 'id');
      localStorage.setItem('uis_selected_lang_name', 'Bahasa Indonesia');
      localStorage.setItem('uis_selected_lang_flag', flagUrl || '{{ asset('assets/img/flags/id.png') }}');
      
      var combo = document.querySelector('.goog-te-combo');
      if (combo) {
        combo.value = 'id';
        combo.dispatchEvent(new Event('change'));
      }
      setTimeout(function() {
        window.location.reload();
      }, 150);
      return;
    }

    setGoogTransCookie(langCode);
    localStorage.setItem('uis_selected_lang', langCode);
    localStorage.setItem('uis_selected_lang_name', langName);
    localStorage.setItem('uis_selected_lang_flag', flagUrl);

    var combo = document.querySelector('.goog-te-combo');
    if (combo) {
      combo.value = langCode;
      combo.dispatchEvent(new Event('change'));
      updateActiveLangUI(langCode, langName, flagUrl);
    } else {
      window.location.reload();
    }
  }

  // Restore active language selection UI on load
  document.addEventListener('DOMContentLoaded', function() {
    var savedCode = localStorage.getItem('uis_selected_lang');
    var savedName = localStorage.getItem('uis_selected_lang_name');
    var savedFlag = localStorage.getItem('uis_selected_lang_flag');

    var googCookie = getCookie('googtrans');
    if (googCookie) {
      var parts = googCookie.split('/');
      var currentCookieLang = parts[parts.length - 1];
      if (currentCookieLang && currentCookieLang !== 'id') {
        savedCode = currentCookieLang;
      } else if (currentCookieLang === 'id') {
        savedCode = 'id';
      }
    }

    if (savedCode) {
      var item = document.querySelector('.uis-lang-item[data-code="' + savedCode + '"]');
      if (item) {
        var flag = item.getAttribute('data-flag') || savedFlag;
        var name = item.getAttribute('data-name') || savedName || savedCode;
        updateActiveLangUI(savedCode, name, flag);
      }
    }
  });
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" defer></script>

<!-- ══════════════════════════════════════════════════════════════
     REALTIME LIVE SYNC (Otomatis Update saat Admin Submit / Update)
══════════════════════════════════════════════════════════════ -->
<script>
(function() {
  var initialVersion = null;
  var isReloading = false;
  var deferredTimer = null;

  function doLiveReload(source) {
    if (isReloading) return;

    // Jangan reload jika user sedang aktif mengetik di input / textarea formulir publik
    var activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
    if (activeTag === 'input' || activeTag === 'textarea' || activeTag === 'select') {
      if (!deferredTimer) {
        deferredTimer = setTimeout(function() {
          doLiveReload(source + '-deferred');
        }, 4000);
      }
      return;
    }

    isReloading = true;
    console.log('[LiveSync] Realtime content update detected from ' + source);

    // Tampilkan notifikasi floating badge di pojok kanan bawah
    var badge = document.getElementById('webtfLiveSyncBadge');
    if (!badge) {
      badge = document.createElement('div');
      badge.id = 'webtfLiveSyncBadge';
      badge.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:999999;background:#000000;color:#ffffff;padding:12px 22px;border-radius:50px;box-shadow:0 12px 35px rgba(0,0,0,0.45);border:2px solid #f9dc4b;display:flex;align-items:center;gap:12px;font-family:\'Plus Jakarta Sans\',sans-serif;font-size:13.5px;font-weight:600;letter-spacing:0.3px;pointer-events:none;animation:fadeInUp 0.3s ease;';
      badge.innerHTML = '<span class="spinner-border spinner-border-sm text-warning" style="width:16px;height:16px;border-width:2.5px;" role="status"></span><span>Memperbarui data terbaru secara realtime...</span>';
      document.body.appendChild(badge);
    }

    setTimeout(function() {
      window.location.reload();
    }, 450);
  }

  // 1. BroadcastChannel API: Komunikasi Lintas Tab di Browser yang Sama (0 ms latency)
  if ('BroadcastChannel' in window) {
    try {
      var liveChannel = new BroadcastChannel('webtf_realtime_sync');
      liveChannel.onmessage = function(ev) {
        if (ev && ev.data && ev.data.type === 'CONTENT_UPDATED') {
          doLiveReload('BroadcastChannel');
        }
      };
    } catch(e) {}
  }

  // 2. LocalStorage Event: Fallback Lintas Jendela / Window
  window.addEventListener('storage', function(e) {
    if (e.key === 'webtf_live_version') {
      doLiveReload('LocalStorage');
    }
  });

  // 3. Server Pulse Polling: Untuk Lintas Perangkat / Browser Berbeda / Incognito
  var liveVersionUrl = '{{ route("api.live-version") }}';
  function checkLivePulse() {
    if (isReloading) return;
    fetch(liveVersionUrl + '?_t=' + Date.now(), {
      cache: 'no-store',
      headers: { 'Cache-Control': 'no-cache, no-store' }
    })
    .then(function(res) {
      if (!res.ok) throw new Error('Network error');
      return res.json();
    })
    .then(function(data) {
      if (!data || typeof data.version === 'undefined') return;
      var serverVer = parseInt(data.version, 10);
      if (initialVersion === null) {
        initialVersion = serverVer;
      } else if (serverVer > initialVersion) {
        doLiveReload('ServerPulse');
      }
    })
    .catch(function() {});
  }

  // Cek server saat halaman dimuat
  checkLivePulse();

  // Polling interval adaptif (setiap 3.5 detik saat tab aktif, 8 detik saat di background)
  var pulseInterval = setInterval(checkLivePulse, 3500);

  document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
      clearInterval(pulseInterval);
      pulseInterval = setInterval(checkLivePulse, 8000);
    } else {
      clearInterval(pulseInterval);
      checkLivePulse();
      pulseInterval = setInterval(checkLivePulse, 3500);
    }
  });
})();
</script>

@stack('scripts')

</body>
</html>
