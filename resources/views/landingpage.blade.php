<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simagang - Sistem Manajemen Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        @font-face {
            font-family: 'Etna';
            src: url('/fonts/Etna-Free-Font.otf') format('opentype');
        }
        .font-etna { font-family: 'Etna', sans-serif; }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f0f7ff;
            color: #0f2d4a;
            margin: 0;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid #bfdbfe;
            box-shadow: 0 1px 20px rgba(14,99,201,0.07);
        }
        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .nav-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-logo img { height: 36px; width: 36px; border-radius: 9999px; }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            color: #4b6580;
            padding: 8px 16px;
            border-radius: 50px;
            transition: all 0.2s;
        }
        .nav-links a:hover { background: #eff6ff; color: #1d6fca; }
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9);
            color: white;
            font-size: 14px;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(14,99,201,0.3);
            transition: all 0.25s;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(14,99,201,0.4); }

        /* ── HERO ── */
        .hero {
            position: relative;
            background: linear-gradient(135deg, #0c2d5e 0%, #1251a3 40%, #0891b2 100%);
            overflow: hidden;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            pointer-events: none;
        }
        .hero-blob-1 { width: 500px; height: 500px; background: #38bdf8; top: -150px; left: -100px; }
        .hero-blob-2 { width: 400px; height: 400px; background: #818cf8; bottom: -100px; right: 0; }
        .hero-blob-3 { width: 300px; height: 300px; background: #22d3ee; top: 40%; left: 40%; }
        .hero-inner {
            position: relative;
            max-width: 1280px;
            margin: 0 auto;
            padding: 5rem 1.5rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(56,189,248,0.18);
            border: 1px solid rgba(56,189,248,0.35);
            color: #7dd3fc;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 1.5rem;
        }
        .hero-title {
            font-size: clamp(2rem, 4vw, 3.25rem);
            font-weight: 800;
            line-height: 1.15;
            color: white;
            margin: 0 0 1.25rem;
        }
        .hero-title span { color: #7dd3fc; }
        .hero-desc {
            font-size: 1.1rem;
            line-height: 1.75;
            color: rgba(255,255,255,0.75);
            margin: 0 0 2.5rem;
            max-width: 480px;
        }
        .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 2rem; }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: #22d3ee;
            color: #0c2d5e;
            font-weight: 700;
            font-size: 15px;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 6px 28px rgba(34,211,238,0.28);
            transition: all 0.25s;
        }
        .btn-primary:hover { background: #38bdf8; transform: translateY(-2px); }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.28);
            color: white;
            font-weight: 600;
            font-size: 15px;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.25s;
        }
        .btn-outline:hover { background: rgba(255,255,255,0.22); }
        .hero-image-wrap {
            width: 100%;
            max-width: 560px;
            transition: transform 0.35s;
            margin-bottom: 0;
            display: flex;
            justify-content: flex-end;
        }
        .hero-image-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(56,189,248,0.22), transparent 36%);
            pointer-events: none;
        }
        .hero-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    
        .hero-card-float {
            position: absolute;
            background: white;
            border-radius: 16px;
            padding: 14px 18px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .hero-card-float .icon { font-size: 22px; }
        .hero-card-float .label { font-size: 12px; color: #64748b; }
        .hero-card-float .value { font-size: 15px; font-weight: 700; color: #0f2d4a; }
        .card-top { top: -20px; right: -20px; }
        .card-bottom { bottom: -20px; left: -20px; }

        /* ── SECTION WRAPPER ── */
        .section-header { text-align: center; max-width: 640px; margin: 0 auto 3.5rem; }
        .section-eyebrow {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #1d6fca;
            background: #eff6ff;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 1rem;
        }
        .section-title { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; color: #0f2d4a; margin: 0 0 1rem; line-height: 1.2; }
        .section-desc { font-size: 1.05rem; color: #4b6580; line-height: 1.7; margin: 0; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }

        /* ── PROCESS SECTION ── */
        .section-process { background: white; padding: 6rem 0; }
        .process-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .process-card {
            background: #f0f7ff;
            border: 1.5px solid #bfdbfe;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            position: relative;
            transition: all 0.3s;
            overflow: hidden;
        }
        .process-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #eff6ff, transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .process-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(14,99,201,0.12); border-color: #93c5fd; }
        .process-card:hover::before { opacity: 1; }
        .process-num {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 3.5rem;
            font-weight: 900;
            color: #bfdbfe;
            line-height: 1;
        }
        .process-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            margin-bottom: 1.5rem;
            position: relative;
            box-shadow: 0 8px 24px rgba(29,111,202,0.3);
        }
        .process-title { font-size: 1.2rem; font-weight: 700; color: #0f2d4a; margin: 0 0 0.6rem; }
        .process-desc { font-size: 0.95rem; color: #4b6580; line-height: 1.6; margin: 0; }

        /* ── FEATURES / USAGE ── */
        .section-usage { background: #f0f7ff; padding: 6rem 0; }
        .step-block {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            padding: 3.5rem 0;
        }
        .step-block + .step-block { border-top: 1px solid #bfdbfe; }
        .step-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d6fca;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 50px;
            margin-bottom: 1rem;
        }
        .step-icon-wrap {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 6px 20px rgba(29,111,202,0.28);
            margin-bottom: 1.25rem;
        }
        .step-title { font-size: 1.75rem; font-weight: 800; color: #0f2d4a; margin: 0 0 1rem; }
        .step-desc { font-size: 1.05rem; color: #4b6580; line-height: 1.75; margin: 0; }
        .step-list { list-style: none; padding: 0; margin: 1.25rem 0 0; display: flex; flex-direction: column; gap: 10px; }
        .step-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: #4b6580;
        }
        .step-list li::before {
            content: '';
            width: 22px;
            height: 22px;
            min-width: 22px;
            background: #eff6ff;
            border: 1.5px solid #93c5fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%231d6fca'%3E%3Cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.172l6.879-6.879a1 1 0 011.414 0z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-size: 13px;
            background-repeat: no-repeat;
            background-position: center;
        }
        .step-image {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 16px 50px rgba(14,99,201,0.12);
            border: 2px solid #bfdbfe;
            transition: transform 0.35s;
        }

        .step-image:hover { transform: scale(1.025); }

        /* ── TESTIMONIALS ── */
        .section-testimonials { background: white; padding: 6rem 0; }
        .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .testi-card {
            background: #f0f7ff;
            border: 1.5px solid #bfdbfe;
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            transition: all 0.3s;
        }
        .testi-card:hover { transform: translateY(-4px); box-shadow: 0 16px 44px rgba(14,99,201,0.1); }
        .testi-quote-icon {
            font-size: 2.5rem;
            color: #bfdbfe;
            line-height: 1;
            margin-bottom: 1rem;
        }
        .testi-stars { color: #f59e0b; font-size: 13px; margin-bottom: 0.75rem; letter-spacing: 2px; }
        .testi-text { font-size: 1rem; color: #4b6580; line-height: 1.7; margin: 0 0 1.5rem; font-style: italic; }
        .testi-author { display: flex; align-items: center; gap: 12px; padding-top: 1.25rem; border-top: 1px solid #bfdbfe; }
        .testi-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }
        .testi-name { font-weight: 700; font-size: 14px; color: #0f2d4a; }
        .testi-inst { font-size: 12px; color: #64748b; margin-top: 2px; }

        /* ── PARTNERS ── */
        .section-partners { background: #f0f7ff; padding: 5rem 0; }
        .partners-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
        .partner-card {
            background: white;
            border: 1.5px solid #bfdbfe;
            border-radius: 20px;
            padding: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .partner-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(14,99,201,0.1); border-color: #93c5fd; }
        .partner-card img { max-height: 64px; object-fit: contain; filter: grayscale(0.3); transition: filter 0.3s; }
        .partner-card:hover img { filter: grayscale(0); }
        .partner-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            color: #64748b;
            background: white;
            border-radius: 20px;
            border: 1.5px dashed #bfdbfe;
        }

        /* ── CTA SECTION ── */
        .section-cta { background: linear-gradient(135deg, #0c2d5e 0%, #1251a3 50%, #0891b2 100%); padding: 6rem 0; }
        .cta-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        .cta-tag {
            display: inline-block;
            background: rgba(34,211,238,0.18);
            border: 1px solid rgba(34,211,238,0.3);
            color: #67e8f9;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 1rem;
        }
        .cta-title { font-size: 2.25rem; font-weight: 800; color: white; margin: 0 0 1rem; line-height: 1.2; }
        .cta-desc { font-size: 1.05rem; color: rgba(255,255,255,0.65); line-height: 1.7; margin: 0; }
        .cta-cards { display: flex; flex-direction: column; gap: 1rem; }
        .cta-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 20px;
            padding: 1.25rem 1.5rem;
            text-decoration: none;
            color: white;
            transition: all 0.25s;
            cursor: pointer;
        }
        .cta-card:hover { background: rgba(255,255,255,0.14); border-color: rgba(255,255,255,0.25); transform: translateX(4px); }
        .cta-card-left { display: flex; align-items: center; gap: 14px; }
        .cta-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }
        .cta-card-name { font-weight: 700; font-size: 15px; }
        .cta-card-sub { font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 2px; }
        .cta-arrow { font-size: 20px; opacity: 0.6; }

        /* ── FOOTER ── */
        .footer {
            background: #071b35;
            color: rgba(255,255,255,0.5);
            text-align: center;
            padding: 2rem 1.5rem;
            font-size: 13px;
        }
        .footer span { color: #38bdf8; }

        /* ── SCROLL ANIMATION ── */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hero-inner { grid-template-columns: 1fr; padding: 4rem 1.5rem; text-align: center; }
            .hero-btns { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-image-wrap { max-width: 520px; margin: 0 auto; order: -1; }
            .card-top, .card-bottom { display: none; }
            .process-grid { grid-template-columns: 1fr; }
            .step-block { grid-template-columns: 1fr; gap: 2rem; }
            .step-block .order-swap { order: -1; }
            .testi-grid { grid-template-columns: 1fr; }
            .partners-grid { grid-template-columns: repeat(2, 1fr); }
            .cta-inner { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }
        @media (max-width: 640px) {
            .partners-grid { grid-template-columns: 1fr 1fr; }
            .hero-title { font-size: 1.9rem; }
            .hero-image-wrap { max-width: 100%; }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
    <div class="navbar-inner">
        <a href="#hero" class="nav-logo">
            <img src="{{ url('storage/vendor/logo_komdigi.png') }}" alt="Komdigi" style="height:36px; width:36px; border-radius:9999px; object-fit:cover; border:1.5px solid #bfdbfe; padding:3px; background:#eff6ff;">
            <div>
                <div class="font-etna" style="font-size:20px; font-weight:900; line-height:1.1">
                    <span style="color:#9d272a">SI</span><span style="color:#086bb0">MA</span><span style="color:#2dabe2">GA</span><span style="color:#efc400">NG</span>
                </div>
                <div class="font-etna" style="font-size:10px; color:#8ea5bc; margin-top:2px">Sistem Manajemen Magang</div>
            </div>
        </a>

        <nav class="nav-links">
            <a href="#hero">Beranda</a>
            <a href="#process">Proses</a>
            <a href="#usage">Fitur</a>
            <a href="#testimonials">Testimoni</a>
            <a href="#partners">Partner</a>
        </nav>

        <a href="{{ route('login') }}" class="btn-login">
            <i class="fas fa-sign-in-alt" style="font-size:13px"></i>
            Login
        </a>
    </div>
</header>

<main>

<!-- ===== HERO ===== -->
<section id="hero" class="hero">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="hero-blob hero-blob-3"></div>

    <div class="hero-inner">
        <div>
            <div class="hero-badge">
                <i class="fas fa-circle" style="font-size:6px"></i>
                Sistem Manajemen Magang
            </div>
            <h1 class="hero-title">
                Sistem Magang untuk <span>Kampus & Sekolah</span> Masa Kini
            </h1>
            <p class="hero-desc">
                Komdigi membantu mengelola absensi, logbook, dan sertifikat secara real time.
            </p>
            <div class="hero-btns ">
                <a href="{{ route('register') }}" class="btn-primary">
                    <i class="fas fa-rocket" style="font-size:14px"></i>
                    Mulai Daftar Sekarang
                </a>
                <a href="#usage" class="btn-outline">
                    Lihat Fitur
                    <i class="fas fa-arrow-right" style="font-size:13px"></i>
                </a>
            </div>
            {{-- <div class="hero-stats">
                <div>
                    <div class="hero-stat-num">500+</div>
                    <div class="hero-stat-label">Peserta Aktif</div>
                </div>
                <div style="width:1px; background:rgba(255,255,255,0.12)"></div>
                <div>
                    <div class="hero-stat-num">30+</div>
                    <div class="hero-stat-label">Institusi Bergabung</div>
                </div>
                <div style="width:1px; background:rgba(255,255,255,0.12)"></div>
                <div>
                    <div class="hero-stat-num">98%</div>
                    <div class="hero-stat-label">Tingkat Kepuasan</div>
                </div>
            </div> --}}
        </div>

        <div class="hero-image-wrap">
            <div class="hero-image-card">
                <img src="{{ asset('storage/tutorial/hero.png') }}" alt="Dashboard Simagang">
            </div>
        </div>
    </div>
</section>

<!-- ===== PROSES ===== -->
<section id="process" class="section-process">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow">Alur Magang</span>
            <h2 class="section-title">Langkah Sederhana untuk Setiap Pengguna</h2>
            <p class="section-desc">Mulai dari pendaftaran hingga sertifikat, semua proses dipandu dengan tampilan yang mudah dipahami.</p>
        </div>
        <div class="process-grid">
            <div class="process-card reveal">
                <div class="process-num">01</div>
                <div class="process-icon"><i class="fas fa-user-plus"></i></div>
                <h3 class="process-title">Daftar & Profil</h3>
                <p class="process-desc">Isi data peserta dan pilih institusi asal dengan cepat. Sistem akan memandu proses onboarding secara otomatis.</p>
            </div>
            <div class="process-card reveal">
                <div class="process-num">02</div>
                <div class="process-icon"><i class="fas fa-calendar-check"></i></div>
                <h3 class="process-title">Absensi & Logbook</h3>
                <p class="process-desc">Catat kehadiran dan aktivitas magang setiap hari secara digital. Mentor dapat memantau perkembangan secara real time.</p>
            </div>
            <div class="process-card reveal">
                <div class="process-num">03</div>
                <div class="process-icon"><i class="fas fa-award"></i></div>
                <h3 class="process-title">Laporan & Sertifikat</h3>
                <p class="process-desc">Upload laporan akhir, terima feedback mentor, dan dapatkan sertifikat digital resmi secara otomatis.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== FITUR / PENGGUNAAN ===== -->
<section id="usage" class="section-usage">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow">Tutorial</span>
            <h2 class="section-title">Cara Menggunakan Simagang</h2>
            <p class="section-desc">Ikuti langkah-langkah berikut untuk memahami alur penggunaan aplikasi secara cepat dan mudah.</p>
        </div>

        <!-- Step 1 -->
        <div class="step-block reveal">
            <div class="flex justify-center">
                <img src="{{ asset('storage/tutorial/dashboardLP.png') }}" alt="Login Dashboard" class="step-image" style="width:50%;">
            </div>
            <div>
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Langkah 1</div>
                <div class="step-icon-wrap"><i class="fas fa-play"></i></div>
                <h3 class="step-title">Masuk & Pilih Role</h3>
                <p class="step-desc">Login ke dalam sistem menggunakan akun yang telah terdaftar, lalu pilih role sesuai dengan peran Anda.</p>
                <ul class="step-list">
                    <li>Role Intern untuk peserta magang</li>
                    <li>Role Mentor untuk pembimbing lapangan</li>
                    <li>Role Admin untuk pengelola sistem</li>
                </ul>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step-block reveal">
            <div class="order-swap">
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Langkah 2</div>
                <div class="step-icon-wrap"><i class="fas fa-calendar-check"></i></div>
                <h3 class="step-title">Kelola Absensi</h3>
                <p class="step-desc">Catat kehadiran harian dan isi logbook aktivitas magang secara rutin agar perkembangan kerja dapat dipantau dengan lebih terstruktur.</p>
                <ul class="step-list">
                    <li>Absensi real time dengan verifikasi lokasi</li>
                    <li>Logbook aktivitas harian yang terstruktur</li>
                    <li>Notifikasi otomatis ke mentor</li>
                </ul>
            </div>
            <div>
                <img src="{{ asset('storage/tutorial/absen.jpeg') }}" alt="Absensi" class="step-image">
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step-block reveal">
            <div>
                <img src="{{ asset('storage/tutorial/logbook.png') }}" alt="Upload Laporan" class="step-image">
            </div>
            <div>
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Langkah 3</div>
                <div class="step-icon-wrap"><i class="fas fa-file-alt"></i></div>
                <h3 class="step-title">Upload Laporan Akhir</h3>
                <p class="step-desc">Upload laporan akhir magang dan lihat feedback dari mentor untuk evaluasi hasil kerja secara menyeluruh.</p>
                <ul class="step-list">
                    <li>Upload dokumen dalam berbagai format</li>
                    <li>Feedback mentor langsung di platform</li>
                    <li>Sertifikat digital otomatis setelah selesai</li>
                </ul>
            </div>
        </div>


        <!-- Step 4 -->
        <div class="step-block reveal">
            <div class="order-swap">
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Langkah 2</div>
                <div class="step-icon-wrap"><i class="fas fa-calendar-check"></i></div>
                <h3 class="step-title">Kelola Laporan</h3>
                <p class="step-desc">Catat kehadiran harian dan isi logbook aktivitas magang secara rutin agar perkembangan kerja dapat dipantau dengan lebih terstruktur.</p>
                <ul class="step-list">
                    <li>Absensi real time dengan verifikasi lokasi</li>
                    <li>Logbook aktivitas harian yang terstruktur</li>
                    <li>Notifikasi otomatis ke mentor</li>
                </ul>
            </div>
            <div>
                <img src="{{ asset('storage/tutorial/laporan.png') }}" alt="laporan" class="step-image">
            </div>
        </div>


        <!-- Step 5 -->
        <div class="step-block reveal">
            <div class="flex justify-center">
                <img src="{{ asset('storage/tutorial/mikroskill.png') }}" alt="Upload Laporan" class="step-image" style="width:50%;">
            </div>
            <div>
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Langkah 3</div>
                <div class="step-icon-wrap"><i class="fas fa-file-alt"></i></div>
                <h3 class="step-title">Upload Mikroskill</h3>
                <p class="step-desc">Upload laporan akhir magang dan lihat feedback dari mentor untuk evaluasi hasil kerja secara menyeluruh.</p>
                <ul class="step-list">
                    <li>Upload dokumen dalam berbagai format</li>
                    <li>Feedback mentor langsung di platform</li>
                    <li>Sertifikat digital otomatis setelah selesai</li>
                </ul>
            </div>
        </div>

    </div>
</section>

<!-- ===== TESTIMONI ===== -->
<section id="testimonials" class="section-testimonials">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow">Testimoni</span>
            <h2 class="section-title">Dipercaya oleh Banyak Institusi</h2>
            <p class="section-desc">Berbagai kampus dan sekolah sudah menggunakan Simagang untuk mengelola program magang mereka.</p>
        </div>
        <div class="testi-grid">
            <div class="testi-card reveal">
                <div class="testi-quote-icon">"</div>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">Simagang membuat program magang lebih terstruktur dan mudah diawasi. Semua data tersimpan rapih dan mudah diakses kapan saja.</p>
                <div class="testi-author">
                    <div class="testi-avatar">MT</div>
                    <div>
                        <div class="testi-name">Bapak Ramli S.T</div>
                        <div class="testi-inst">Mentor — Universitas Hasanuddin</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal">
                <div class="testi-quote-icon">"</div>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">Siswa lebih disiplin karena laporan dan absensi bisa dipantau secara real time. Sangat membantu koordinasi antar pihak.</p>
                <div class="testi-author">
                    <div class="testi-avatar">AR</div>
                    <div>
                        <div class="testi-name">Andi Riswan</div>
                        <div class="testi-inst">Peserta Magang — SMK Telkom Makassar</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal">
                <div class="testi-quote-icon">"</div>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">Platform-nya responsif dan tampilannya sangat bersih — cocok untuk program kampus maupun industri. Rekomendasi banget!</p>
                <div class="testi-author">
                    <div class="testi-avatar">SR</div>
                    <div>
                        <div class="testi-name">Siti Rahma M.Pd</div>
                        <div class="testi-inst">Koordinator — Universitas Negeri Makassar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PARTNERS ===== -->
<section id="partners" class="section-partners">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow">Partner</span>
            <h2 class="section-title">Institusi yang Telah Bergabung</h2>
            <p class="section-desc">Bergabunglah bersama institusi terkemuka yang sudah mempercayakan manajemen magang kepada Simagang.</p>
        </div>
        <div class="partners-grid">
            @php $partners = $partners ?? []; @endphp
            @forelse($partners as $partner)
                <div class="partner-card reveal">
                    <img src="{{ $partner }}" alt="Logo partner">
                </div>
            @empty
                <div class="partner-empty reveal">
                    <i class="fas fa-building" style="font-size:2rem; color:#bfdbfe; margin-bottom:0.75rem; display:block"></i>
                    <p style="margin:0; font-size:15px">Belum ada logo partner yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ===== CTA / PENDAFTARAN ===== -->
<section class="section-cta">
    <div class="container">
        <div class="cta-inner">
            <div class="reveal">
                <div class="cta-tag">Pendaftaran Institusi</div>
                <h2 class="cta-title">Khusus untuk Sekolah & Kampus</h2>
                <p class="cta-desc">Bergabunglah sekarang dan mulai kelola program magang institusi Anda dengan lebih efisien dan profesional bersama Simagang.</p>
                <div style="margin-top:2rem; display:flex; gap:1.5rem; flex-wrap:wrap;">
                    <div style="display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.65); font-size:14px">
                        <i class="fas fa-check-circle" style="color:#22d3ee; font-size:16px"></i>
                        Gratis untuk institusi pendidikan
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.65); font-size:14px">
                        <i class="fas fa-check-circle" style="color:#22d3ee; font-size:16px"></i>
                        Dukungan teknis 24/7
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.65); font-size:14px">
                        <i class="fas fa-check-circle" style="color:#22d3ee; font-size:16px"></i>
                        Setup dalam hitungan menit
                    </div>
                </div>
            </div>
            <div class="cta-cards reveal">
                <a href="#" class="cta-card">
                    <div class="cta-card-left">
                        <div class="cta-card-icon" style="background:linear-gradient(135deg,#0ea5e9,#22d3ee)">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="cta-card-name">Sekolah / SMK</div>
                            <div class="cta-card-sub">Daftar melalui Tata Usaha (TU)</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right cta-arrow"></i>
                </a>
                <a href="#" class="cta-card">
                    <div class="cta-card-left">
                        <div class="cta-card-icon" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="cta-card-name">Universitas / Kampus</div>
                            <div class="cta-card-sub">Wajib melalui Departemen terkait</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right cta-arrow"></i>
                </a>
                <a href="{{ route('register') }}" class="cta-card" style="background:rgba(34,211,238,0.12); border-color:rgba(34,211,238,0.3)">
                    <div class="cta-card-left">
                        <div class="cta-card-icon" style="background:linear-gradient(135deg,#22d3ee,#38bdf8)">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <div class="cta-card-name">Daftar Sebagai Peserta</div>
                            <div class="cta-card-sub">Langsung mulai perjalanan magang Anda</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right cta-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</section>

</main>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <p style="margin:0">&copy; 2025 <span>Simagang</span> — Kementerian Komunikasi & Digital Republik Indonesia. Seluruh hak dilindungi.</p>
</footer>

<script>
    /* Scroll reveal */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, entry.target.dataset.delay || 0);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach((el, i) => {
        el.dataset.delay = (i % 3) * 100;
        observer.observe(el);
    });

    /* Active nav link */
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a');
    const navObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.style.background = '';
                    link.style.color = '';
                    if (link.getAttribute('href') === '#' + entry.target.id) {
                        link.style.background = '#eff6ff';
                        link.style.color = '#1d6fca';
                    }
                });
            }
        });
    }, { threshold: 0.5 });
    sections.forEach(s => navObserver.observe(s));
</script>

</body>
</html>