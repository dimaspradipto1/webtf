@extends('layouts.frontend.template')

@section('title', 'Teknik Informatika (UIS) — Unggul, Profesional & Berintegritas')
@section('meta_description', 'Portal Resmi Teknik Informatika (UIS) Batam — Mewujudkan Perguruan Tinggi Terkemuka Berdaya Saing Global, Inovatif, dan Berakhlak Mulia.')

@section('content')
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact?->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp


@php
  $activeSections = isset($themeSetting) ? $themeSetting->getActiveSectionsList() : \App\Models\ThemeSetting::defaultSections();
@endphp

@foreach($activeSections as $sec)
  @if(!empty($sec['is_active']))
    @includeIf('layouts.frontend.sections.' . $sec['key'])
  @endif
@endforeach

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ── Hero Banner Carousel Auto Slide & Click / Swipe Interaction ───────────
    const heroCarouselEl = document.getElementById('heroCarousel');
    if (heroCarouselEl && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
      const carouselInstance = bootstrap.Carousel.getOrCreateInstance(heroCarouselEl, {
        interval: 4500,
        ride: 'carousel',
        pause: false,
        wrap: true,
        touch: true
      });

      // Mulai auto slide langsung saat DOM selesai dimuat
      carouselInstance.cycle();

      // Tombol Navigasi Prev / Next (Manual Click Fallback)
      const prevBtn = heroCarouselEl.querySelector('.carousel-control-prev');
      const nextBtn = heroCarouselEl.querySelector('.carousel-control-next');
      if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
          e.preventDefault();
          carouselInstance.prev();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          carouselInstance.next();
        });
      }

      // Indikator Titik / Kapsul
      const indicatorBtns = heroCarouselEl.querySelectorAll('.carousel-indicators [data-bs-slide-to]');
      indicatorBtns.forEach((btn) => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();
          const targetIndex = parseInt(this.getAttribute('data-bs-slide-to'), 10);
          if (!isNaN(targetIndex)) {
            carouselInstance.to(targetIndex);
          }
        });
      });

      // Geser / Swipe Banner (Touch & Mouse Drag)
      let touchStartX = 0;
      let touchEndX = 0;
      let mouseStartX = 0;
      let isMouseDown = false;

      heroCarouselEl.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].clientX;
      }, { passive: true });

      heroCarouselEl.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].clientX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            carouselInstance.next();
          } else {
            carouselInstance.prev();
          }
        }
      }, { passive: true });

      heroCarouselEl.addEventListener('mousedown', function (e) {
        if (e.target.closest('.carousel-control-prev') || e.target.closest('.carousel-control-next') || e.target.closest('.carousel-indicators')) {
          return;
        }
        isMouseDown = true;
        mouseStartX = e.clientX;
        heroCarouselEl.classList.add('is-dragging');
      });

      window.addEventListener('mouseup', function (e) {
        if (!isMouseDown) return;
        isMouseDown = false;
        heroCarouselEl.classList.remove('is-dragging');
        const diff = mouseStartX - e.clientX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            carouselInstance.next();
          } else {
            carouselInstance.prev();
          }
        }
      });
    }

    if (document.querySelector('.alumniSwiper')) {
      new Swiper('.alumniSwiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: {
          delay: 3800,
          disableOnInteraction: false,
          pauseOnMouseEnter: true
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          dynamicBullets: true
        },
        navigation: {
          nextEl: '.alumni-next',
          prevEl: '.alumni-prev'
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 20
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 26
          }
        }
      });
    }

    // ── Live Search Berita Homepage ─────────────────────────────────────────
    const searchInput = document.getElementById('homepageNewsSearchInput');
    const searchForm  = document.getElementById('homepageNewsSearchForm');
    const clearBtn    = document.getElementById('homepageNewsSearchClear');
    const searchIcon  = document.getElementById('homepageNewsSearchIcon');
    const searchSpin  = document.getElementById('homepageNewsSearchSpinner');
    const gridContainer = document.getElementById('homepageNewsGridContainer');
    const seeAllBtn   = document.getElementById('btnSeeAllNews');

    let searchDebounceTimer = null;
    let searchAbortController = null;

    function performNewsSearch(query, customUrl = null) {
      if (searchSpin) searchSpin.classList.remove('d-none');
      if (searchIcon) searchIcon.classList.add('d-none');
      if (gridContainer) gridContainer.classList.add('is-loading');

      if (searchAbortController) {
        searchAbortController.abort();
      }
      searchAbortController = new AbortController();

      const url = customUrl || `{{ route('homepage') }}?q=${encodeURIComponent(query)}&page_berita=1`;

      fetch(url, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        signal: searchAbortController.signal
      })
      .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
      })
      .then(data => {
        if (gridContainer && data.html) {
          gridContainer.innerHTML = data.html;
        }

        // Update link "Lihat Berita Lainnya"
        if (seeAllBtn) {
          if (query && query.trim() !== '') {
            seeAllBtn.href = `{{ route('homepage.news') }}?q=${encodeURIComponent(query)}`;
          } else {
            seeAllBtn.href = `{{ route('homepage.news') }}`;
          }
        }

        // Update URL query string tanpa reload halaman
        const newUrl = query && query.trim() !== ''
          ? `{{ route('homepage') }}?q=${encodeURIComponent(query)}#berita`
          : `{{ route('homepage') }}#berita`;
        window.history.replaceState({ q: query }, '', newUrl);
      })
      .catch(err => {
        if (err.name !== 'AbortError') {
          console.error('Error saat mencari berita:', err);
        }
      })
      .finally(() => {
        if (searchSpin) searchSpin.classList.add('d-none');
        if (searchIcon) searchIcon.classList.remove('d-none');
        if (gridContainer) gridContainer.classList.remove('is-loading');
      });
    }

    if (searchInput) {
      searchInput.addEventListener('input', function () {
        const val = this.value;
        if (clearBtn) {
          if (val.trim().length > 0) {
            clearBtn.classList.remove('d-none');
          } else {
            clearBtn.classList.add('d-none');
          }
        }

        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
          performNewsSearch(val.trim());
        }, 300);
      });
    }

    if (clearBtn) {
      clearBtn.addEventListener('click', function () {
        if (searchInput) {
          searchInput.value = '';
          searchInput.focus();
        }
        clearBtn.classList.add('d-none');
        performNewsSearch('');
      });
    }

    if (searchForm) {
      searchForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearTimeout(searchDebounceTimer);
        const val = searchInput ? searchInput.value.trim() : '';
        performNewsSearch(val);
      });
    }

    // Event delegation untuk tombol reset dan navigasi pagination AJAX
    document.addEventListener('click', function (e) {
      const resetBtn = e.target.closest('#btnResetNewsSearch') || e.target.closest('#btnResetNewsSearchFallback');
      if (resetBtn) {
        e.preventDefault();
        if (searchInput) {
          searchInput.value = '';
          searchInput.focus();
        }
        if (clearBtn) clearBtn.classList.add('d-none');
        performNewsSearch('');
        return;
      }

      const paginationLink = e.target.closest('#homepageNewsPaginationWrap a');
      if (paginationLink && gridContainer && gridContainer.contains(paginationLink)) {
        e.preventDefault();
        const pageHref = paginationLink.getAttribute('href');
        if (pageHref) {
          const currentQuery = searchInput ? searchInput.value.trim() : '';
          performNewsSearch(currentQuery, pageHref);

          const beritaSec = document.getElementById('berita');
          if (beritaSec) {
            beritaSec.scrollIntoView({ behavior: 'smooth' });
          }
        }
      }
    });
    // ── 3D Stacked Card Deck Showcase (Ormawa & Kegiatan Mahasiswa) ────────
    const deckStack = document.getElementById('ormawaDeckStack');
    if (deckStack) {
      const cards = Array.from(deckStack.querySelectorAll('.ormawa-deck-card'));
      const totalCards = cards.length;

      if (totalCards > 0) {
        let activeIdx = 0;
        let isTransitioning = false;
        let autoDeckTimer = null;

        const numEl = document.getElementById('deckTrackerNum');
        const thumbEl = document.getElementById('deckTrackerThumb');
        const labelEl = document.getElementById('deckTrackerLabel');
        const railEl = document.getElementById('deckTrackerRail');
        const prevBtn = document.getElementById('deckPrevBtn');
        const nextBtn = document.getElementById('deckNextBtn');
        const stageArea = document.getElementById('ormawaStageArea');

        // Slot tumpukan: 0 = kartu aktif di depan (bawah), 1..3 = kartu di belakang bertingkat ke atas
        const SLOT_STYLE = [
          { s: 1.00, y: 135, op: 1.00, br: 1.00, sh: '0 28px 55px -12px rgba(0, 35, 12, 0.50), 0 0 0 1px rgba(255,255,255,0.22) inset' },
          { s: 0.94, y: 85,  op: 0.95, br: 0.92, sh: '0 20px 40px rgba(0, 0, 0, 0.28)' },
          { s: 0.88, y: 40,  op: 0.82, br: 0.85, sh: '0 16px 32px rgba(0, 0, 0, 0.22)' },
          { s: 0.82, y: 0,   op: 0.65, br: 0.75, sh: '0 12px 24px rgba(0, 0, 0, 0.16)' }
        ];

        // Spring-like easing (crisp organic settling)
        const TRANSITION_ON = 'transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1), filter 0.55s ease, box-shadow 0.55s ease';

        function getDeckPositions() {
          const w = window.innerWidth;
          const k = w <= 576 ? 0.75 : (w <= 991 ? 0.85 : 1);
          return {
            slotY: SLOT_STYLE.map(st => st.y * k),
            yHidden: -60 * k,
            yDrop: 560 * k
          };
        }

        function applyState(card, state, pos) {
          if (state === 'dropped') {
            card.style.transform = `translate3d(0, ${pos.yDrop}px, 0) scale(1.04)`;
            card.style.zIndex = '25';
            card.style.opacity = '0';
            card.style.pointerEvents = 'none';
          } else if (state === 'hidden') {
            card.style.transform = `translate3d(0, ${pos.yHidden}px, 0) scale(0.76)`;
            card.style.zIndex = '15';
            card.style.opacity = '0';
            card.style.pointerEvents = 'none';
          } else {
            const st = SLOT_STYLE[state];
            card.style.transform = `translate3d(0, ${pos.slotY[state]}px, 0) scale(${st.s})`;
            card.style.zIndex = String(20 - state);
            card.style.opacity = String(st.op);
            card.style.filter = `brightness(${st.br})`;
            card.style.pointerEvents = 'auto';
            card.style.boxShadow = st.sh;
          }
        }

        function renderDeck(targetIdx, smooth = true) {
          if (targetIdx < 0) targetIdx = totalCards - 1;
          if (targetIdx >= totalCards) targetIdx = 0;
          activeIdx = targetIdx;

          const pos = getDeckPositions();
          const visibleSlots = Math.min(SLOT_STYLE.length, Math.max(1, totalCards - 1));

          cards.forEach((card, idx) => {
            const diff = ((idx - activeIdx) % totalCards + totalCards) % totalCards;
            let state;
            if (diff < visibleSlots) state = diff;
            else if (totalCards > 1 && diff === totalCards - 1) state = 'dropped';
            else state = 'hidden';

            const prev = card.dataset.state;
            clearTimeout(card._deckTimer);

            if (!smooth || prev === undefined) {
              card.style.transition = 'none';
              applyState(card, state, pos);
            } else if (prev === 'dropped' && state !== 0) {
              // Kartu yang sudah jatuh disiapkan di hidden lalu meluncur ke slot belakang
              card.style.transition = 'none';
              applyState(card, 'hidden', pos);
              void card.offsetHeight;
              card.style.transition = TRANSITION_ON;
              applyState(card, state, pos);
            } else if (state === 'dropped' && prev !== '0') {
              card.style.transition = TRANSITION_ON;
              applyState(card, 'hidden', pos);
              card._deckTimer = setTimeout(() => {
                card.style.transition = 'none';
                applyState(card, 'dropped', getDeckPositions());
              }, 600);
            } else {
              card.style.transition = TRANSITION_ON;
              applyState(card, state, pos);
            }
            card.dataset.state = String(state);
          });

          // Update Tracker UI
          const currentCard = cards[activeIdx];
          const formattedNum = (activeIdx + 1).toString().padStart(2, '0');
          if (numEl) numEl.textContent = formattedNum;
          if (labelEl) labelEl.textContent = currentCard.getAttribute('data-label') || '';

          if (thumbEl && totalCards > 1) {
            const pct = (activeIdx / (totalCards - 1)) * 100;
            thumbEl.style.top = `calc(${pct}% - ${(pct / 100) * 28}px)`;
          }
        }

        function nextCard() {
          if (isTransitioning) return;
          isTransitioning = true;
          let next = activeIdx + 1;
          if (next >= totalCards) next = 0;
          renderDeck(next);
          setTimeout(() => { isTransitioning = false; }, 550);
        }

        function prevCard() {
          if (isTransitioning) return;
          isTransitioning = true;
          let prev = activeIdx - 1;
          if (prev < 0) prev = totalCards - 1;
          renderDeck(prev);
          setTimeout(() => { isTransitioning = false; }, 550);
        }

        // Mouse Wheel Scroll Listener
        if (stageArea) {
          let lastWheelTime = 0;
          const wheelCooldown = 550;

          stageArea.addEventListener('wheel', function (e) {
            e.preventDefault();
            const now = Date.now();
            if (now - lastWheelTime < wheelCooldown) return;
            if (Math.abs(e.deltaY) < 15) return;

            lastWheelTime = now;
            if (e.deltaY > 0) nextCard();
            else prevCard();
          }, { passive: false });
        }

        // Interactive Pointer Drag (Mouse & Touch Drag with Spring Toss)
        let isDragging = false;
        let dragStartY = 0;
        let dragCurrentDelta = 0;

        function startDrag(clientY) {
          if (isTransitioning) return;
          isDragging = true;
          dragStartY = clientY;
          dragCurrentDelta = 0;
          stopAutoDeck();
        }

        function moveDrag(clientY) {
          if (!isDragging) return;
          dragCurrentDelta = clientY - dragStartY;
          const activeCard = cards[activeIdx];
          if (activeCard) {
            const pos = getDeckPositions();
            const baseSlotY = pos.slotY[0];
            const currentY = baseSlotY + dragCurrentDelta;
            activeCard.style.transition = 'none';
            activeCard.style.transform = `translate3d(0, ${currentY}px, 0) scale(1.0)`;
          }
        }

        function endDrag() {
          if (!isDragging) return;
          isDragging = false;
          const activeCard = cards[activeIdx];
          if (activeCard) {
            activeCard.style.transition = TRANSITION_ON;
          }

          if (dragCurrentDelta > 60) {
            nextCard();
          } else if (dragCurrentDelta < -60) {
            prevCard();
          } else {
            renderDeck(activeIdx, true);
          }
          startAutoDeck();
        }

        // Touch Listeners
        if (stageArea) {
          stageArea.addEventListener('touchstart', (e) => startDrag(e.touches[0].clientY), { passive: true });
          stageArea.addEventListener('touchmove', (e) => moveDrag(e.touches[0].clientY), { passive: true });
          stageArea.addEventListener('touchend', endDrag, { passive: true });

          // Mouse Drag Listeners
          stageArea.addEventListener('mousedown', (e) => {
            if (e.target.closest('a') || e.target.closest('button')) return;
            startDrag(e.clientY);
          });
          window.addEventListener('mousemove', (e) => moveDrag(e.clientY));
          window.addEventListener('mouseup', endDrag);
        }

        // Klik kartu belakang untuk langsung menjadikannya aktif
        cards.forEach((card, idx) => {
          card.addEventListener('click', function (e) {
            if (e.target.closest('a')) return;
            if (idx !== activeIdx && !isTransitioning) {
              isTransitioning = true;
              renderDeck(idx);
              setTimeout(() => { isTransitioning = false; }, 550);
            }
          });
        });

        // Tombol Navigasi Panah
        if (prevBtn) prevBtn.addEventListener('click', prevCard);
        if (nextBtn) nextBtn.addEventListener('click', nextCard);

        // Tracker Rail Klik Langsung
        if (railEl) {
          railEl.addEventListener('click', function (e) {
            const rect = railEl.getBoundingClientRect();
            const clickPos = e.clientY - rect.top;
            const ratio = Math.max(0, Math.min(1, clickPos / rect.height));
            const target = Math.round(ratio * (totalCards - 1));
            renderDeck(target);
          });
        }

        // Window resize re-render
        let resizeTimer = null;
        window.addEventListener('resize', function () {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(() => {
            renderDeck(activeIdx, false);
          }, 100);
        });

        // Auto Advance halus setiap 6 detik dengan Pause on Hover
        function startAutoDeck() {
          stopAutoDeck();
          autoDeckTimer = setInterval(nextCard, 6000);
        }
        function stopAutoDeck() {
          if (autoDeckTimer) clearInterval(autoDeckTimer);
        }

        if (stageArea) {
          stageArea.addEventListener('mouseenter', stopAutoDeck);
          stageArea.addEventListener('mouseleave', startAutoDeck);
        }

        // Render Awal
        renderDeck(0, false);
        startAutoDeck();
      }
    }

    // ═══════════════════════════════════════════════
    // CONTINUOUS 3D CYLINDER HORIZON MOTION ENGINE (LAYANAN TERKAIT)
    // Transisi Berjalan Terus Menerus (Infinite Cylinder Arch)
    // ═══════════════════════════════════════════════
    const cylinderViewport = document.getElementById('uisCylinderViewport');
    const cylinderTrack = document.getElementById('uisCylinderTrack');

    if (cylinderViewport && cylinderTrack) {
      const cards = Array.from(cylinderTrack.querySelectorAll('.uis-cylinder-card'));
      const totalCards = cards.length;
      const uniqueCount = {{ $layananTerkaits->count() }};

      if (totalCards > 0) {
        const counterEl = document.getElementById('mirrorCounter');
        const titleEl = document.getElementById('mirrorActiveTitle');
        const descEl = document.getElementById('mirrorActiveDesc');
        const btnEl = document.getElementById('mirrorActiveBtn');

        let cardWidth = cards[0].offsetWidth || (window.innerWidth < 768 ? 165 : 230);
        let gap = window.innerWidth < 768 ? 14 : 22;
        let itemStep = cardWidth + gap;
        let singleCycleWidth = uniqueCount * itemStep;

        // Fisika posisi & transisi terus berjalan
        let scrollPos = 0;
        let baseSpeed = 0.85; // Kecepatan gerak kontinu otomatis
        let currentSpeed = baseSpeed;
        let targetSpeed = baseSpeed;
        let isDragging = false;
        let dragStartX = 0;
        let dragStartPos = 0;
        let lastDragX = 0;
        let dragVel = 0;
        let activeCardRef = null;

        function updateDimensions() {
          cardWidth = cards[0].offsetWidth || (window.innerWidth < 768 ? 165 : 230);
          gap = window.innerWidth < 768 ? 14 : 22;
          itemStep = cardWidth + gap;
          singleCycleWidth = uniqueCount * itemStep;
        }
        window.addEventListener('resize', updateDimensions);
        updateDimensions();

        function renderCylinder() {
          // Transisi terus berjalan tanpa henti
          if (!isDragging) {
            currentSpeed += (targetSpeed - currentSpeed) * 0.08;
            scrollPos += currentSpeed;

            if (Math.abs(dragVel) > 0.05) {
              scrollPos += dragVel;
              dragVel *= 0.92;
            }
          }

          // Loop tak berujung (seamless infinite wrap)
          if (scrollPos >= singleCycleWidth) {
            scrollPos -= singleCycleWidth;
            if (isDragging) dragStartPos -= singleCycleWidth;
          } else if (scrollPos < 0) {
            scrollPos += singleCycleWidth;
            if (isDragging) dragStartPos += singleCycleWidth;
          }

          const viewWidth = cylinderViewport.offsetWidth || window.innerWidth;
          const centerX = viewWidth / 2;
          const radius = Math.min(2400, Math.max(900, viewWidth * 1.05));
          const totalWidth = totalCards * itemStep;

          let closestCard = null;
          let minDistance = Infinity;

          for (let i = 0; i < totalCards; i++) {
            const card = cards[i];
            let cardBaseX = (i * itemStep) - scrollPos;

            // Sirkulasi posisi relatif terhadap titik tengah
            while (cardBaseX - centerX < -totalWidth / 2) cardBaseX += totalWidth;
            while (cardBaseX - centerX > totalWidth / 2) cardBaseX -= totalWidth;

            const cardCenter = cardBaseX + cardWidth / 2;
            const distFromCenter = cardCenter - centerX;
            const absDist = Math.abs(distFromCenter);

            // Proyeksi 3D Silinder (Lengkung U-Arch Horizon Cembung/Cekung)
            const angleRad = distFromCenter / radius;
            const angleDeg = angleRad * (180 / Math.PI);

            const transX = Math.sin(angleRad) * radius + centerX - cardWidth / 2;
            const transZ = -(1 - Math.cos(angleRad)) * radius * 0.95;
            const transY = Math.pow(Math.abs(angleRad), 1.8) * 32; // Lengkung busur atas dan bawah persis referensi

            const scale = Math.max(0.82, 1.0 - Math.abs(angleRad) * 0.16);
            const zIndex = Math.round(1000 - absDist);
            const maxVisibleDist = viewWidth * 0.58;
            const isVisible = absDist < maxVisibleDist;
            const opacity = isVisible ? Math.max(0, Math.min(1, (maxVisibleDist - absDist) / (viewWidth * 0.22))) : 0;

            card.style.transform = `translate3d(${transX}px, ${transY}px, ${transZ}px) rotateY(${-angleDeg * 1.1}deg) scale(${scale})`;
            card.style.zIndex = zIndex;
            card.style.opacity = isVisible ? opacity : 0;
            card.style.visibility = isVisible && opacity > 0.02 ? 'visible' : 'hidden';
            card.style.pointerEvents = isVisible && opacity > 0.5 ? 'auto' : 'none';

            if (absDist < minDistance) {
              minDistance = absDist;
              closestCard = card;
            }
          }

          // Sinkronisasi data kartu aktif di tengah
          if (closestCard && closestCard !== activeCardRef) {
            activeCardRef = closestCard;
            cards.forEach(c => c.classList.remove('is-active'));
            closestCard.classList.add('is-active');

            const name = closestCard.getAttribute('data-name');
            const desc = closestCard.getAttribute('data-desc');
            const url = closestCard.getAttribute('data-url');
            const idx = closestCard.getAttribute('data-index');
            const total = closestCard.getAttribute('data-total');

            if (counterEl && idx && total) counterEl.textContent = `${idx} / ${total}`;
            if (titleEl && name && titleEl.textContent.trim() !== name.trim()) {
              titleEl.textContent = name;
            }
            if (descEl && desc && descEl.textContent.trim() !== desc.trim()) {
              descEl.textContent = desc;
            }
            if (btnEl && url) btnEl.setAttribute('href', url);

            if (typeof spawnCenterRipple === 'function') {
              spawnCenterRipple();
            }
          }

          requestAnimationFrame(renderCylinder);
        }

        requestAnimationFrame(renderCylinder);

        // Hover: perlambat halus agar nyaman dibaca dan diklik
        cylinderViewport.addEventListener('mouseenter', () => {
          targetSpeed = 0.2;
        });
        cylinderViewport.addEventListener('mouseleave', () => {
          if (!isDragging) targetSpeed = baseSpeed;
        });

        let hasMovedSignificantly = false;

        cylinderViewport.addEventListener('pointerdown', (e) => {
          isDragging = true;
          hasMovedSignificantly = false;
          dragStartX = e.clientX;
          dragStartPos = scrollPos;
          lastDragX = e.clientX;
          dragVel = 0;
          cylinderViewport.setPointerCapture(e.pointerId);
        });

        cylinderViewport.addEventListener('pointermove', (e) => {
          if (!isDragging) return;
          const delta = e.clientX - lastDragX;
          if (Math.abs(e.clientX - dragStartX) > 6) {
            hasMovedSignificantly = true;
          }
          dragVel = -delta;
          lastDragX = e.clientX;
          scrollPos = dragStartPos - (e.clientX - dragStartX);
        });

        function endDrag() {
          if (!isDragging) return;
          isDragging = false;
          targetSpeed = baseSpeed;
        }

        cylinderViewport.addEventListener('pointerup', endDrag);
        cylinderViewport.addEventListener('pointercancel', endDrag);

        // Klik Card
        cylinderTrack.addEventListener('click', (e) => {
          if (hasMovedSignificantly) return; // Cegah trigger klik saat pengguna sedang drag / geser
          const card = e.target.closest('.uis-cylinder-card');
          if (!card) return;
          const url = card.getAttribute('data-url');

          if (card.classList.contains('is-active')) {
            if (url && url !== '#' && url.trim() !== '') {
              window.open(url, '_blank', 'noopener,noreferrer');
            }
          } else {
            // Bergulir mulus ke posisi tengah jika kartu samping diklik
            const viewWidth = cylinderViewport.offsetWidth || window.innerWidth;
            const centerX = viewWidth / 2;
            const rect = card.getBoundingClientRect();
            const vRect = cylinderViewport.getBoundingClientRect();
            const cardScreenCenter = rect.left - vRect.left + rect.width / 2;
            const diff = cardScreenCenter - centerX;
            dragVel = diff * 0.18; // Dorong inersia halus ke tengah
          }
        });
      }
    }

    // ═══════════════════════════════════════════════
    // EFEK CERMIN ELEGAN (WATER RIPPLE ON SLIDE / CLICK)
    // ═══════════════════════════════════════════════
    const waterCanvas = document.getElementById('mirrorWaterCanvas');
    let spawnCenterRipple = null;

    if (waterCanvas && cylinderViewport) {
        const ctx = waterCanvas.getContext('2d');
        let ripples = [];
        let animId = null;

        function resizeWaterCanvas() {
          waterCanvas.width = waterCanvas.offsetWidth || window.innerWidth;
          waterCanvas.height = waterCanvas.offsetHeight || 260;
        }
        resizeWaterCanvas();
        window.addEventListener('resize', resizeWaterCanvas);

        function spawnRipple(x, y, intensity = 1.0) {
          ripples.push({
            x: x,
            y: y,
            radius: 5,
            maxRadius: 100 * intensity,
            opacity: 0.6 * intensity,
            speed: 2.0,
            width: 1.8
          });
          if (!animId) {
            animId = requestAnimationFrame(animateRipples);
          }
        }

        spawnCenterRipple = function() {
          const rect = waterCanvas.getBoundingClientRect();
          spawnRipple(rect.width / 2, rect.height * 0.45, 1.2);
        };

        function animateRipples() {
          ctx.clearRect(0, 0, waterCanvas.width, waterCanvas.height);

          for (let i = ripples.length - 1; i >= 0; i--) {
            const r = ripples[i];
            r.radius += r.speed;
            r.opacity -= 0.016;

            if (r.opacity <= 0 || r.radius >= r.maxRadius) {
              ripples.splice(i, 1);
              continue;
            }

            // Lingkaran gelombang elips lembut di lantai cermin
            ctx.save();
            ctx.beginPath();
            ctx.ellipse(r.x, r.y, r.radius, r.radius * 0.3, 0, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(56, 189, 248, ${r.opacity * 0.6})`;
            ctx.lineWidth = r.width;
            ctx.stroke();

            // Cincin emas lembut
            if (r.radius > 14) {
              ctx.beginPath();
              ctx.ellipse(r.x, r.y, r.radius * 0.65, (r.radius * 0.65) * 0.3, 0, 0, Math.PI * 2);
              ctx.strokeStyle = `rgba(254, 216, 2, ${r.opacity * 0.35})`;
              ctx.lineWidth = r.width * 0.7;
              ctx.stroke();
            }
            ctx.restore();
          }

          if (ripples.length > 0) {
            animId = requestAnimationFrame(animateRipples);
          } else {
            animId = null;
          }
        }

        waterCanvas.addEventListener('click', function(e) {
          const rect = waterCanvas.getBoundingClientRect();
          spawnRipple(e.clientX - rect.left, Math.max(20, Math.min(e.clientY - rect.top, rect.height - 20)), 1.2);
        });
      }
  });
</script>
@endpush
