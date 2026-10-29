@extends('layouts.frontend.template')

@section('title', 'SOP (Standar Operasional Prosedur) — Teknik Informatika')
@section('meta_description', 'Pusat dokumen Standar Operasional Prosedur (SOP) dan panduan teknis Program Studi Teknik Informatika.')
@section('meta_keywords', 'sop teknik informatika, standar operasional prosedur, sop skripsi, sop kp, sop perkuliahan')

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
<section class="akademik-hero">
  <div class="container position-relative" data-aos="fade-up">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange, #f9dc4b); color: #000000; font-weight: 800; font-size: 11.5px; letter-spacing: 0.8px;">
      PROGRAM STUDI TEKNIK INFORMATIKA · FAKULTAS SAINS DAN TEKNOLOGI
    </div>
    <h1 class="display-6 fw-bold text-white mb-2">SOP (Standar Operasional Prosedur)</h1>
    <p class="lead text-white-50 mb-0" style="max-width: 760px; font-size: 16px;">
      Pusat dokumen Standar Operasional Prosedur (SOP) dan panduan alur teknis Program Studi Teknik Informatika.
    </p>
    <div class="breadcrumb-custom mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span>Portal Layanan</span>
      <span>/</span>
      <span class="active">SOP</span>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" style="background-color: #f8fafc; min-height: 70vh;">
  <div class="container py-3">
    <div class="row justify-content-center">
      <div class="col-12" data-aos="fade-up">
        
        <div class="sop-card">
          <div class="table-responsive">
            <table id="sopTable" class="table table-bordered align-middle w-100 mb-0">
              <thead>
                <tr>
                  <th style="width: 8%; text-align: center;">No</th>
                  <th style="width: 68%;">Nama Document</th>
                  <th style="width: 24%; text-align: center;">Link Document</th>
                </tr>
              </thead>
              <tbody>
                @forelse($templates as $index => $item)
                  <tr>
                    <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                    <td class="fw-semibold text-dark">
                      {{ $item->judul }}
                    </td>
                    <td class="text-center">
                      @php
                        $targetUrl = $item->link_drive;
                        $hasLink = !empty($targetUrl) && $targetUrl !== '#';
                      @endphp
                      @if($hasLink)
                        <a href="{{ $targetUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-document-link"
                           title="Buka Dokumen {{ $item->judul }}">
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
                      <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                      Belum ada berkas SOP yang tersedia saat ini.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<!-- DataTables CSS Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
  /* Container Card */
  .sop-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 28px 24px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    border: 1px solid #e2e8f0;
  }

  /* Table Style matching User Screenshot & E-Dokumen */
  #sopTable {
    border-collapse: collapse !important;
    border: 1px solid #0b1626 !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  #sopTable thead th {
    background-color: #0b1626 !important;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 15px;
    padding: 14px 18px;
    border: 1px solid #1a2a40 !important;
    letter-spacing: 0.2px;
    vertical-align: middle;
  }

  #sopTable tbody td {
    padding: 14px 18px;
    font-size: 14.5px;
    border: 1px solid #e2e8f0 !important;
    background-color: #ffffff;
  }

  #sopTable tbody tr:hover td {
    background-color: #f8fafc;
  }

  /* Link Document Button Pill Style */
  .btn-document-link {
    background-color: #0b1626;
    color: #ffffff !important;
    font-size: 13.5px;
    font-weight: 700;
    padding: 7px 22px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
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

  /* DataTables Controls Layout */
  .dataTables_wrapper .dataTables_length,
  .dataTables_wrapper .dataTables_filter {
    margin-bottom: 18px;
    font-size: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .dataTables_wrapper .dataTables_length select {
    padding: 5px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 13.5px;
    margin: 0 6px;
    background-color: #ffffff;
    cursor: pointer;
  }

  .dataTables_wrapper .dataTables_filter input {
    padding: 6px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 13.5px;
    margin-left: 8px;
    width: 220px;
    background-color: #ffffff;
    outline: none;
  }

  .dataTables_wrapper .dataTables_filter input:focus {
    border-color: #0b1626;
    box-shadow: 0 0 0 3px rgba(11, 22, 38, 0.12);
  }

  .dataTables_wrapper .dataTables_info,
  .dataTables_wrapper .dataTables_paginate {
    margin-top: 18px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .dataTables_wrapper .dataTables_paginate .pagination {
    margin-bottom: 0;
  }

  .dataTables_wrapper .dataTables_paginate .page-item .page-link {
    color: #0b1626;
    border: 1px solid #cbd5e1;
    padding: 5px 12px;
    border-radius: 4px;
    margin: 0 2px;
  }

  .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
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
    $('#sopTable').DataTable({
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
  });
</script>
@endpush
