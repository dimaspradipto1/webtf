@php
    /** @var string $pageKey */
    $headerData = isset($header) && $header instanceof \App\Models\PageHeader 
        ? $header 
        : \App\Models\PageHeader::get($pageKey, $defaultJudul ?? null, $defaultSubjudul ?? null, $defaultBreadcrumb ?? null);

    $finalBadge = $headerData->badge_text ?: \App\Models\PageHeader::$defaultBadge;
    $finalJudul = $headerData->judul;
    $finalSubjudul = $headerData->subjudul;
    $finalBreadcrumb = $breadcrumbLabel ?? ($headerData->breadcrumb_label ?: $finalJudul);
@endphp

<!-- ═══════════════════════════════════════════════
     HERO HEADER & BREADCRUMB
═══════════════════════════════════════════════ -->
<section class="akademik-hero">
  <div class="container position-relative" data-aos="fade-up">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange, #f9dc4b); color: #000000; font-weight: 800; font-size: 11.5px; letter-spacing: 0.8px;">
      {{ $finalBadge }}
    </div>
    <h1 class="display-6 fw-bold text-white mb-2">{{ $finalJudul }}</h1>
    @if(!empty($finalSubjudul))
      <p class="lead text-white-50 mb-0" style="max-width: 760px; font-size: 16px;">
        {{ $finalSubjudul }}
      </p>
    @endif
    <div class="breadcrumb-custom mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      @if(isset($parentUrl) && isset($parentLabel))
        <span>/</span>
        <a href="{{ $parentUrl }}">{{ $parentLabel }}</a>
      @elseif(isset($parentLabel))
        <span>/</span>
        <span>{{ $parentLabel }}</span>
      @endif
      <span>/</span>
      <span class="active">{{ $finalBreadcrumb }}</span>
    </div>
  </div>
</section>

