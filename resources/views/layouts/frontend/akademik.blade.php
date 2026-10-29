@extends('layouts.frontend.template')

@section('title', $item->judul . ' — Teknik Informatika')
@section('meta_description', Str::limit(strip_tags($item->subjudul ?? $item->deskripsi), 160))

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
<section class="akademik-hero">
  <div class="container position-relative" data-aos="fade-up">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange); color: #000000; font-weight: 800; font-size: 11.5px; letter-spacing: 0.8px;">
      PROGRAM STUDI TEKNIK INFORMATIKA · FAKULTAS SAINS DAN TEKNOLOGI
    </div>
    <h1 class="display-6 fw-bold text-white mb-2">{{ $item->judul }}</h1>
    @if($item->subjudul)
      <p class="lead text-white-50 mb-0" style="max-width: 760px; font-size: 16px;">
        {{ $item->subjudul }}
      </p>
    @endif
    <div class="breadcrumb-custom mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">{{ $pageTitle }}</span>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">
    <div class="row g-4">
      
      {{-- Kolom Konten Utama (Full Width) --}}
      <div class="col-12" data-aos="fade-up">
        @if(isset($kalenderItems) && $kalenderItems->count() > 0)
          {{-- Accordion Daftar Kalender Akademik per Tahun (Link Google Drive) --}}
          <div class="kalender-accordion-list">
            @foreach($kalenderItems as $idx => $kItem)
              @php $isOpen = ($idx === 0); @endphp
              <div class="kalender-acc-item {{ $isOpen ? 'active' : '' }}">
                <button type="button"
                        class="kalender-acc-header"
                        onclick="toggleKalenderAcc(this)"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                  <span class="kalender-acc-left">
                    <i class="bi {{ $isOpen ? 'bi-dash-lg' : 'bi-plus-lg' }} kalender-acc-sign"></i>
                    <span class="kalender-acc-title">{{ $kItem->judul_tab }}</span>
                  </span>
                  <i class="bi {{ $isOpen ? 'bi-chevron-down' : 'bi-chevron-right' }} kalender-acc-chevron"></i>
                </button>
                <div class="kalender-acc-body" style="{{ $isOpen ? 'display: block;' : 'display: none;' }}">
                  <div class="kalender-acc-content">
                    <a href="{{ $kItem->gdrive_url ?: '#' }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="kalender-doc-title">
                      {{ $kItem->nama_dokumen }}
                    </a>
                    @if(!empty($kItem->gdrive_url))
                      <a href="{{ $kItem->gdrive_url }}"
                         target="_blank"
                         rel="noopener noreferrer"
                         class="kalender-doc-btn">
                        {{ $kItem->tombol_teks ?: 'Lihat Document' }}
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @elseif(isset($akreditasiItems))
          {{-- Tab Navigasi & Tabel Dokumen Akreditasi --}}
          <div class="akreditasi-box">
            <ul class="nav nav-tabs akreditasi-nav-tabs" id="akreditasiTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="instrumen-tab" data-bs-toggle="tab" data-bs-target="#instrumen-pane" type="button" role="tab" aria-controls="instrumen-pane" aria-selected="true">
                  Instrumen Akreditasi
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="kelengkapan-tab" data-bs-toggle="tab" data-bs-target="#kelengkapan-pane" type="button" role="tab" aria-controls="kelengkapan-pane" aria-selected="false">
                  Kelengkapan Dokumen Teknik Informatika
                </button>
              </li>
            </ul>

            <div class="tab-content akreditasi-tab-card" id="akreditasiTabContent">
              {{-- PANE 1: Instrumen Akreditasi --}}
              <div class="tab-pane fade show active" id="instrumen-pane" role="tabpanel" aria-labelledby="instrumen-tab" tabindex="0">
                <div class="akreditasi-search-wrapper mb-3">
                  <input type="text" id="searchInstrumen" class="form-control quick-search-input" placeholder="Cari dokumen...">
                </div>

                <div class="table-responsive">
                  <table class="akreditasi-table" id="instrumenTable">
                    <thead>
                      <tr>
                        <th style="width: 8%; text-align: center;">No</th>
                        <th style="width: 68%;">Nama Dokumen</th>
                        <th style="width: 24%; text-align: center;">Link Document</th>
                        <th style="display: none;">Grup</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $instrumenDocs = $akreditasiItems->where('kategori_tab', 'instrumen')->sortBy('urutan');
                        $counter = 1;
                      @endphp
                      @forelse($instrumenDocs as $doc)
                        <tr>
                          <td class="text-center fw-semibold text-muted">{{ $counter++ }}</td>
                          <td class="fw-semibold text-dark">{{ $doc->nama_dokumen }}</td>
                          <td class="text-center">
                            @if(!empty($doc->gdrive_url))
                              <a href="{{ $doc->gdrive_url }}" target="_blank" rel="noopener noreferrer" class="btn-document-link" title="Buka Dokumen {{ $doc->nama_dokumen }}">
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>Document</span>
                              </a>
                            @else
                              <span class="btn-document-link disabled" style="opacity: 0.6; cursor: not-allowed;">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Document</span>
                              </span>
                            @endif
                          </td>
                          <td style="display: none;">{{ $doc->grup ?? '' }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center py-4 text-muted">
                            Belum ada dokumen instrumen akreditasi.
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>

              {{-- PANE 2: Kelengkapan Dokumen --}}
              <div class="tab-pane fade" id="kelengkapan-pane" role="tabpanel" aria-labelledby="kelengkapan-tab" tabindex="0">
                <div class="akreditasi-search-wrapper mb-3">
                  <input type="text" id="searchKelengkapan" class="form-control quick-search-input" placeholder="Cari dokumen...">
                </div>

                <div class="table-responsive">
                  <table class="akreditasi-table" id="kelengkapanTable">
                    <thead>
                      <tr>
                        <th style="width: 8%; text-align: center;">No</th>
                        <th style="width: 68%;">Nama Document</th>
                        <th style="width: 24%; text-align: center;">Link Document</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $kelengkapanDocs = $akreditasiItems->where('kategori_tab', 'kelengkapan')->sortBy('urutan');
                      @endphp
                      @forelse($kelengkapanDocs as $doc)
                        <tr>
                          <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                          <td class="fw-semibold text-dark">{{ $doc->nama_dokumen }}</td>
                          <td class="text-center">
                            @if(!empty($doc->gdrive_url))
                              <a href="{{ $doc->gdrive_url }}" target="_blank" rel="noopener noreferrer" class="btn-document-link" title="Buka Dokumen {{ $doc->nama_dokumen }}">
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>Document</span>
                              </a>
                            @else
                              <span class="btn-document-link disabled" style="opacity: 0.6; cursor: not-allowed;">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Document</span>
                              </span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="3" class="text-center py-4 text-muted">
                            Belum ada kelengkapan dokumen.
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="akademik-card">
            
            {{-- Banner Gambar jika ada --}}
            @if($item->gambar)
              <div class="mb-4 rounded-4 overflow-hidden shadow-sm">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-100 img-fluid" style="max-height: 420px; object-fit: cover;">
              </div>
            @endif

            {{-- Dokumen Unduhan (PDF dll) --}}
            @if($item->file_dokumen)
              <div class="doc-download-box d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="p-3 rounded-circle bg-white shadow-sm text-danger fs-3">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                  </div>
                  <div>
                    <h6 class="fw-bold text-dark mb-1">{{ $item->file_nama ?: 'Dokumen ' . $pageTitle }}</h6>
                    <div class="small text-muted">Klik tombol di samping untuk mengunduh dokumen resmi (PDF).</div>
                  </div>
                </div>
                <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 22px; white-space: nowrap;">
                  <i class="bi bi-download"></i> Unduh File PDF
                </a>
              </div>
            @endif

            {{-- Portal Link Eksternal (SIAKAD dll) --}}
            @if(!empty($item->link_url))
              <div class="p-4 rounded-4 mb-4 text-white d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3" style="background: #000000; border: 1px solid #000000;">
                <div>
                  <h5 class="fw-bold text-white mb-1"><i class="bi bi-laptop me-2" style="color: #f9dc4b;"></i>Akses Langsung Sistem Online</h5>
                  <p class="text-white-50 small mb-0">Klik tombol untuk masuk ke portal sistem resmi Teknik Informatika.</p>
                </div>
                <a href="{{ $item->link_url }}" target="_blank" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 24px; white-space: nowrap;">
                  Buka Portal <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
              </div>
            @endif

            {{-- Isi Teks Deskripsi --}}
            @if(!empty(trim(strip_tags($item->deskripsi ?? ''))))
            <div class="article-content" style="font-size: 15.5px; line-height: 1.8; color: #2d3748;">
              {!! $item->deskripsi !!}
            </div>
            @endif

          </div>
        @endif
      </div>

    </div>
  </div>
</section>

@if(isset($kalenderItems) && $kalenderItems->count() > 0)
@push('styles')
<style>
  .kalender-accordion-list {
    border: 1px solid #e5e7eb;
    background: #ffffff;
  }
  .kalender-acc-item {
    border-bottom: 1px solid #e5e7eb;
  }
  .kalender-acc-item:last-child {
    border-bottom: none;
  }
  .kalender-acc-header {
    width: 100%;
    border: none;
    background: #f1f1f1;
    color: #333333;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-align: left;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
  }
  .kalender-acc-header:hover {
    background: #e5e7eb;
  }
  .kalender-acc-item.active .kalender-acc-header {
    background: #0d1522;
    color: #ffffff;
  }
  .kalender-acc-left {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .kalender-acc-sign {
    font-size: 16px;
    font-weight: 800;
    line-height: 1;
  }
  .kalender-acc-chevron {
    font-size: 13px;
  }
  .kalender-acc-body {
    background: #ffffff;
    padding: 24px 22px;
  }
  .kalender-acc-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }
  .kalender-doc-title {
    font-size: 13.5px;
    font-weight: 500;
    color: #243b53;
    text-decoration: none;
    letter-spacing: 0.2px;
  }
  .kalender-doc-title:hover {
    color: #000000;
    text-decoration: underline;
  }
  .kalender-doc-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #2f4f1d;
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 600;
    padding: 9px 24px;
    border-radius: 50px;
    text-decoration: none !important;
    transition: opacity 0.2s ease, transform 0.15s ease;
  }
  .kalender-doc-btn:hover {
    opacity: 0.92;
    transform: translateY(-1px);
  }
</style>
@endpush

<script>
  function toggleKalenderAcc(button) {
    const currentItem = button.closest('.kalender-acc-item');
    const list = button.closest('.kalender-accordion-list');
    const isAlreadyOpen = currentItem.classList.contains('active');

    list.querySelectorAll('.kalender-acc-item').forEach(function (item) {
      item.classList.remove('active');
      const header = item.querySelector('.kalender-acc-header');
      const body = item.querySelector('.kalender-acc-body');
      const sign = item.querySelector('.kalender-acc-sign');
      const chevron = item.querySelector('.kalender-acc-chevron');

      if (header) header.setAttribute('aria-expanded', 'false');
      if (body) body.style.display = 'none';
      if (sign) {
        sign.classList.remove('bi-dash-lg');
        sign.classList.add('bi-plus-lg');
      }
      if (chevron) {
        chevron.classList.remove('bi-chevron-down');
        chevron.classList.add('bi-chevron-right');
      }
    });

    if (!isAlreadyOpen) {
      currentItem.classList.add('active');
      button.setAttribute('aria-expanded', 'true');
      const body = currentItem.querySelector('.kalender-acc-body');
      const sign = currentItem.querySelector('.kalender-acc-sign');
      const chevron = currentItem.querySelector('.kalender-acc-chevron');

      if (body) body.style.display = 'block';
      if (sign) {
        sign.classList.remove('bi-plus-lg');
        sign.classList.add('bi-dash-lg');
      }
      if (chevron) {
        chevron.classList.remove('bi-chevron-right');
        chevron.classList.add('bi-chevron-down');
      }
    }
  }
</script>
@endif

@if(isset($akreditasiItems))
@push('styles')
<!-- DataTables CSS Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
  /* Akreditasi Tabs Layout */
  .akreditasi-box {
    margin-top: 10px;
  }
  .akreditasi-nav-tabs {
    border-bottom: 1px solid #dcdcdc !important;
    gap: 4px;
    margin-bottom: 0;
  }
  .akreditasi-nav-tabs .nav-link {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14.5px;
    font-weight: 700;
    color: #8c7528 !important;
    background: transparent;
    border: 1px solid transparent;
    border-bottom: none;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    padding: 12px 22px;
    margin-bottom: -1px;
    transition: all 0.2s ease;
  }
  .akreditasi-nav-tabs .nav-link:hover {
    color: #0b1626 !important;
  }
  .akreditasi-nav-tabs .nav-link.active {
    color: #0b1626 !important;
    background-color: #ffffff !important;
    border-color: #dcdcdc #dcdcdc #ffffff #dcdcdc !important;
    border-width: 1px 1px 1px 1px !important;
    border-style: solid !important;
  }
  .akreditasi-tab-card {
    background: #ffffff;
    border: 1px solid #dcdcdc;
    border-top: none;
    border-radius: 0 0 8px 8px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
  }

  /* Quick search input */
  .quick-search-input {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 8px 14px;
    font-size: 13.5px;
    color: #334155;
    font-family: 'Plus Jakarta Sans', sans-serif;
    width: 230px;
    max-width: 100%;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .quick-search-input::placeholder {
    color: #94a3b8;
  }
  .quick-search-input:focus {
    background-color: #ffffff;
    border-color: #0b1626;
    box-shadow: 0 0 0 3px rgba(11, 22, 38, 0.1);
  }

  /* Akreditasi Table */
  .akreditasi-table {
    border-collapse: collapse !important;
    border: 1px solid #0b1626 !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
    width: 100%;
  }
  .akreditasi-table thead th {
    background-color: #0b1626 !important;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 14.5px;
    padding: 13px 18px;
    border: 1px solid #1a2a40 !important;
    letter-spacing: 0.2px;
    vertical-align: middle;
  }
  .akreditasi-table tbody td {
    padding: 14px 18px;
    font-size: 14px;
    border: 1px solid #e2e8f0 !important;
    background-color: #ffffff;
    vertical-align: middle;
  }
  .akreditasi-table tbody tr:hover td {
    background-color: #f8fafc;
  }
  .akreditasi-table tbody tr.table-group-header td {
    background-color: #ffffff !important;
    color: #1e293b;
    font-weight: 600;
    font-size: 13.5px;
    padding: 12px 18px;
    border: 1px solid #e2e8f0 !important;
  }

  /* Link Document Button Pill */
  .btn-document-link {
    background-color: #0b1626;
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 700;
    padding: 7px 22px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease-in-out;
    border: 1px solid #0b1626;
    box-shadow: 0 2px 6px rgba(11, 22, 38, 0.2);
  }
  .btn-document-link:hover {
    background-color: #1a2a40;
    color: #f9dc4b !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(11, 22, 38, 0.28);
  }

  /* DataTables layout in both tabs */
  .akreditasi-tab-card .dataTables_wrapper .dataTables_length,
  .akreditasi-tab-card .dataTables_wrapper .dataTables_filter {
    margin-bottom: 16px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_length select {
    padding: 4px 10px;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    font-size: 13px;
    margin: 0 4px;
    background-color: #ffffff;
    cursor: pointer;
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_filter input {
    padding: 5px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    font-size: 13px;
    margin-left: 6px;
    width: 200px;
    background-color: #ffffff;
    outline: none;
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_filter input:focus {
    border-color: #0b1626;
    box-shadow: 0 0 0 3px rgba(11, 22, 38, 0.1);
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_info,
  .akreditasi-tab-card .dataTables_wrapper .dataTables_paginate {
    margin-top: 16px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_paginate .pagination {
    margin-bottom: 0;
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_paginate .page-item .page-link {
    color: #0b1626;
    border: 1px solid #cbd5e1;
    padding: 4px 10px;
    border-radius: 4px;
    margin: 0 2px;
  }
  .akreditasi-tab-card .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
    background-color: #0b1626;
    border-color: #0b1626;
    color: #ffffff;
  }
</style>
@endpush

@push('scripts')
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
    // DataTables for Tab 1 (Instrumen Akreditasi) with Group Headers
    var instrumenTable = $('#instrumenTable').DataTable({
      pageLength: 10,
      responsive: true,
      ordering: false,
      columnDefs: [
        { targets: 0, className: 'text-center fw-semibold text-muted' },
        { targets: 1, className: 'fw-semibold text-dark' },
        { targets: 2, className: 'text-center', orderable: false, searchable: false },
        { targets: 3, visible: false, searchable: true }
      ],
      drawCallback: function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;

        api.column(3, { page: 'current' }).data().each(function (group, i) {
          if (group && last !== group) {
            $(rows).eq(i).before(
              '<tr class="table-group-header"><td colspan="3" class="fw-semibold text-dark">' + group + '</td></tr>'
            );
            last = group;
          }
        });
      },
      language: {
        lengthMenu: "_MENU_ entries per page",
        search: "Search:",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        zeroRecords: "Tidak ada dokumen yang sesuai dengan pencarian",
        paginate: {
          previous: "&lsaquo;",
          next: "&rsaquo;"
        }
      }
    });

    // Quick search for Tab 1 synchronizes with DataTables search
    $('#searchInstrumen').on('keyup', function() {
      instrumenTable.search(this.value).draw();
    });

    // DataTables for Tab 2 (Kelengkapan)
    var kelengkapanTable = $('#kelengkapanTable').DataTable({
      pageLength: 10,
      responsive: true,
      ordering: true,
      order: [[0, 'asc']],
      columnDefs: [
        { targets: 0, className: 'text-center fw-semibold text-muted' },
        { targets: 1, className: 'fw-semibold text-dark' },
        { targets: 2, className: 'text-center', orderable: false, searchable: false }
      ],
      language: {
        lengthMenu: "_MENU_ entries per page",
        search: "Search:",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        zeroRecords: "Tidak ada dokumen yang sesuai dengan pencarian",
        paginate: {
          previous: "&lsaquo;",
          next: "&rsaquo;"
        }
      }
    });

    // Quick search for Tab 2 synchronizes with DataTables search
    $('#searchKelengkapan').on('keyup', function() {
      kelengkapanTable.search(this.value).draw();
    });

    // Auto-adjust DataTable columns when tab is shown
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      instrumenTable.columns.adjust().draw();
      kelengkapanTable.columns.adjust().draw();
    });
  });
</script>
@endpush
@endif
@endsection
