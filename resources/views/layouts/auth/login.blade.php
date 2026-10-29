<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Autentikasi — Teknik Informatika UIS</title>
  <meta name="description" content="Portal Akses Sistem Terpadu Program Studi Teknik Informatika, Fakultas Sains dan Teknologi — Universitas Ibnu Sina Batam.">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('frontend/img/logouis.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/img/logouis.png') }}">

  <!-- Google Fonts: Plus Jakarta Sans & Fira Code (Informatics Developer Font) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* ═══════════════════════════════════════════════════════════
       PALET RESMI TEKNIK INFORMATIKA:
       - Kuning: #f9dc4b
       - Hitam:  #000000
       - Putih:  #ffffff
    ═══════════════════════════════════════════════════════════ */
    :root {
      --ti-black:           #000000;
      --ti-black-surface:   #060606;
      --ti-black-card:      rgba(10, 10, 10, 0.94);
      --ti-black-input:     #040404;

      --ti-yellow:          #f9dc4b;
      --ti-yellow-hover:    #ffe359;
      --ti-yellow-glow:     rgba(249, 220, 75, 0.45);
      --ti-yellow-subtle:   rgba(249, 220, 75, 0.12);
      --ti-yellow-border:   rgba(249, 220, 75, 0.35);

      --ti-white:           #ffffff;
      --ti-white-muted:     #e2e8f0;
      --ti-white-dim:       #94a3b8;
      --ti-border-dim:      rgba(255, 255, 255, 0.12);

      --font-sans:          'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      --font-mono:          'Fira Code', monospace, Consolas;
    }

    html, body {
      height: 100vh;
      width: 100vw;
      margin: 0;
      padding: 0;
      overflow: hidden;
      font-family: var(--font-sans);
      background-color: var(--ti-black);
      color: var(--ti-white);
      -webkit-font-smoothing: antialiased;
    }

    /* ═══════════════════════════════════════════════════════════
       INTERACTIVE CYBER CANVAS & MATRIX GRID
    ═══════════════════════════════════════════════════════════ */
    #cyberCanvas {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      pointer-events: none;
    }

    /* Matrix Digital Grid Lines (Kuning & Putih Halus) */
    .cyber-grid-overlay {
      position: absolute;
      inset: 0;
      background-image: 
        linear-gradient(to right, rgba(249, 220, 75, 0.04) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(249, 220, 75, 0.04) 1px, transparent 1px);
      background-size: 40px 40px;
      z-index: 2;
      pointer-events: none;
    }

    /* Ambient Yellow Glow Orbs */
    .glow-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(100px);
      pointer-events: none;
      z-index: 2;
      opacity: 0.32;
      animation: pulseOrb 8s infinite alternate ease-in-out;
    }
    .glow-orb-1 {
      width: 480px;
      height: 480px;
      background: radial-gradient(circle, rgba(249, 220, 75, 0.28) 0%, transparent 70%);
      top: -120px;
      left: 10%;
    }
    .glow-orb-2 {
      width: 520px;
      height: 520px;
      background: radial-gradient(circle, rgba(249, 220, 75, 0.22) 0%, transparent 70%);
      bottom: -150px;
      right: 15%;
      animation-delay: -4s;
    }
    .glow-orb-3 {
      width: 320px;
      height: 320px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
      top: 40%;
      right: 40%;
      animation-delay: -2s;
    }

    @keyframes pulseOrb {
      0% { transform: scale(0.9) translate(0, 0); opacity: 0.25; }
      100% { transform: scale(1.15) translate(20px, -15px); opacity: 0.45; }
    }

    /* ═══════════════════════════════════════════════════════════
       MAIN SPLIT CONTAINER
    ═══════════════════════════════════════════════════════════ */
    .auth-container {
      display: flex;
      height: 100vh;
      max-height: 100vh;
      width: 100vw;
      position: relative;
      z-index: 3;
      overflow: hidden;
    }

    /* ── LEFT SHOWCASE PANEL (COMMAND CENTER TEKNIK INFORMATIKA) ── */
    .showcase-panel {
      flex: 1.15;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 36px 48px;
      overflow: hidden;
      border-right: 1.5px solid var(--ti-yellow-border);
      background-color: var(--ti-black);
    }

    /* Campus Backdrop - Terlihat Jelas & Alami */
    .showcase-bg-image {
      position: absolute;
      inset: 0;
      background-image: url("{{ asset('frontend/img/gedung-uis.jpg') }}");
      background-size: cover;
      background-position: center bottom;
      opacity: 0.95;
      filter: contrast(1.06) brightness(1.02);
      transform: scale(1.02);
      transition: transform 12s ease;
      z-index: 1;
    }
    .auth-container:hover .showcase-bg-image {
      transform: scale(1.06);
    }

    /* Gradient Scrim Halus untuk Menjamin Keterbacaan Teks */
    .showcase-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.62) 0%,
        rgba(0, 0, 0, 0.12) 30%,
        rgba(0, 0, 0, 0.12) 70%,
        rgba(0, 0, 0, 0.72) 100%
      );
      z-index: 2;
      pointer-events: none;
    }

    /* Cyber Scanline Halus */
    .showcase-scanline {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        to bottom,
        transparent 50%,
        rgba(0, 0, 0, 0.25) 51%
      );
      background-size: 100% 4px;
      z-index: 3;
      pointer-events: none;
      opacity: 0.4;
    }

    .showcase-content {
      position: relative;
      z-index: 4;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Brand Header */
    .showcase-brand-header {
      display: flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      align-self: flex-start;
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(14px);
      border: 1.5px solid var(--ti-yellow-border);
      padding: 9px 20px;
      border-radius: 100px;
      box-shadow: 0 0 24px rgba(249, 220, 75, 0.15);
      transition: all 0.3s ease;
    }
    .showcase-brand-header:hover {
      border-color: var(--ti-yellow);
      box-shadow: 0 0 32px var(--ti-yellow-glow);
      transform: translateY(-2px);
    }
    .showcase-logo-box {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      filter: drop-shadow(0 0 8px rgba(249, 220, 75, 0.5));
    }
    .showcase-logo-box img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .showcase-brand-info h2 {
      font-size: 15px;
      font-weight: 800;
      color: var(--ti-white);
      line-height: 1.15;
      letter-spacing: -0.2px;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .showcase-brand-info h2 .core-badge {
      font-family: var(--font-mono);
      font-size: 9px;
      font-weight: 700;
      background: var(--ti-yellow);
      color: var(--ti-black);
      border: 1px solid var(--ti-yellow);
      padding: 1px 6px;
      border-radius: 4px;
      letter-spacing: 0.5px;
    }
    .showcase-brand-info span {
      font-size: 11.5px;
      color: var(--ti-yellow);
      font-weight: 600;
    }

    /* ── Terminal HUD Box ── */
    .terminal-hud-box {
      margin: auto 0;
      max-width: 540px;
      background: rgba(0, 0, 0, 0.90);
      border: 1.5px solid var(--ti-yellow);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.85), 0 0 35px rgba(249, 220, 75, 0.22);
      backdrop-filter: blur(20px);
      position: relative;
    }
    .terminal-hud-header {
      background: #000000;
      padding: 10px 16px;
      border-bottom: 1px solid var(--ti-yellow-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .terminal-dots {
      display: flex;
      gap: 6px;
    }
    .terminal-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
    }
    .terminal-dot-1 { background: #ef4444; box-shadow: 0 0 6px #ef4444; }
    .terminal-dot-2 { background: var(--ti-yellow); box-shadow: 0 0 6px var(--ti-yellow); }
    .terminal-dot-3 { background: var(--ti-white); box-shadow: 0 0 6px var(--ti-white); }

    .terminal-title {
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--ti-white-muted);
      letter-spacing: 0.4px;
    }
    .terminal-status-chip {
      font-family: var(--font-mono);
      font-size: 10px;
      color: var(--ti-yellow);
      display: flex;
      align-items: center;
      gap: 5px;
      font-weight: 700;
      background: var(--ti-yellow-subtle);
      border: 1px solid var(--ti-yellow-border);
      padding: 2px 8px;
      border-radius: 20px;
    }
    .terminal-status-chip .pulse-dot {
      width: 6px;
      height: 6px;
      background: var(--ti-yellow);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--ti-yellow);
      animation: blink 1.2s infinite;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    .terminal-hud-body {
      padding: 16px 20px;
      font-family: var(--font-mono);
      font-size: 12px;
      line-height: 1.6;
      color: var(--ti-white-muted);
    }

    /* ── Terminal Stream Console (Tempat Mengetik & Content Berjalan) ── */
    .terminal-stream-console {
      height: 125px;
      min-height: 125px;
      max-height: 125px;
      overflow-y: hidden;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      position: relative;
      scroll-behavior: smooth;
    }

    .terminal-line {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      margin-bottom: 5px;
      font-family: var(--font-mono);
      font-size: 11.5px;
      line-height: 1.45;
      white-space: pre-wrap;
      word-break: break-word;
      animation: lineFadeIn 0.25s ease-out;
    }

    @keyframes lineFadeIn {
      from { opacity: 0; transform: translateY(4px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .terminal-prompt {
      color: var(--ti-yellow);
      font-weight: 700;
      flex-shrink: 0;
    }
    .terminal-text-yellow { color: var(--ti-yellow); font-weight: 600; }
    .terminal-text-white  { color: var(--ti-white); font-weight: 600; }

    .terminal-cursor {
      display: inline-block;
      width: 8px;
      height: 13px;
      background: var(--ti-yellow);
      margin-left: 4px;
      vertical-align: middle;
      animation: blink 0.8s infinite;
      box-shadow: 0 0 6px var(--ti-yellow-glow);
    }

    /* Core Pillars Tags (Content Berjalan / Active Radar Scan) */
    .tech-pillars-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 14px;
      padding-top: 14px;
      border-top: 1px dashed rgba(249, 220, 75, 0.2);
    }
    .tech-pillar-card {
      background: rgba(0, 0, 0, 0.75);
      border: 1px solid var(--ti-yellow-border);
      border-radius: 10px;
      padding: 9px 12px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
    }
    .tech-pillar-card:hover,
    .tech-pillar-card.active-scan {
      background: #000000;
      border-color: var(--ti-yellow);
      transform: translateY(-2px);
      box-shadow: 0 4px 18px rgba(249, 220, 75, 0.28);
    }
    .tech-pillar-card.active-scan .tech-pillar-icon {
      background: var(--ti-yellow) !important;
      color: #000000 !important;
      box-shadow: 0 0 12px var(--ti-yellow-glow);
    }
    .tech-pillar-card.active-scan .tech-pillar-title {
      color: var(--ti-yellow) !important;
    }

    .tech-pillar-icon {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: var(--ti-yellow-subtle);
      color: var(--ti-yellow);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      flex-shrink: 0;
      transition: all 0.3s ease;
    }
    .tech-pillar-title {
      font-size: 11px;
      font-weight: 700;
      color: var(--ti-white);
      line-height: 1.25;
      transition: color 0.3s ease;
    }
    .tech-pillar-desc {
      font-size: 9.5px;
      color: var(--ti-white-dim);
      font-family: var(--font-mono);
    }

    /* Bottom Telemetry Bar */
    .showcase-telemetry {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid var(--ti-yellow-border);
      padding-top: 16px;
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--ti-white-dim);
    }
    .telemetry-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .telemetry-item i {
      color: var(--ti-yellow);
    }
    .telemetry-val {
      color: var(--ti-white);
      font-weight: 600;
    }

    /* ── RIGHT AUTH PANEL (PURE BLACK + CYBER NODE NETWORK) ── */
    .auth-panel {
      flex: 0.92;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
      padding: 24px 38px;
      height: 100vh;
      max-height: 100vh;
      overflow-y: auto;
      position: relative;
      background-color: #000000;
      background-image: none;
    }

    /* Dedicated Node Network Canvas */
    #authNetworkCanvas {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      pointer-events: none;
    }

    .auth-panel::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 50% 50%, rgba(249, 220, 75, 0.04) 0%, transparent 70%);
      pointer-events: none;
      z-index: 1;
    }

    .auth-topbar,
    .auth-card-wrapper,
    .auth-bottom-info {
      position: relative;
      z-index: 2;
    }

    /* Topbar Navigation */
    .auth-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      max-width: 440px;
      margin-bottom: 12px;
    }
    .btn-back-home {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      font-size: 12px;
      font-weight: 600;
      color: var(--ti-white);
      text-decoration: none;
      padding: 6px 14px;
      border-radius: 8px;
      border: 1px solid var(--ti-yellow-border);
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(10px);
      transition: all 0.25s ease;
    }
    .btn-back-home:hover {
      color: var(--ti-black);
      background: var(--ti-yellow);
      border-color: var(--ti-yellow);
      box-shadow: 0 0 16px var(--ti-yellow-glow);
      transform: translateX(-3px);
    }
    .auth-badge-live {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--ti-yellow);
      font-weight: 700;
      background: var(--ti-yellow-subtle);
      padding: 5px 12px;
      border-radius: 20px;
      border: 1px solid var(--ti-yellow-border);
      letter-spacing: 0.3px;
    }
    .auth-badge-live .radar-dot {
      width: 6px;
      height: 6px;
      background: var(--ti-yellow);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--ti-yellow);
      animation: blink 1.2s infinite;
    }

    /* Center Form Card */
    .auth-card-wrapper {
      width: 100%;
      max-width: 440px;
      margin: auto 0;
    }

    .cyber-auth-card {
      background: rgba(0, 0, 0, 0.92);
      border-radius: 20px;
      padding: 28px 32px;
      border: 1.5px solid var(--ti-yellow);
      box-shadow: 
        0 20px 50px rgba(0, 0, 0, 0.9),
        0 0 35px rgba(249, 220, 75, 0.22),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(24px);
      position: relative;
      overflow: hidden;
    }

    /* Top Accent Line: Solid Kuning #f9dc4b */
    .cyber-auth-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3.5px;
      background: var(--ti-yellow);
      box-shadow: 0 0 12px var(--ti-yellow-glow);
    }

    /* Card Header */
    .auth-header {
      margin-bottom: 20px;
    }
    .auth-badge-top {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--ti-yellow-subtle);
      color: var(--ti-yellow);
      font-size: 10px;
      font-weight: 700;
      font-family: var(--font-mono);
      padding: 3px 10px;
      border-radius: 6px;
      margin-bottom: 8px;
      border: 1px solid var(--ti-yellow-border);
      letter-spacing: 0.6px;
    }
    .auth-header h2 {
      font-size: 23px;
      font-weight: 800;
      color: var(--ti-white);
      letter-spacing: -0.5px;
      margin-bottom: 5px;
    }
    .auth-header p {
      font-size: 12.5px;
      color: var(--ti-white-dim);
      line-height: 1.45;
    }

    /* Modern Alert Boxes */
    .alert-modern {
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 12px;
      font-weight: 500;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 16px;
      line-height: 1.4;
    }
    .alert-modern-err {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.4);
      color: #fca5a5;
    }
    .alert-modern-ok {
      background: rgba(249, 220, 75, 0.15);
      border: 1px solid var(--ti-yellow);
      color: var(--ti-yellow);
    }

    /* Form Fields */
    .form-group {
      margin-bottom: 15px;
    }
    .form-label-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 6px;
    }
    .form-label {
      font-size: 12.5px;
      font-weight: 700;
      color: var(--ti-white);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .form-label .code-tag {
      font-family: var(--font-mono);
      font-size: 10px;
      color: var(--ti-yellow);
      font-weight: 500;
    }
    .form-label-hint {
      font-family: var(--font-mono);
      font-size: 10.5px;
      color: var(--ti-white-dim);
    }

    .input-box {
      position: relative;
      display: flex;
      align-items: center;
    }
    .input-box .input-icon-lead {
      position: absolute;
      left: 14px;
      color: var(--ti-white-dim);
      font-size: 15px;
      pointer-events: none;
      transition: color 0.25s ease;
    }
    .custom-input {
      width: 100%;
      height: 44px;
      background: var(--ti-black-input);
      border: 1.5px solid var(--ti-border-dim);
      border-radius: 10px;
      padding: 0 44px 0 40px;
      font-size: 13px;
      color: var(--ti-white);
      font-family: var(--font-sans);
      outline: none;
      transition: all 0.25s ease;
    }
    .custom-input::placeholder {
      color: #64748b;
      font-size: 12.5px;
    }
    .custom-input:focus {
      border-color: var(--ti-yellow);
      background: #000000;
      box-shadow: 0 0 0 3px rgba(249, 220, 75, 0.25), 0 0 16px rgba(249, 220, 75, 0.2);
    }
    .input-box:focus-within .input-icon-lead {
      color: var(--ti-yellow);
    }
    .custom-input.has-error {
      border-color: #ef4444;
      background: rgba(239, 68, 68, 0.08);
      box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.18);
    }

    .btn-toggle-eye {
      position: absolute;
      right: 10px;
      background: transparent;
      border: none;
      color: var(--ti-white-dim);
      cursor: pointer;
      padding: 6px;
      font-size: 15px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s ease;
    }
    .btn-toggle-eye:hover {
      color: var(--ti-yellow);
    }

    /* Caps Lock Indicator */
    .caps-lock-warning {
      display: none;
      align-items: center;
      gap: 6px;
      font-family: var(--font-mono);
      font-size: 10.5px;
      color: var(--ti-yellow);
      margin-top: 5px;
    }
    .caps-lock-warning.active {
      display: flex;
    }

    .error-feedback {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 11.5px;
      color: #f87171;
      margin-top: 4px;
      font-weight: 500;
    }

    /* Options Row */
    .form-options-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
      font-size: 12px;
    }
    .remember-wrapper {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      user-select: none;
    }
    .remember-wrapper input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--ti-yellow);
      cursor: pointer;
      border-radius: 4px;
    }
    .remember-wrapper span {
      color: var(--ti-white-muted);
      font-weight: 500;
    }
    .security-chip {
      font-family: var(--font-mono);
      font-size: 10px;
      color: var(--ti-white-dim);
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .security-chip i {
      color: var(--ti-yellow);
    }

    /* Submit Button (Kuning #f9dc4b, Teks Hitam #000000, Hover Putih #ffffff) */
    .btn-submit-login {
      width: 100%;
      height: 46px;
      margin-top: 8px;
      background: var(--ti-yellow);
      color: var(--ti-black);
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 800;
      font-family: var(--font-sans);
      cursor: pointer;
      box-shadow: 0 6px 20px var(--ti-yellow-glow);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      position: relative;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-submit-login::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
        60deg,
        transparent 30%,
        rgba(255, 255, 255, 0.6) 50%,
        transparent 70%
      );
      transform: rotate(30deg) translateX(-100%);
      transition: transform 0.75s ease;
    }
    .btn-submit-login:hover {
      background: var(--ti-white);
      color: var(--ti-black);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(255, 255, 255, 0.4);
    }
    .btn-submit-login:hover::before {
      transform: rotate(30deg) translateX(100%);
    }
    .btn-submit-login:active {
      transform: translateY(0);
    }

    /* Alumni / Public Action Box */
    .alumni-card {
      margin-top: 14px;
      padding: 10px 14px;
      border-radius: 12px;
      background: rgba(0, 0, 0, 0.75);
      border: 1px solid var(--ti-yellow-border);
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      transition: all 0.25s ease;
    }
    .alumni-card:hover {
      background: #000000;
      border-color: var(--ti-yellow);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(249, 220, 75, 0.15);
    }
    .alumni-card-icon {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: var(--ti-yellow-subtle);
      color: var(--ti-yellow);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .alumni-card-text {
      flex: 1;
    }
    .alumni-card-title {
      font-size: 12px;
      font-weight: 700;
      color: var(--ti-white);
    }
    .alumni-card-sub {
      font-size: 11px;
      color: var(--ti-white-dim);
      line-height: 1.3;
    }
    .alumni-card-arrow {
      color: var(--ti-yellow);
      font-size: 12px;
      transition: transform 0.2s ease;
    }
    .alumni-card:hover .alumni-card-arrow {
      transform: translateX(3px);
    }

    /* Auth Footer */
    .auth-bottom-info {
      text-align: center;
      margin-top: 14px;
    }
    .security-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-family: var(--font-mono);
      font-size: 10.5px;
      color: var(--ti-white-dim);
      margin-bottom: 4px;
    }
    .security-badge i {
      color: var(--ti-yellow);
      font-size: 12px;
    }
    .auth-copyright {
      font-size: 10.5px;
      color: var(--ti-white-dim);
    }

    /* ── RESPONSIVE DESIGN ── */
    @media (max-width: 992px) {
      .showcase-panel {
        display: none;
      }
      .auth-panel {
        flex: 1;
        padding: 24px 20px;
      }
      html, body {
        overflow-y: auto;
      }
    }
  </style>
</head>

<body>

<!-- Subtle Matrix Grid & Glow Orbs -->
<div class="cyber-grid-overlay"></div>
<div class="glow-orb glow-orb-1"></div>
<div class="glow-orb glow-orb-2"></div>
<div class="glow-orb glow-orb-3"></div>

<div class="auth-container">

  <!-- ══════════════════════════════════════════════════════════════════════
       LEFT SHOWCASE PANEL (COMMAND CENTER TEKNIK INFORMATIKA)
  ══════════════════════════════════════════════════════════════════════ -->
  <aside class="showcase-panel">
    <div class="showcase-bg-image"></div>
    <div class="showcase-overlay"></div>
    <div class="showcase-scanline"></div>

    <div class="showcase-content">
      <!-- Top Branding -->
      <a href="{{ route('homepage') }}" class="showcase-brand-header">
        <div class="showcase-logo-box">
          <img src="{{ asset('frontend/img/logouis.png') }}" alt="Lambang Resmi UIS">
        </div>
        <div class="showcase-brand-info">
          <h2>
            Teknik Informatika
            <span class="core-badge">CORE v4.2</span>
          </h2>
          <span>Fakultas Sains dan Teknologi • UIS</span>
        </div>
      </a>

      <!-- Center: Terminal HUD Simulator (Live Typing & Streaming Feed) -->
      <div class="terminal-hud-box">
        <div class="terminal-hud-header">
          <div class="terminal-dots">
            <span class="terminal-dot terminal-dot-1"></span>
            <span class="terminal-dot terminal-dot-2"></span>
            <span class="terminal-dot terminal-dot-3"></span>
          </div>
          <div class="terminal-title">tf_auth_gateway@uis-cluster:~</div>
          <div class="terminal-status-chip">
            <span class="pulse-dot"></span> LIVE CONSOLE
          </div>
        </div>

        <div class="terminal-hud-body">
          <!-- Live Typewriter & Auto-Scrolling Terminal Stream -->
          <div id="terminalStream" class="terminal-stream-console"></div>

          <!-- Tech Pillars Grid (Dynamic Scanning Highlight) -->
          <div class="tech-pillars-grid">
            <div class="tech-pillar-card active-scan">
              <div class="tech-pillar-icon"><i class="bi bi-cpu"></i></div>
              <div>
                <div class="tech-pillar-title">Artificial Intelligence</div>
                <div class="tech-pillar-desc">Machine Learning & Data</div>
              </div>
            </div>

            <div class="tech-pillar-card">
              <div class="tech-pillar-icon"><i class="bi bi-shield-lock"></i></div>
              <div>
                <div class="tech-pillar-title">Cybersecurity</div>
                <div class="tech-pillar-desc">Network & Cryptography</div>
              </div>
            </div>

            <div class="tech-pillar-card">
              <div class="tech-pillar-icon"><i class="bi bi-cloud-check"></i></div>
              <div>
                <div class="tech-pillar-title">Cloud Infrastructure</div>
                <div class="tech-pillar-desc">Distributed Systems</div>
              </div>
            </div>

            <div class="tech-pillar-card">
              <div class="tech-pillar-icon"><i class="bi bi-code-slash"></i></div>
              <div>
                <div class="tech-pillar-title">Software Engineering</div>
                <div class="tech-pillar-desc">Modern Web & Mobile</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Telemetry Bar -->
      <div class="showcase-telemetry">
        <div class="telemetry-item">
          <i class="bi bi-clock-history"></i>
          <span>WIB: </span>
          <span class="telemetry-val" id="liveTime">--:--:--</span>
        </div>
        <div class="telemetry-item">
          <i class="bi bi-activity"></i>
          <span>LATENCY: </span>
          <span class="telemetry-val">12ms (Optimal)</span>
        </div>
        <div class="telemetry-item">
          <i class="bi bi-hdd-network"></i>
          <span>NODE: </span>
          <span class="telemetry-val">UIS-TF#FST</span>
        </div>
      </div>
    </div>
  </aside>

  <!-- ══════════════════════════════════════════════════════════════════════
       RIGHT AUTH PANEL (LOGIN TERMINAL RESMI TEKNIK INFORMATIKA)
  ══════════════════════════════════════════════════════════════════════ -->
  <main class="auth-panel" id="authPanel">
    <!-- Interactive Informatics Node Network Canvas -->
    <canvas id="authNetworkCanvas"></canvas>

    <!-- Top Navigation Bar -->
    <div class="auth-topbar">
      <a href="{{ route('homepage') }}" class="btn-back-home">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Beranda</span>
      </a>

      <div class="auth-badge-live">
        <span class="radar-dot"></span>
        <span>SISTEM AKTIF</span>
      </div>
    </div>

    <!-- Center Card Wrapper -->
    <div class="auth-card-wrapper">
      <div class="cyber-auth-card">
        <!-- Auth Header -->
        <div class="auth-header">
          <div class="auth-badge-top">
            <i class="bi bi-terminal-fill"></i>
            <span>AUTENTIKASI AKUN TEKNIK INFORMATIKA</span>
          </div>
          <h2>Masuk ke Akun Anda</h2>
          <p>Gunakan kredensial resmi institusi untuk mengakses portal kontrol akademik dan administrasi prodi.</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
          <div class="alert-modern alert-modern-ok">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
          </div>
        @endif

        @if ($errors->has('email') && str_contains($errors->first('email'), 'salah'))
          <div class="alert-modern alert-modern-err">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ $errors->first('email') }}</div>
          </div>
        @endif

        <!-- Login Form -->
        <form id="formLogin" action="{{ route('loginproses') }}" method="POST" novalidate>
          @csrf

          <!-- Email Field -->
          <div class="form-group">
            <div class="form-label-row">
              <label for="email" class="form-label">
                <span>Email Institusi</span>
                <span class="code-tag">[USER_ID]</span>
              </label>
              <span class="form-label-hint">contoh: admin@uis.ac.id</span>
            </div>
            <div class="input-box">
              <i class="bi bi-envelope-at input-icon-lead"></i>
              <input 
                type="email" 
                id="email" 
                name="email" 
                class="custom-input {{ $errors->has('email') && !str_contains($errors->first('email'), 'salah') ? 'has-error' : '' }}" 
                placeholder="nama@uis.ac.id" 
                value="{{ old('email') }}" 
                autocomplete="email"
                required
              >
            </div>
            @error('email')
              @if (!str_contains($message, 'salah'))
                <div class="error-feedback">
                  <i class="bi bi-exclamation-circle-fill"></i>
                  <span>{{ $message }}</span>
                </div>
              @endif
            @enderror
          </div>

          <!-- Password Field -->
          <div class="form-group">
            <div class="form-label-row">
              <label for="password" class="form-label">
                <span>Kata Sandi</span>
                <span class="code-tag">[KEY]</span>
              </label>
            </div>
            <div class="input-box">
              <i class="bi bi-shield-lock input-icon-lead"></i>
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="custom-input {{ $errors->has('password') ? 'has-error' : '' }}" 
                placeholder="Masukkan kata sandi Anda" 
                autocomplete="current-password"
                required
              >
              <button type="button" id="togglePw" class="btn-toggle-eye" aria-label="Lihat kata sandi">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
            <!-- Caps Lock Warning Alert -->
            <div class="caps-lock-warning" id="capsLockWarning">
              <i class="bi bi-exclamation-triangle-fill"></i>
              <span>Peringatan: Tombol Caps Lock aktif</span>
            </div>
            @error('password')
              <div class="error-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <!-- Submit CTA: Kuning #f9dc4b, Teks Hitam #000000 -->
          <button type="submit" class="btn-submit-login" id="btnMasuk">
            <span id="btnText">Masuk ke Portal</span>
            <i class="bi bi-arrow-right-short fs-5" id="btnIcon"></i>
          </button>
        </form>

        <!-- Alumni Prodi Teknik Informatika Public Portal -->
        <a href="{{ route('homepage.alumni.create') }}" class="alumni-card">
          <div class="alumni-card-icon">
            <i class="bi bi-mortarboard-fill"></i>
          </div>
          <div class="alumni-card-text">
            <div class="alumni-card-title">
              <span>Alumni Prodi Teknik Informatika?</span>
            </div>
            <div class="alumni-card-sub">
              Kirimkan ulasan & testimoni tanpa perlu login
            </div>
          </div>
          <i class="bi bi-chevron-right alumni-card-arrow"></i>
        </a>
      </div>

      <!-- Footer Info -->
      <div class="auth-bottom-info">
        <div class="security-badge">
          <i class="bi bi-lock-fill"></i>
          <span>TERENKRIPSI END-TO-END • PUSAT TEKNOLOGI INFORMASI UIS</span>
        </div>
        <div class="auth-copyright">
          &copy; {{ date('Y') }} Program Studi S1 Teknik Informatika (FST UIS). Hak cipta dilindungi.
        </div>
      </div>
    </div>

    <!-- Empty bottom element for flex balance -->
    <div></div>
  </main>

</div>

<!-- ═══════════════════════════════════════════════════════════════
     JAVASCRIPT:
     1. Interactive Neural Network Mesh (Warna Kuning & Putih)
     2. Realistic Terminal Typewriter & Live Streaming Logs Engine
     3. Dynamic 4 Tech Pillars Scanning Radar
     4. Live Clock (WIB)
     5. Password Toggle & CapsLock Detector
     6. Form Submission Loading State
═══════════════════════════════════════════════════════════════ -->
<script>
  // ── 1. Interactive Informatics Node Network (Kuning #f9dc4b & Putih #ffffff) ──
  (function initNodeNetwork() {
    const canvas = document.getElementById('authNetworkCanvas');
    const panel = document.getElementById('authPanel');
    if (!canvas || !panel) return;

    const ctx = canvas.getContext('2d');
    let width = 0;
    let height = 0;
    let dpr = window.devicePixelRatio || 1;

    let nodes = [];
    let packets = [];
    const MAX_DISTANCE = 140;
    let mouse = { x: null, y: null, radius: 160 };

    function resize() {
      const rect = panel.getBoundingClientRect();
      width = rect.width;
      height = rect.height;
      canvas.width = width * dpr;
      canvas.height = height * dpr;
      ctx.setTransform(1, 0, 0, 1, 0, 0); // reset scale
      ctx.scale(dpr, dpr);
      createNodes();
    }

    panel.addEventListener('mousemove', function(e) {
      const rect = panel.getBoundingClientRect();
      mouse.x = e.clientX - rect.left;
      mouse.y = e.clientY - rect.top;
    });

    panel.addEventListener('mouseleave', function() {
      mouse.x = null;
      mouse.y = null;
    });

    class NetworkNode {
      constructor(x, y) {
        this.x = x !== undefined ? x : Math.random() * width;
        this.y = y !== undefined ? y : Math.random() * height;
        this.vx = (Math.random() - 0.5) * 0.7;
        this.vy = (Math.random() - 0.5) * 0.7;

        // Hub nodes: 15% are larger core gateway nodes
        this.isHub = Math.random() < 0.15;
        this.radius = this.isHub ? (Math.random() * 1.5 + 3.5) : (Math.random() * 1.2 + 1.8);

        // Palet Resmi TI: 80% Kuning #f9dc4b, 20% Putih #ffffff
        this.isGold = Math.random() < 0.8;
        this.colorRgb = this.isGold ? '249, 220, 75' : '255, 255, 255';

        this.pulse = Math.random() * Math.PI * 2;
        this.pulseSpeed = 0.025 + Math.random() * 0.02;
        this.ringRadius = this.radius;
        this.ringAlpha = 0;
      }

      update() {
        this.x += this.vx;
        this.y += this.vy;
        this.pulse += this.pulseSpeed;

        // Bounce on boundaries
        if (this.x < 12) { this.x = 12; this.vx = Math.abs(this.vx); }
        if (this.x > width - 12) { this.x = width - 12; this.vx = -Math.abs(this.vx); }
        if (this.y < 12) { this.y = 12; this.vy = Math.abs(this.vy); }
        if (this.y > height - 12) { this.y = height - 12; this.vy = -Math.abs(this.vy); }

        // Interactive mouse connection and magnetic pull
        if (mouse.x !== null && mouse.y !== null) {
          const dx = mouse.x - this.x;
          const dy = mouse.y - this.y;
          const dist = Math.hypot(dx, dy);
          if (dist < mouse.radius && dist > 0) {
            const force = (mouse.radius - dist) / mouse.radius;
            this.x += (dx / dist) * force * 1.4;
            this.y += (dy / dist) * force * 1.4;
          }
        }

        // Hub pulse ring expansion
        if (this.isHub) {
          this.ringRadius += 0.3;
          this.ringAlpha = Math.max(0, 1 - (this.ringRadius - this.radius) / 18);
          if (this.ringRadius > this.radius + 18) {
            this.ringRadius = this.radius;
            this.ringAlpha = 0.75;
          }
        }
      }

      draw() {
        const glowFactor = Math.sin(this.pulse) * 0.2 + 0.8;

        // Expanding outer ring for hub nodes
        if (this.isHub && this.ringAlpha > 0) {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.ringRadius, 0, Math.PI * 2);
          ctx.strokeStyle = `rgba(${this.colorRgb}, ${this.ringAlpha * 0.6})`;
          ctx.lineWidth = 1;
          ctx.stroke();
        }

        // Node vertex
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${this.colorRgb}, ${glowFactor * 0.95})`;
        ctx.shadowBlur = this.isHub ? 16 : 8;
        ctx.shadowColor = `rgba(${this.colorRgb}, 0.85)`;
        ctx.fill();
        ctx.shadowBlur = 0;

        // Core highlight for hub nodes
        if (this.isHub) {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.radius * 0.45, 0, Math.PI * 2);
          ctx.fillStyle = '#ffffff';
          ctx.fill();
        }
      }
    }

    // Dynamic data packet traversing network edges
    class DataPacket {
      constructor(fromNode, toNode) {
        this.from = fromNode;
        this.to = toNode;
        this.progress = 0;
        this.speed = 0.012 + Math.random() * 0.016;
        this.dead = false;
      }
      update() {
        this.progress += this.speed;
        if (this.progress >= 1) {
          this.dead = true;
        }
      }
      draw() {
        const px = this.from.x + (this.to.x - this.from.x) * this.progress;
        const py = this.from.y + (this.to.y - this.from.y) * this.progress;

        ctx.beginPath();
        ctx.arc(px, py, 2.4, 0, Math.PI * 2);
        ctx.fillStyle = '#ffffff';
        ctx.shadowBlur = 10;
        ctx.shadowColor = '#f9dc4b';
        ctx.fill();
        ctx.shadowBlur = 0;
      }
    }

    function createNodes() {
      nodes = [];
      packets = [];
      // Dense node constellation (approx 60-75 nodes)
      const count = Math.min(85, Math.max(50, Math.floor((width * height) / 9500)));
      for (let i = 0; i < count; i++) {
        nodes.push(new NetworkNode());
      }
    }

    // Packet transmission simulator
    function spawnPacket() {
      if (packets.length >= 14 || nodes.length < 2) return;
      const srcIdx = Math.floor(Math.random() * nodes.length);
      const src = nodes[srcIdx];
      let neighbor = null;
      let minD = MAX_DISTANCE;
      for (let i = 0; i < nodes.length; i++) {
        if (i === srcIdx) continue;
        const d = Math.hypot(src.x - nodes[i].x, src.y - nodes[i].y);
        if (d < minD) {
          neighbor = nodes[i];
          break;
        }
      }
      if (neighbor) {
        packets.push(new DataPacket(src, neighbor));
      }
    }
    setInterval(spawnPacket, 350);

    function animateNetwork() {
      ctx.clearRect(0, 0, width, height);

      // 1. Draw Network Connections (Edges)
      for (let i = 0; i < nodes.length; i++) {
        const n1 = nodes[i];
        for (let j = i + 1; j < nodes.length; j++) {
          const n2 = nodes[j];
          const dx = n1.x - n2.x;
          const dy = n1.y - n2.y;
          const dist = Math.hypot(dx, dy);

          if (dist < MAX_DISTANCE) {
            const alpha = (1 - dist / MAX_DISTANCE) * 0.42;
            ctx.beginPath();
            ctx.moveTo(n1.x, n1.y);
            ctx.lineTo(n2.x, n2.y);
            ctx.strokeStyle = `rgba(249, 220, 75, ${alpha})`;
            ctx.lineWidth = alpha > 0.25 ? 1.2 : 0.8;
            ctx.stroke();
          }
        }

        // Connect to mouse cursor if nearby
        if (mouse.x !== null && mouse.y !== null) {
          const mDist = Math.hypot(n1.x - mouse.x, n1.y - mouse.y);
          if (mDist < mouse.radius) {
            const mAlpha = (1 - mDist / mouse.radius) * 0.7;
            ctx.beginPath();
            ctx.moveTo(n1.x, n1.y);
            ctx.lineTo(mouse.x, mouse.y);
            ctx.strokeStyle = `rgba(249, 220, 75, ${mAlpha})`;
            ctx.lineWidth = 1.3;
            ctx.stroke();
          }
        }
      }

      // Draw active mouse vertex
      if (mouse.x !== null && mouse.y !== null) {
        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, 4, 0, Math.PI * 2);
        ctx.fillStyle = '#f9dc4b';
        ctx.shadowBlur = 14;
        ctx.shadowColor = '#f9dc4b';
        ctx.fill();
        ctx.shadowBlur = 0;
      }

      // 2. Update and draw nodes
      for (let i = 0; i < nodes.length; i++) {
        nodes[i].update();
        nodes[i].draw();
      }

      // 3. Update and draw data packets
      for (let k = packets.length - 1; k >= 0; k--) {
        const pkt = packets[k];
        pkt.update();
        if (pkt.dead) {
          packets.splice(k, 1);
        } else {
          pkt.draw();
        }
      }

      requestAnimationFrame(animateNetwork);
    }

    window.addEventListener('resize', resize);
    resize();
    animateNetwork();
  })();

  // ── 2. Realistic Terminal Typewriter & Live Streaming Logs Engine ──
  (function initTerminalTypewriter() {
    const streamContainer = document.getElementById('terminalStream');
    if (!streamContainer) return;

    // Boot sequence commands & logs
    const initialBootScript = [
      { type: 'command', text: 'init --service=portal-tf-core' },
      { type: 'output', text: '> [SECURITY] TLS 1.3 | CIPHER: AES-256-GCM ACTIVE', tag: 'yellow' },
      { type: 'output', text: '> [DATABASE] ACADEMIC KERNEL & SIAKAD SYNCHRONIZED', tag: 'white' },
      { type: 'output', text: '> [AI-ENGINE] NEURAL WEIGHTS v4.2 LOADED [TENSOR-RT]', tag: 'yellow' },
      { type: 'output', text: '> [NETWORK] LISTENING ON PORT 443 [127.0.0.1:HTTPS]', tag: 'white' },
      { type: 'output', text: '> [ACCESS] WAITING FOR AUTHORIZED USER TOKEN...', tag: 'yellow', hasCursor: true }
    ];

    // Continuous streaming live logs ("Content Berjalan")
    const continuousLiveLogs = [
      { text: '> [TELEMETRY] Node UIS-TF#FST heartbeat: 12ms (Optimal)', tag: 'white' },
      { text: '> [SECURITY] Zero-trust gateway verified | TLS handshake OK', tag: 'yellow' },
      { text: '> [AI_MONITOR] Inference latency: 4.8ms | GPU Memory: Normal', tag: 'white' },
      { text: '> [DATABASE] SIAKAD connection pool active (64 idle, 2 active)', tag: 'yellow' },
      { text: '> [NETWORK] Packet checksum verified for prodi-ti.uis.ac.id', tag: 'white' },
      { text: '> [SYSTEM] Memory: 1.4GB/16GB | CPU: 3.8% | IO: Normal', tag: 'yellow' },
      { text: '> [STATUS] Core services online. Awaiting user handshake...', tag: 'white', hasCursor: true }
    ];

    function scrollToBottom() {
      streamContainer.scrollTop = streamContainer.scrollHeight;
    }

    function removeCursor() {
      const existingCursor = streamContainer.querySelector('.terminal-cursor');
      if (existingCursor) existingCursor.remove();
    }

    function appendCursorTo(element) {
      removeCursor();
      const cursor = document.createElement('span');
      cursor.className = 'terminal-cursor';
      element.appendChild(cursor);
    }

    // Type a command character by character with realistic typewriter effect
    function typeCommand(text, callback) {
      const line = document.createElement('div');
      line.className = 'terminal-line';

      const prompt = document.createElement('span');
      prompt.className = 'terminal-prompt';
      prompt.textContent = '$';
      line.appendChild(prompt);

      const content = document.createElement('span');
      content.style.color = '#ffffff';
      content.style.fontWeight = '600';
      line.appendChild(content);

      appendCursorTo(line);
      streamContainer.appendChild(line);
      scrollToBottom();

      let i = 0;
      function nextChar() {
        if (i < text.length) {
          content.textContent += text.charAt(i);
          i++;
          scrollToBottom();
          const jitter = Math.random() * 25 + 30; // 30-55ms
          setTimeout(nextChar, jitter);
        } else {
          setTimeout(callback, 320);
        }
      }
      nextChar();
    }

    // Print an output line with formatting and auto-scroll
    function printOutput(item, callback) {
      removeCursor();

      const line = document.createElement('div');
      line.className = 'terminal-line';

      const content = document.createElement('span');
      if (item.tag === 'yellow') {
        content.className = 'terminal-text-yellow';
      } else {
        content.className = 'terminal-text-white';
      }
      content.textContent = item.text;
      line.appendChild(content);

      if (item.hasCursor) {
        appendCursorTo(line);
      }

      streamContainer.appendChild(line);
      scrollToBottom();

      // Keep maximum 18 lines in DOM to keep performance razor sharp
      while (streamContainer.children.length > 18) {
        streamContainer.removeChild(streamContainer.firstChild);
      }

      if (callback) {
        setTimeout(callback, 280);
      }
    }

    // Run initial boot typewriter
    let stepIndex = 0;
    function runBoot() {
      if (stepIndex < initialBootScript.length) {
        const item = initialBootScript[stepIndex];
        stepIndex++;
        if (item.type === 'command') {
          typeCommand(item.text, runBoot);
        } else {
          printOutput(item, runBoot);
        }
      } else {
        startLiveLogStream();
      }
    }

    // Stream live lines every 2.8 seconds ("Content Berjalan")
    let liveIndex = 0;
    function startLiveLogStream() {
      setInterval(function() {
        const now = new Date();
        const timeStr = String(now.getHours()).padStart(2, '0') + ':' +
                        String(now.getMinutes()).padStart(2, '0') + ':' +
                        String(now.getSeconds()).padStart(2, '0');

        const log = continuousLiveLogs[liveIndex % continuousLiveLogs.length];
        liveIndex++;

        // Add real timestamp to log text
        const textWithTime = log.text.replace('> [', `> [${timeStr} `);
        printOutput({ text: textWithTime, tag: log.tag, hasCursor: true });
      }, 2800);
    }

    // Initial delay before typing starts
    setTimeout(runBoot, 400);

    // ── 3. Dynamic 4 Tech Pillars Scanning Radar ("Content Berjalan") ──
    const pillarCards = document.querySelectorAll('.tech-pillar-card');
    if (pillarCards.length > 0) {
      let activePillarIdx = 0;
      setInterval(function() {
        pillarCards.forEach(c => c.classList.remove('active-scan'));
        activePillarIdx = (activePillarIdx + 1) % pillarCards.length;
        pillarCards[activePillarIdx].classList.add('active-scan');
      }, 2200);
    }
  })();

  // ── 4. Live Telemetry Clock (WIB) ──
  (function initClock() {
    const el = document.getElementById('liveTime');
    if (!el) return;
    function updateClock() {
      const now = new Date();
      const h = String(now.getHours()).padStart(2, '0');
      const m = String(now.getMinutes()).padStart(2, '0');
      const s = String(now.getSeconds()).padStart(2, '0');
      el.textContent = `${h}:${m}:${s}`;
    }
    updateClock();
    setInterval(updateClock, 1000);
  })();

  // ── 5. Password Toggle & CapsLock Detector ──
  const pwInput = document.getElementById('password');
  const toggleBtn = document.getElementById('togglePw');
  const eyeIcon = document.getElementById('eyeIcon');
  const capsWarning = document.getElementById('capsLockWarning');

  if (toggleBtn && pwInput) {
    toggleBtn.addEventListener('click', function () {
      const isPw = pwInput.type === 'password';
      pwInput.type = isPw ? 'text' : 'password';
      eyeIcon.className = isPw ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  }

  if (pwInput && capsWarning) {
    ['keydown', 'keyup'].forEach(eventType => {
      pwInput.addEventListener(eventType, function (e) {
        if (e.getModifierState && e.getModifierState('CapsLock')) {
          capsWarning.classList.add('active');
        } else {
          capsWarning.classList.remove('active');
        }
      });
    });
  }

  // ── 6. Form Submit Loading State ──
  const loginForm = document.getElementById('formLogin');
  const btnMasuk = document.getElementById('btnMasuk');
  const btnText = document.getElementById('btnText');
  const btnIcon = document.getElementById('btnIcon');

  if (loginForm && btnMasuk) {
    loginForm.addEventListener('submit', function () {
      btnMasuk.disabled = true;
      btnMasuk.style.opacity = '0.9';
      btnMasuk.style.cursor = 'wait';
      btnText.textContent = 'Memverifikasi Kredensial...';
      btnIcon.className = 'bi bi-arrow-repeat spin-icon';
    });
  }
</script>

<style>
  .spin-icon {
    display: inline-block;
    animation: spin 0.8s infinite linear;
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

</body>
</html>
