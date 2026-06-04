<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simagang - Sistem Manajemen Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ url('storage/vendor/icon-komdigi.png') }}">
    <link rel="shortcut icon" href="{{ url('storage/vendor/icon-komdigi.png') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        @font-face {
            font-family: 'Etna';
            src: url('/fonts/Etna-Free-Font.otf') format('opentype');
        }
        .font-etna { font-family: 'Etna', sans-serif; }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
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
        .logo-wrap {
            width: 36px;
            height: 36px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .logo-wrap img { width: 24px; height: 24px; object-fit: contain; }
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
        .nav-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            border: 1.5px solid rgba(14,99,201,0.18);
            background: white;
            color: #1d6fca;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .nav-toggle:hover { background: #eff6ff; }
        .mobile-menu {
            position: absolute;
            top: 70px;
            right: 1rem;
            width: min(280px, calc(100% - 2rem));
            background: white;
            border: 1px solid #dbeafe;
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(14,99,201,0.12);
            display: none;
            flex-direction: column;
            gap: 0.65rem;
            padding: 0.85rem 0.9rem 1rem;
            z-index: 55;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            display: block;
            text-decoration: none;
            color: #0f2d4a;
            font-weight: 600;
            padding: 12px 16px;
            border-radius: 14px;
            transition: background 0.2s, color 0.2s;
        }
        .mobile-menu a:hover { background: #eff6ff; }
        .mobile-menu .login-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #1d6fca;
            color: white;
            border-radius: 14px;
            padding: 12px 16px;
        }
        .mobile-menu .login-link:hover { background: #0ea5e9; }

        /* ── HERO ── */
        .hero {
            position: relative;
            overflow: hidden;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }

        .hero-bg-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                105deg,
                rgba(8, 28, 70, 0.53) 0%,
                rgba(12, 52, 120, 0.70) 50%,
                rgba(8, 60, 100, 0.347) 100%
            );
            z-index: 1;
        }

        .hero-accent {
            position: absolute;
            bottom: -120px;
            left: -80px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34,211,238,0.18) 0%, transparent 70%);
            z-index: 2;
            pointer-events: none;
            animation: pulseAccent 6s ease-in-out infinite alternate;
        }
        @keyframes pulseAccent {
            from { transform: scale(1); opacity: 0.8; }
            to   { transform: scale(1.15); opacity: 1; }
        }

        .hero-inner {
            position: relative;
            z-index: 3;
            max-width: 1280px;
            margin: 0 auto;
            padding: 5rem 1.5rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            width: 100%;
        }

        .hero-text-col {
            display: flex;
            flex-direction: column;
        }

        .hero-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.15;
            color: white;
            margin: 0 0 1.25rem;
            text-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }
        .hero-title span { color: #7dd3fc; }

        .hero-desc {
            font-size: 1rem;
            line-height: 1.75;
            color: rgba(255,255,255,0.82);
            margin: 0;
            max-width: 480px;
            text-shadow: 0 1px 8px rgba(0,0,0,0.25);
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 1.5rem;
            padding-bottom: 1.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .hero-stat-num { font-size: 1.75rem; font-weight: 800; color: white; line-height: 1; text-shadow: 0 2px 12px rgba(0,0,0,0.2); }
        .hero-stat-label { font-size: 11px; color: rgba(255,255,255,0.65); margin-top: 4px; }
        .hero-stat-divider { width: 1px; background: rgba(255,255,255,0.2); flex-shrink: 0; }

        .hero-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 1.75rem;
        }
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
            box-shadow: 0 6px 28px rgba(34,211,238,0.35);
            transition: all 0.25s;
        }
        .btn-primary:hover { background: #38bdf8; transform: translateY(-2px); box-shadow: 0 10px 36px rgba(34,211,238,0.45); }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.4);
            color: white;
            font-weight: 600;
            font-size: 15px;
            border-radius: 9999px;
            text-decoration: none;
            backdrop-filter: blur(6px);
            transition: all 0.25s;
        }
        .btn-outline:hover { background: rgba(255,255,255,0.28); border-color: rgba(255,255,255,0.6); }

        .hero-image-wrap {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        .hero-image-card {
            width: 100%;
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 12px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,255,255,0.05);
        }
        .hero-image-card img {
            width: 100%;
            max-width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            border-radius: 12px;
        }

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
        .section-eyebrow-alt {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #1d6fca;
            background: #c7dfff;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 1rem;
        }
        .section-title { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; color: #0f2d4a; margin: 0 0 1rem; line-height: 1.2; }
        .section-desc { font-size: 1.05rem; color: #4b6580; line-height: 1.7; margin: 0; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1.5rem; }

        /* ── PROCESS ── */
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
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 22px;
            margin-bottom: 1.5rem;
            position: relative;
            box-shadow: 0 8px 24px rgba(29,111,202,0.3);
        }
        .process-title { font-size: 1.2rem; font-weight: 700; color: #0f2d4a; margin: 0 0 0.6rem; }
        .process-desc { font-size: 0.95rem; color: #4b6580; line-height: 1.6; margin: 0; }

        .process-carousel { display: none; overflow: hidden; }
        .testi-carousel  { display: none; overflow: hidden; }
        .carousel-wrapper { display: flex; transition: transform 0.4s ease-out; }
        .carousel-item { flex: 0 0 100%; min-width: 100%; }
        .carousel-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .carousel-btn {
            width: 40px; height: 40px; border-radius: 50%;
            background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1d6fca;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.3s; font-size: 13px;
        }
        .carousel-btn:hover { background: #1d6fca; color: white; border-color: #1d6fca; }
        .carousel-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .dot-wrap { display: flex; gap: 0.5rem; }
        .dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #dbeafe; cursor: pointer; transition: all 0.3s;
        }
        .dot.active { background: #1d6fca; width: 24px; border-radius: 4px; }

        /* ── USAGE / TUTORIAL ── */
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
            font-size: 11px; font-weight: 700; letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 5px 12px; border-radius: 50px; margin-bottom: 1rem;
        }
        .step-icon-wrap {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px;
            box-shadow: 0 6px 20px rgba(29,111,202,0.28);
            margin-bottom: 1.25rem;
        }
        .step-title { font-size: 1.75rem; font-weight: 800; color: #0f2d4a; margin: 0 0 1rem; }
        .step-desc { font-size: 1.05rem; color: #4b6580; line-height: 1.75; margin: 0; }
        .step-list { list-style: none; padding: 0; margin: 1.25rem 0 0; display: flex; flex-direction: column; gap: 10px; }
        .step-list li {
            display: flex; align-items: center; gap: 10px;
            font-size: 0.95rem; color: #4b6580;
        }
        .step-list li::before {
            content: '';
            width: 22px; height: 22px; min-width: 22px;
            background: #eff6ff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%231d6fca'%3E%3Cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.172l6.879-6.879a1 1 0 011.414 0z' clip-rule='evenodd'/%3E%3C/svg%3E") center/13px no-repeat;
            border: 1.5px solid #93c5fd;
            border-radius: 50%;
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
            display: flex; flex-direction: column;
            min-height: 320px;
        }
        .testi-card:hover { transform: translateY(-4px); box-shadow: 0 16px 44px rgba(14,99,201,0.1); }
        .testi-quote-icon { font-size: 2.5rem; color: #bfdbfe; line-height: 1; margin-bottom: 1rem; }
        .testi-stars { color: #f59e0b; font-size: 13px; margin-bottom: 0.75rem; letter-spacing: 2px; }
        .testi-text { font-size: 1rem; color: #4b6580; line-height: 1.7; margin: 0 0 1.5rem; font-style: italic; flex-grow: 1; }
        .testi-author { display: flex; align-items: center; gap: 12px; padding-top: 1.25rem; border-top: 1px solid #bfdbfe; }
        .testi-avatar {
            width: 48px; height: 48px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1d6fca, #0ea5e9); color: white; font-weight: 700; font-size: 15px;
        }
        .testi-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
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
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s;
        }
        .partner-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(14,99,201,0.1); border-color: #93c5fd; }
        .partner-card img { max-height: 64px; object-fit: contain; filter: none ; transition: filter 0.3s; }
        .partner-card:hover img {transform: scale(1.05); }
        .partner-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            color: #64748b;
            background: white;
            border-radius: 20px;
            border: 1.5px dashed #bfdbfe;
        }

        /* ── CTA ── */
        .section-cta { background: linear-gradient(135deg, #0c2d5e 0%, #1251a3 50%, #0891b2 100%); padding: 6rem 0; }
        .cta-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
        .cta-tag {
            display: inline-block;
            background: rgba(34,211,238,0.18);
            border: 1px solid rgba(34,211,238,0.3);
            color: #67e8f9;
            font-size: 11px; font-weight: 700; letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 5px 14px; border-radius: 50px; margin-bottom: 1rem;
        }
        .cta-title { font-size: 2.25rem; font-weight: 800; color: white; margin: 0 0 1rem; line-height: 1.2; }
        .cta-desc { font-size: 1.05rem; color: rgba(255,255,255,0.65); line-height: 1.7; margin: 0; }
        .cta-cards { display: flex; flex-direction: column; gap: 1rem; }
        .cta-card {
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 20px; padding: 1.25rem 1.5rem;
            text-decoration: none; color: white;
            transition: all 0.25s; cursor: pointer;
        }
        .cta-card:hover { background: rgba(255,255,255,0.14); border-color: rgba(255,255,255,0.25); transform: translateX(4px); }
        .cta-card-left { display: flex; align-items: center; gap: 14px; }
        .cta-card-icon {
            width: 46px; height: 46px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white; flex-shrink: 0;
        }
        .cta-card-name { font-weight: 700; font-size: 15px; }
        .cta-card-sub { font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 2px; }
        .cta-arrow { font-size: 20px; opacity: 0.6; }

        /* ── FOOTER ── */
        .main-footer {
            background:  linear-gradient(135deg, #10499e 100%, #0e60cc 40%, #0891b2 30%);
            color: white;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            border-top: 1px solid rgba(34, 211, 238, 0.3);
            backdrop-filter: blur(10px); 
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.3);
        }

        .footer-simple-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-logos-simple, 
        .social-links-simple {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .footer-logos-simple {
            gap: 1.5rem;
        }

        .footer-logos-simple img {
            height: 28px;
            object-fit: contain;
            /* Membuat logo sedikit lebih terang agar kontras */
            filter: drop-shadow(0 0 5px rgba(255,255,255,0.1));
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .footer-logos-simple img:hover {
            transform: translateY(-5px) scale(1.1);
            filter: drop-shadow(0 5px 15px rgba(34, 211, 238, 0.4));
        }

        .copyright-simple {
            flex: 1.5;
            text-align: center;
            font-size: 13px;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.8);
        }

        .copyright-simple strong {
            color: #22d3ee;
            text-shadow: 0 0 10px rgba(34, 211, 238, 0.3);
        }

        .social-links-simple {
            justify-content: flex-end;
            gap: 12px;
        }

        .social-links-simple a {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .social-links-simple a:hover {
            background: rgba(34, 211, 238, 0.15);
            color: #22d3ee;
            border-color: #22d3ee;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(34, 211, 238, 0.2);
        }

        /* Padding body agar konten tidak tertutup fixed footer */
        body { padding-bottom: 60px; } /* tinggi footer desktop */

        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .main-footer { padding: 10px 0; }
            .footer-simple-inner { flex-direction: column; gap: 8px; padding: 4px 1rem; }
            .copyright-simple { order: 3; font-size: 11px; }
            .footer-logos-simple { order: 1; justify-content: center; }
            .social-links-simple { order: 2; justify-content: center; }
            /* Tambah padding bawah lebih besar di mobile karena footer jadi lebih tinggi (stacked) */
            body { padding-bottom: 110px; }
        }


        /* Newsletter Input matching your theme */
        .newsletter-form { display: flex; gap: 8px; margin-top: 1.25rem; }
        .newsletter-form input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 12px 16px;
            border-radius: 12px;
            color: white;
            flex-grow: 1;
            font-size: 14px;
            outline: none;
        }
        .newsletter-form input:focus { border-color: #22d3ee; background: rgba(255,255,255,0.1); }
        
        .newsletter-btn {
            background: #22d3ee; /* Sesuai warna btn-primary Anda */
            color: #0c2d5e;
            padding: 0 20px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .newsletter-btn:hover { background: #38bdf8; transform: translateY(-2px); }

        .social-links { display: flex; gap: 12px; margin-top: 1.5rem; }
        .social-links a {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px; color: white; transition: 0.3s;
        }
        .social-links a:hover { 
            background: #22d3ee; 
            color: #0c2d5e;
            transform: translateY(-5px); 
            box-shadow: 0 10px 20px rgba(34,211,238,0.2);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .partner-logos {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3rem;
            align-items: center;
        }
        .partner-logos img { 
            height: 30px; 
            opacity: 1; 
            transition: transform 0.3s;
            object-fit: contain;
        }
        .partner-logos img:hover { transform: scale(1.1); }

        .copyright { font-size: 13px; color: rgba(255,255,255,0.4); text-align: center; }
        .copyright span { color: #22d3ee; font-weight: 600; }


        /* ── MODERN NEWS SECTION ── */
        .news-container {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
        }

        /* Berita Utama (Kiri) */
        .news-main-card {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            height: 500px;
            cursor: pointer;
        }

        .news-main-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .news-main-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(2, 11, 26, 0.95), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
        }

        /* Daftar Berita Samping (Kanan) */
        .news-side-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .news-side-item {
            display: flex;
            gap: 20px;
            background: white;
            padding: 15px;
            border-radius: 18px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 242, 255, 0.05);
            text-decoration: none;
        }

        .news-side-item:hover {
            border-color: #00f2ff;
            transform: translateX(10px);
            box-shadow: 0 10px 20px rgba(0, 242, 255, 0.05);
        }

        .news-side-img {
            width: 120px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
        }

        .news-side-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .news-side-title {
            font-size: 15px;
            font-weight: 700;
            color: #020b1a;
            line-height: 1.4;
            margin-bottom: 5px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .news-container { grid-template-columns: 1fr; }
            .news-main-card { height: 350px; }
        }


        /* ── SCROLL ANIMATION ── */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hero { min-height: auto; }
            .hero-inner {
                grid-template-columns: 1fr;
                padding: 3.5rem 1.5rem;
                gap: 2.5rem;
                text-align: center;
            }
            /* .hero-badge { align-self: center; } */
            .hero-desc { margin-left: auto; margin-right: auto; }
            .hero-stats { justify-content: center; }
            .hero-btns { justify-content: center; }
            .hero-image-wrap { justify-content: center; max-width: 520px; margin: 0 auto; order: -1; }
            .process-grid { grid-template-columns: 1fr; }
            .step-block { grid-template-columns: 1fr; gap: 2rem; padding: 2rem 0; }
            .step-block .order-swap { order: 0; }
            .step-block .step-image-wrap { order: -1; }
            .testi-grid { grid-template-columns: 1fr; }
            .partners-grid { grid-template-columns: repeat(2, 1fr); }
            .cta-inner { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .nav-toggle { display: inline-flex; }
            .btn-login { display: none; }
        }
        @media (max-width: 640px) {
            .hero-inner { padding: 2.5rem 1rem; gap: 1.5rem; }
            .hero-title { font-size: 1.8rem; }
            .hero-image-wrap { max-width: 100%; }
            .partners-grid { grid-template-columns: 1fr 1fr; }
            .process-grid { display: none; }
            .process-carousel { display: block; }
            .testi-grid { display: none; }
            .testi-carousel { display: block; }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
    <div class="navbar-inner">
        <a href="#hero" class="nav-logo">
            <div class="logo-wrap">
                <img src="{{ url('storage/vendor/logo_komdigi.png') }}" alt="Komdigi">
            </div>
            <div>
                <div class="font-etna" style="font-size:20px; font-weight:900; line-height:1.1">
                    <span style="color:#9d272a">SI</span><span style="color:#086bb0">MA</span><span style="color:#2dabe2">GA</span><span style="color:#efc400">NG</span>
                </div>
                <div class="font-etna" style="font-size:10px; color:#8ea5bc; margin-top:2px">Sistem Manajemen Magang</div>
            </div>
        </a>

        <nav class="nav-links">
            <a href="#hero">Beranda</a>
            <a href="#process">Alur</a>
            <a href="#usage">Fitur</a>
            <a href="#testimonials">Testimoni</a>
            <a href="#partners">Mitra</a>
            <a href="#news" class="text-gray-700 hover:text-blue-600 font-medium transition">Aktivitas</a>
            <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang Kami</a>
        </nav>

        <button type="button" class="nav-toggle" aria-label="Buka menu" aria-expanded="false">
            <i class="fas fa-bars" style="font-size:18px"></i>
        </button>

        <div class="mobile-menu" aria-hidden="true">
            <a href="#hero">Beranda</a>
            <a href="#process">Tahapan</a>
            <a href="#usage">Fitur</a>
            <a href="#testimonials">Testimoni</a>
            <a href="#partners">Partner</a>
            <a href="#news" class="text-gray-700 hover:text-blue-600 font-medium transition">Aktivitas</a>
            <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang Kami</a>
            <a href="{{ route('login') }}" class="login-link">
                <i class="fas fa-sign-in-alt" style="font-size:13px; margin-right:8px"></i>Login
            </a>
        </div>

        <a href="{{ route('login') }}" class="btn-login">
            <i class="fas fa-sign-in-alt" style="font-size:13px"></i>
            Login
        </a>
    </div>
</header>

<main>

<!-- ===== HERO ===== -->
<section id="hero" class="hero">
    <!-- Background image — ganti path sesuai lokasi foto Anda -->
    <img src="{{ asset('storage/photos-landingpage/hero-bg.png') }}" alt="" class="hero-bg-image" aria-hidden="true">
    <!-- Dark transparent overlay agar teks tetap terbaca -->
    <div class="hero-overlay"></div>
    <!-- Accent glow kiri bawah -->
    <div class="hero-accent"></div>

    <div class="hero-inner">

        <div class="hero-text-col">
            <h1 class="hero-title">
                Sistem Magang Terbaik untuk <span>Kampus dan Sekolah</span> 
            </h1>

            <p class="hero-desc">
                Nikmati pengalaman terbaik dengan mitra terpercaya. Ada Banyak Hal Besar yang Perlu dilakukan di Masa Depan. Saatnya tumbuh sebagai talenta profesional dan buktikan keahlianmu bersama BBLSDM Komdigi Makassar sekarang.
            </p>

            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num text-center">{{ $totalPesertaAktif }}</div>
                    <div class="hero-stat-label">Peserta Magang</div>
                </div>
                <div class="hero-stat-divider"></div>
                <div>
                    <div class="hero-stat-num text-center">11+</div>
                    <div class="hero-stat-label">Mitra pendidikan dan industri</div>
                </div>
                <div class="hero-stat-divider"></div>
                <div>
                    <div class="hero-stat-num text-center">93.25</div>
                    <div class="hero-stat-label">Tingkat Kepuasan</div>
                </div>
            </div>

            <div class="hero-btns">
                <a href="#daftar" class="btn-primary">
                    <i class="fas fa-rocket" style="font-size:14px"></i>
                    Daftar Sekarang
                </a>
                <a href="#usage" class="btn-outline">
                    Lihat Fitur
                    <i class="fas fa-arrow-right" style="font-size:13px"></i>
                </a>
            </div>

        </div>

        {{-- <div class="hero-image-wrap">
            <div class="hero-image-card">
                <img src="{{ asset('storage/photos-landingpage/hero.png') }}" alt="Dashboard Simagang">
            </div>
        </div> --}}

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

        <!-- Desktop Grid -->
        <div class="process-grid">
            <div class="process-card reveal">
                <div class="process-num">01</div>
                <div class="process-icon"><i class="fas fa-user-plus"></i></div>
                <h3 class="process-title">Pendaftaran & Profil Peserta</h3>
                <p class="process-desc">Daftarkan diri Anda, lengkapi profil. Selanjutnya, biarkan sistem yang mengurus onboarding Anda secara cepat dan praktis.</p>
            </div>
            <div class="process-card reveal">
                <div class="process-num">02</div>
                <div class="process-icon"><i class="fas fa-calendar-check"></i></div>
                <h3 class="process-title">Manajemen Aktivitas</h3>
                <p class="process-desc">Sistem ini menyediakan fitur yang menarik untuk monitoring kehadiran, logbook harian, evaluasi, serta rekomendasi pengembangan kompetensi yang relevan.</p>
            </div>
            <div class="process-card reveal">
                <div class="process-num">03</div>
                <div class="process-icon"><i class="fas fa-award"></i></div>
                <h3 class="process-title">Laporan & Sertifikat</h3>
                <p class="process-desc">Nikmati pengalaman baru, upload laporan, terima feedback mentor, dan dapatkan sertifikat digital resmi secara otomatis.</p>
            </div>
        </div>

        <!-- Mobile Carousel -->
        <div class="process-carousel" id="process-carousel">
            <div class="carousel-wrapper" id="process-wrapper">
                <div class="carousel-item">
                    <div class="process-card">
                        <div class="process-num">01</div>
                        <div class="process-icon"><i class="fas fa-user-plus"></i></div>
                        <h3 class="process-title">Daftar & Profil</h3>
                        <p class="process-desc">Isi data peserta dan pilih institusi asal dengan cepat.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="process-card">
                        <div class="process-num">02</div>
                        <div class="process-icon"><i class="fas fa-calendar-check"></i></div>
                        <h3 class="process-title">Absensi & Logbook</h3>
                        <p class="process-desc">Catat kehadiran dan aktivitas magang setiap hari secara digital.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="process-card">
                        <div class="process-num">03</div>
                        <div class="process-icon"><i class="fas fa-award"></i></div>
                        <h3 class="process-title">Laporan & Sertifikat</h3>
                        <p class="process-desc">Upload laporan akhir dan dapatkan sertifikat digital resmi.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-nav">
                <button class="carousel-btn" id="process-prev"><i class="fas fa-chevron-left"></i></button>
                <div class="dot-wrap" id="process-dots">
                    <div class="dot active"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <button class="carousel-btn" id="process-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</section>

<!-- ===== FITUR / PENGGUNAAN ===== -->
<section id="usage" class="section-usage">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow-alt">Fitur</span>
            <h2 class="section-title">
                Fitur Aplikasi
                {{-- <span class="font-etna" style="color:#9d272a">SI</span><span class="font-etna" style="color:#086bb0">MA</span><span class="font-etna" style="color:#2dabe2">GA</span><span class="font-etna" style="color:#efc400">NG</span> --}}
            </h2>
            <p class="section-desc">Ikuti langkah-langkah berikut untuk memahami alur penggunaan aplikasi secara cepat dan mudah.</p>
        </div>

        <!-- Step 1 -->
        <div class="step-block reveal">
            <div class="step-image-wrap flex justify-center w-full">
                <div class="relative w-full max-w-[260px] sm:max-w-[300px] mx-auto group">
                    <img src="{{ asset('storage/tutorial/frame.png') }}" alt="Phone Frame" class="relative z-10 w-full h-auto drop-shadow-2xl pointer-events-none">
                    <div class="absolute top-[2.5%] bottom-[2.5%] left-[5%] right-[5%] z-0 overflow-hidden rounded-[1.8rem] sm:rounded-[2.2rem] bg-white bg-no-repeat bg-top group-hover:bg-bottom" 
                         style="background-image: url('{{ asset('storage/tutorial/dashboard.png') }}'); background-size: 100% auto; transition: background-position 6s ease-in-out;">
                    </div>
                </div>
            </div>
            <div>
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Fitur 1</div>
                <div class="step-icon-wrap"><i class="fas fa-home"></i></div>
                <h3 class="step-title">Pilih Layanan Dashboard</h3>
                <p class="step-desc">Setelah login, Anda akan melihat ringkasan aktivitas magang, status absensi, dan akses cepat untuk laporan serta mikro skill.</p>
                <ul class="step-list">
                    <li>Informasi hadir, izin, dan sakit secara real time</li>
                    <li>Status laporan dan mikroskill langsung terlihat</li>
                    <li>Tombol pintas untuk akses absensi dan logbook</li>
                </ul>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step-block reveal">
            <div class="order-swap">
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Fitur 2</div>
                <div class="step-icon-wrap"><i class="fas fa-calendar-check"></i></div>
                <h3 class="step-title">Kelola Absensi</h3>
                <p class="step-desc">Lakukan absensi harian sebagai bukti kehadiran selama kegiatan magang berlangsung secara akurat dan real-time.</p>
                <ul class="step-list">
                    <li>Check-in dan check-out harian secara digital</li>
                    <li>Verifikasi lokasi untuk memastikan kehadiran valid</li>
                    <li>Riwayat absensi tersimpan otomatis</li>
                </ul>
            </div>
            <div class="step-image-wrap flex justify-center w-full">
                <div class="relative w-full max-w-[260px] sm:max-w-[300px] mx-auto group">
                    <img src="{{ asset('storage/tutorial/frame.png') }}" alt="Phone Frame" class="relative z-10 w-full h-auto drop-shadow-2xl pointer-events-none">
                    <div class="absolute top-[2.5%] bottom-[2.5%] left-[5%] right-[5%] z-0 overflow-hidden rounded-[1.8rem] sm:rounded-[2.2rem] bg-white bg-no-repeat bg-top group-hover:bg-bottom" 
                         style="background-image: url('{{ asset('storage/tutorial/absen.jpeg') }}'); background-size: 100% auto; transition: background-position 6s ease-in-out;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step-block reveal">
            <div class="step-image-wrap flex justify-center w-full">
                <div class="relative w-full max-w-[260px] sm:max-w-[300px] mx-auto group">
                    <img src="{{ asset('storage/tutorial/frame.png') }}" alt="Phone Frame" class="relative z-10 w-full h-auto drop-shadow-2xl pointer-events-none">
                    <div class="absolute top-[2.5%] bottom-[2.5%] left-[5%] right-[5%] z-0 overflow-hidden rounded-[1.8rem] sm:rounded-[2.2rem] bg-white bg-no-repeat bg-top group-hover:bg-bottom" 
                         style="background-image: url('{{ asset('storage/tutorial/logbook.png') }}'); background-size: 100% auto; transition: background-position 6s ease-in-out;">
                    </div>
                </div>
            </div>
            <div>
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Fitur 3</div>
                <div class="step-icon-wrap"><i class="fas fa-book"></i></div>
                <h3 class="step-title">Kelola Logbook</h3>
                <p class="step-desc">Catat aktivitas pekerjaan harian untuk mendokumentasikan progres dan hasil kerja selama magang.</p>
                <ul class="step-list">
                    <li>Mencatat aktivitas kerja setiap hari</li>
                    <li>Riwayat kegiatan tersimpan rapi dan terstruktur</li>
                    <li>Dapat dipantau dan direview oleh mentor</li>
                </ul>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="step-block reveal">
            <div class="order-swap">
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Fitur 4</div>
                <div class="step-icon-wrap"><i class="fas fa-file-upload"></i></div>
                <h3 class="step-title">Upload Laporan</h3>
                <p class="step-desc">Kirim laporan akhir magang sebagai bentuk hasil evaluasi dan dokumentasi kegiatan yang telah dilakukan.</p>
                <ul class="step-list">
                    <li>Upload laporan dalam berbagai format file</li>
                    <li>Status laporan dapat dipantau secara langsung</li>
                    <li>Mendapatkan feedback dan revisi dari mentor</li>
                </ul>
            </div>
            <div class="step-image-wrap flex justify-center w-full">
                <div class="relative w-full max-w-[260px] sm:max-w-[300px] mx-auto group">
                    <img src="{{ asset('storage/tutorial/frame.png') }}" alt="Phone Frame" class="relative z-10 w-full h-auto drop-shadow-2xl pointer-events-none">
                    <div class="absolute top-[2.5%] bottom-[2.5%] left-[5%] right-[5%] z-0 overflow-hidden rounded-[1.8rem] sm:rounded-[2.2rem] bg-white bg-no-repeat bg-top group-hover:bg-bottom" 
                         style="background-image: url('{{ asset('storage/tutorial/laporan.png') }}'); background-size: 100% auto; transition: background-position 6s ease-in-out;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="step-block reveal">
            <div class="step-image-wrap flex justify-center w-full">
                <div class="relative w-full max-w-[260px] sm:max-w-[300px] mx-auto group">
                    <img src="{{ asset('storage/tutorial/frame.png') }}" alt="Phone Frame" class="relative z-10 w-full h-auto drop-shadow-2xl pointer-events-none">
                    <div class="absolute top-[2.5%] bottom-[2.5%] left-[5%] right-[5%] z-0 overflow-hidden rounded-[1.8rem] sm:rounded-[2.2rem] bg-white bg-no-repeat bg-top group-hover:bg-bottom" 
                         style="background-image: url('{{ asset('storage/tutorial/mikroskill.png') }}'); background-size: 100% auto; transition: background-position 6s ease-in-out;">
                    </div>
                </div>
            </div>
            <div>
                <div class="step-badge"><i class="fas fa-flag" style="font-size:10px"></i> Fitur 5</div>
                <div class="step-icon-wrap"><i class="fas fa-award"></i></div>
                <h3 class="step-title">Mikroskill & Sertifikat</h3>
                <p class="step-desc">Lengkapi penilaian mikroskill untuk mengukur kompetensi yang diperoleh selama magang dan dapatkan sertifikat resmi.</p>
                <ul class="step-list">
                    <li>Penilaian kompetensi berdasarkan aktivitas</li>
                    <li>Validasi oleh mentor atau pembimbing</li>
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
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <p class="section-desc">Berikut tanggapan positif dan saran konstruktif dari mereka yang telah merasakan serunya pengalaman magang bersama kami.</p>
        </div>

        <!-- Desktop Grid -->
        <div class="testi-grid">
            @php $testimonials = $testimonials ?? []; @endphp
            @forelse($testimonials as $testimony)
                <div class="testi-card reveal">
                    <div class="testi-quote-icon">"</div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">{{ Str::limit($testimony->testimony, 150) }}</p>
                    <div class="testi-author">
                        <div class="testi-avatar">
                            <img src="{{ asset('storage/' . ($testimony->intern->photo_path ?? 'profiles/default.jpg')) }}" alt="{{ $testimony->intern->name }}">
                        </div>
                        <div>
                            <div class="testi-name">{{ $testimony->intern->name }}</div>
                            <div class="testi-inst">Mahasiswa — {{ $testimony->intern->institution ?? 'Institusi' }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:2rem">
                    <p style="color:#4b6580;font-size:1.05rem;margin:0">Belum ada testimoni. Jadilah yang pertama berbagi pengalaman Anda!</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile Carousel -->
        @if(count($testimonials ?? []) > 0)
        <div class="testi-carousel" id="testi-carousel">
            <div class="carousel-wrapper" id="testi-wrapper">
                @foreach($testimonials as $testimony)
                <div class="carousel-item">
                    <div class="testi-card">
                        <div class="testi-quote-icon">"</div>
                        <div class="testi-stars">★★★★★</div>
                        <p class="testi-text">{{ Str::limit($testimony->testimony, 150) }}</p>
                        <div class="testi-author">
                            <div class="testi-avatar">
                                <img src="{{ asset('storage/' . ($testimony->intern->photo_path ?? 'profiles/default.jpg')) }}" alt="{{ $testimony->intern->name }}">
                            </div>
                            <div>
                                <div class="testi-name">{{ $testimony->intern->name }}</div>
                                <div class="testi-inst">Mahasiswa — {{ $testimony->intern->institution ?? 'Institusi' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="carousel-nav">
                <button class="carousel-btn" id="testi-prev"><i class="fas fa-chevron-left"></i></button>
                <div class="dot-wrap" id="testi-dots">
                    @foreach($testimonials as $i => $t)
                    <div class="dot{{ $i === 0 ? ' active' : '' }}"></div>
                    @endforeach
                </div>
                <button class="carousel-btn" id="testi-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- ===== PARTNERS ===== -->
<section id="partners" class="section-partners">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow-alt">Mitra</span>
            <h2 class="section-title">Institusi Pendidikan dan Industri yang Telah Bergabung</h2>
            <p class="section-desc">Dengan simagang, bersama kita menciptakan sistem magang yang mudah, transparan dan terkendali guna menciptakan pengalaman kerja yang seru, dinamis dan menyenangkan bagi para talenta muda.</p>
        </div>
        <div class="partners-grid">
            @php $partners = $partners ?? []; @endphp
            @forelse($partners as $partner)
                <div class="partner-card reveal">
                    <img src="{{ $partner }}" alt="Logo partner">
                </div>
            @empty
                <div class="partner-empty reveal">
                    <i class="fas fa-building" style="font-size:2rem;color:#bfdbfe;margin-bottom:0.75rem;display:block"></i>
                    <p style="margin:0;font-size:15px">Belum ada logo partner yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ===== FOTO/MICRO SKILL ===== -->
<section id="news" class="py-24 bg-[#f8faff]">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-[#020b1a]">Aktivitas Terbaru</h2>
                <div class="h-1 w-20 bg-[#00f2ff] mt-2"></div>
            </div>
        </div>

        <div class="news-container">
    <div class="news-main-card relative group overflow-hidden rounded-[24px] h-[500px]">
        <div id="newsSlider" class="flex transition-transform duration-700 ease-in-out h-full">
            
            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/sharingsession01.jpeg') }}" class="w-full h-full object-cover" alt="Berita 1">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Terbaru</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Sharing Session : Knowledge Management</h3>
                    <p class="text-gray-300 text-sm">5 Mei 2026</p>
                </div>
            </div>

            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/senampagi02.png') }}" class="w-full h-full object-cover" alt="Berita 2">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Kegiatan</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Kamis Bersih & Senam</h3>
                    <p class="text-gray-300 text-sm">16 April 2026</p>
                </div>
            </div>

            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/sharingsession02.jpg') }}" class="w-full h-full object-cover" alt="Berita 3">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Update</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Sharing Session : Bijak Berkomentar di Era Digital</h3>
                    <p class="text-gray-300 text-sm">7 Mei 2026</p>
                </div>
            </div>

            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/diskusi02.jpeg') }}" class="w-full h-full object-cover" alt="Berita 2">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Kegiatan</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Diskusi Bersama Mentor</h3>
                    <p class="text-gray-300 text-sm">1 April 2026</p>
                </div>
            </div>

            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/sharingsession03.jpeg') }}" class="w-full h-full object-cover" alt="Berita 2">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Kegiatan</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Sharing Session : Desain Komunikasi Visual</h3>
                    <p class="text-gray-300 text-sm">1 April 2026</p>
                </div>
            </div>

            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/kerjaproject.webp') }}" class="w-full h-full object-cover" alt="Berita 2">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Kegiatan</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Mengerjakan Project</h3>
                    <p class="text-gray-300 text-sm">12 Februari 2026</p>
                </div>
            </div>


            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/diskusi.jpeg') }}" class="w-full h-full object-cover" alt="Berita 2">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Kegiatan</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Diskusi Kelas</h3>
                    <p class="text-gray-300 text-sm">1 April 2026</p>
                </div>
            </div>

            <div class="min-w-full h-full relative">
                <img src="{{ url('storage/photos-landingpage/sharingsession04.jpeg') }}" class="w-full h-full object-cover" alt="Berita 2">
                <div class="news-main-overlay absolute inset-0 bg-gradient-to-t from-[#020b1a] via-transparent to-transparent flex flex-direction-column justify-end p-10">
                    <span class="bg-[#00f2ff] text-[#020b1a] text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase">Kegiatan</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Sharing Session : Data Visualization</h3>
                    <p class="text-gray-300 text-sm">1 April 2026</p>
                </div>
            </div>

        </div>

        <div class="absolute bottom-5 right-10 flex gap-2">
            <div class="w-2 h-2 rounded-full bg-[#00f2ff] opacity-50"></div>
            <div class="w-2 h-2 rounded-full bg-white opacity-30"></div>
            <div class="w-2 h-2 rounded-full bg-white opacity-30"></div>
        </div>
    </div>

            <div class="news-side-list">
                <a href="{{route('artikel_1')}}" target="_blank" class="news-side-item">
                    <img src="{{ asset('storage/artikel/artikel_1.jpeg') }} " class="news-side-img">
                    <div class="news-side-content">
                        <h4 class="news-side-title">Sharing Session</h4>
                        <p class="text-gray-300 text-sm">Mari kita bahas tentang pentingnya berbagi pengetahuan dan pengalaman dalam dunia digital.</p>
                        <span class="text-[12px] text-gray-400">07 Mei 2026</span>
                    </div>
                </a>

                <a href="{{route('artikel_2')}}" target="_blank" class="news-side-item">
                    <img src="{{ asset('storage/artikel/artikel_2.png') }}" class="news-side-img">
                    <div class="news-side-content">
                        <h4 class="news-side-title">Emang Gen Z lebih jago soal keamanan digital? - Podcast Capila 2026 Episode 1</h4>
                        <p class="text-gray-300 text-sm">Apakah Gen Z benar-benar lebih mahir dalam menghadapi ancaman keamanan digital dibandingkan generasi sebelumnya? Mari kita bahas dalam podcast Capila 2026 Episode 1.</p>
                        <span class="text-[12px] text-gray-400">06 Mei 2026</span>
                    </div>
                </a>

                <a href="{{route('artikel_3')}}" target="_blank" class="news-side-item">
                    <img src="{{ asset('storage/artikel/artikel_3_1.png') }}" class="news-side-img">
                    <div class="news-side-content">
                        <h4 class="news-side-title">Senam Sehat & Bersih</h4>
                        <p class="text-gray-300 text-sm">Mari kita bahas tentang pentingnya berbagi pengetahuan dan pengalaman dalam dunia digital.</p>
                        <span class="text-[12px] text-gray-400">05 Mei 2026</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== ABOUT US / TIM KAMI ===== -->
<style>
.team-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    border: 1.5px solid #e8edf5;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}
.team-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px_40px rgba(14,99,201,0.13);
}
.team-card-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    object-position: top center;
    display: block;
}
.team-card-body {
    padding: 1.1rem 1.2rem 1.2rem;
    text-align: left;
}
.team-card-name {
    font-weight: 700;
    font-size: 1.05rem;
    color: #0f2d4a;
    margin-bottom: 2px;
}
.team-card-role {
    font-size: 0.82rem;
    color: #6b7d93;
    margin-bottom: 0.75rem;
}
.team-card-socials {
    display: flex;
    gap: 8px;
}
.team-card-social-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e8f4fd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1d6fca;
    font-size: 13px;
    transition: background 0.25s, color 0.25s;
    text-decoration: none;
}
.team-card-social-btn:hover {
    background: #1d6fca;
    color: #fff;
}
.team-join-card {
    background: linear-gradient(145deg, #0f2d4a 0%, #1a4a72 100%);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    min-height: 340px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.team-join-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 1.5rem;
}
.team-join-logo-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #22d3ee, #0ea5e9);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
}
.team-join-logo-text {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
}
.team-join-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.35;
    margin-bottom: 0.75rem;
}
.team-join-desc {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}
.team-join-btn {
    display: inline-block;
    background: linear-gradient(90deg, #22d3ee, #0ea5e9);
    color: #fff;
    font-weight: 700;
    font-size: 0.78rem;
    letter-spacing: 0.08em;
    padding: 0.6rem 1.4rem;
    border-radius: 999px;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.2s;
    text-transform: uppercase;
}
.team-join-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    color: #fff;
}

/* ══════════════════════════════════════════
   TIM PENGEMBANG — REDESIGN (matching screenshot)
   ══════════════════════════════════════════ */
.team-tabs-section {
    background: linear-gradient(160deg, #071830 0%, #0c1d45 35%, #0a2d5e 65%, #071830 100%);
    padding: 5rem 0 5rem;
    position: relative;
    overflow: hidden;
}

/* ── Dot grid overlay ── */
.team-tabs-section::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(34,211,238,0.10) 1px, transparent 1px);
    background-size: 38px 38px;
    pointer-events: none;
    mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 0%, transparent 100%);
    -webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 0%, transparent 100%);
}

/* ── Section title ── */
.team-tabs-title {
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 2.5rem;
    letter-spacing: -0.02em;
    line-height: 1.15;
    text-align: center;
}

/* ── Tab nav ── */
.team-tabs-nav {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
}
.team-tab-btn {
    padding: 0.6rem 1.75rem;
    border-radius: 999px;
    border: 1.5px solid rgba(255,255,255,0.18);
    background: transparent;
    color: rgba(255,255,255,0.65);
    font-family: 'Poppins', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    letter-spacing: 0.01em;
}
.team-tab-btn:hover {
    border-color: rgba(34,211,238,0.5);
    color: #fff;
    background: rgba(34,211,238,0.08);
}
.team-tab-btn.active {
    background: linear-gradient(135deg, #1d6fca, #22d3ee);
    color: #fff;
    border-color: transparent;
    font-weight: 700;
    box-shadow: 0 4px 20px rgba(34,211,238,0.35);
}

/* ── Tab panels ── */
.team-tab-panel { display: none; }
.team-tab-panel.active {
    display: block;
    animation: fadeInPanel 0.4s ease;
}
@keyframes fadeInPanel {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Members grid (desktop) ── */
.team-members-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.1rem;
    position: relative;
    z-index: 2;
}
#tab-angkatan1 .team-members-grid,
#tab-angkatan2 .team-members-grid {
    grid-template-columns: repeat(6, 1fr);
    gap: 0.9rem;
}
@media (max-width: 1280px) { 
    #tab-angkatan1 .team-members-grid,
    #tab-angkatan2 .team-members-grid { grid-template-columns: repeat(3, 1fr); } 
}
@media (max-width: 1024px) { .team-members-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { 
    #tab-angkatan1 .team-members-grid,
    #tab-angkatan2 .team-members-grid { grid-template-columns: repeat(2, 1fr); } 
}
@media (max-width: 768px)  { .team-members-grid { grid-template-columns: repeat(2, 1fr); } }

/* ── Mobile carousel (≤480px) ── */
@media (max-width: 480px) {
    /* wrapper menjadi overflow container */
    .team-carousel-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        z-index: 2;
    }
    /* track yang bisa digeser */
    .team-members-grid {
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 0 !important;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform;
        grid-template-columns: unset !important;
    }
    /* tiap kartu = 1 slide, ukuran lebih kecil dan center */
    .team-members-grid .tmember-card {
        flex: 0 0 100%;
        width: 100%;
        min-width: 100%;
        animation: none !important;
        display: flex;
        justify-content: center;
        aspect-ratio: unset;
        background: transparent;
        box-shadow: none;
        border-radius: 0;
        overflow: visible;
    }
    .team-members-grid .tmember-card .tmember-photo-wrap {
        position: relative;
        inset: unset;
        width: 65%;
        max-width: 240px;
        aspect-ratio: 3 / 4;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 28px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.06);
    }

    /* dot indicator bawah */
    .team-carousel-dots {
        display: flex !important;
        justify-content: center;
        gap: 7px;
        margin-top: 1rem;
    }
    .team-carousel-dots .cdot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.25);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .team-carousel-dots .cdot.active {
        background: #22d3ee;
        box-shadow: 0 0 8px rgba(34,211,238,0.6);
        transform: scale(1.25);
        width: 22px;
        border-radius: 4px;
    }

    /* progress bar tipis di atas dots */
    .team-carousel-progress {
        display: block !important;
        height: 2px;
        background: rgba(255,255,255,0.1);
        border-radius: 2px;
        margin-top: 0.75rem;
        overflow: hidden;
    }
    .team-carousel-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #1d6fca, #22d3ee);
        border-radius: 2px;
        transition: width 0.1s linear;
    }
}

/* sembunyikan dots & progress di desktop */
.team-carousel-dots { display: none; }
.team-carousel-progress { display: none; }

/* ── Member card ── */
.tmember-card {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    cursor: default;
    aspect-ratio: 3 / 4;
    box-shadow:
        0 6px 28px rgba(0,0,0,0.5),
        0 0 0 1px rgba(255,255,255,0.06);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
    animation: cardEntrance 0.55s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.tmember-card:nth-child(1) { animation-delay: 0.04s; }
.tmember-card:nth-child(2) { animation-delay: 0.09s; }
.tmember-card:nth-child(3) { animation-delay: 0.14s; }
.tmember-card:nth-child(4) { animation-delay: 0.19s; }
.tmember-card:nth-child(5) { animation-delay: 0.24s; }
.tmember-card:nth-child(6) { animation-delay: 0.29s; }
@keyframes cardEntrance {
    from { opacity: 0; transform: translateY(28px) scale(0.95); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.tmember-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow:
        0 20px 50px rgba(0,0,0,0.55),
        0 0 0 1.5px rgba(34,211,238,0.35),
        0 0 30px rgba(34,211,238,0.06);
}

/* ── Photo wrap ── */
.tmember-photo-wrap {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}
.tmember-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    display: block;
    background: linear-gradient(135deg, #0c2d5e, #1d6fca);
    transition: transform 0.5s ease;
}
.tmember-card:hover .tmember-photo {
    transform: scale(1.07);
}
.tmember-online { display: none; }

/* gradient overlay bottom */
.tmember-photo-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 40%,
        rgba(6,13,31,0.55) 65%,
        rgba(6,13,31,0.95) 100%
    );
    transition: background 0.3s ease;
    z-index: 2;
}

/* cyan bottom accent bar on hover */
.tmember-photo-wrap::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #1d6fca, #22d3ee);
    z-index: 4;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.38s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.tmember-card:hover .tmember-photo-wrap::before {
    transform: scaleX(1);
}

/* ── Info block ── */
.tmember-info {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 0.85rem 0.9rem 1rem;
    z-index: 5;
}
.tmember-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    letter-spacing: 0.01em;
    text-shadow: 0 1px 6px rgba(0,0,0,0.7);
}
.tmember-meta {
    font-size: 0.66rem;
    color: rgba(255,255,255,0.72);
    margin-top: 4px;
    font-weight: 400;
    line-height: 1.4;
    display: flex;
    align-items: flex-start;
    gap: 5px;
}
.tmember-meta::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: #22d3ee;
    flex-shrink: 0;
    margin-top: 3px;
    box-shadow: 0 0 5px #22d3ee;
}

/* ── Badge (hidden, kept for compat) ── */
.tmember-badge { display: none; }

/* ── Wavy decorations ── */
.team-wavy-deco {
    position: absolute;
    opacity: 0.35;
    pointer-events: none;
}
</style>

<!-- ===== TIM PENGEMBANG SIMAGANG ===== -->
<section id="about" class="team-tabs-section">
    <svg class="team-wavy-deco" style="top:80px;left:16px;width:90px;" viewBox="0 0 90 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2 10 Q14 2 26 10 Q38 18 50 10 Q62 2 74 10 Q82 16 88 10" stroke="#22d3ee" stroke-width="2.2" stroke-linecap="round" fill="none"/>
    </svg>
    <svg class="team-wavy-deco" style="bottom:80px;right:24px;width:90px;" viewBox="0 0 90 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2 10 Q14 2 26 10 Q38 18 50 10 Q62 2 74 10 Q82 16 88 10" stroke="#22d3ee" stroke-width="2.2" stroke-linecap="round" fill="none"/>
    </svg>
    <svg class="team-wavy-deco" style="top:28px;right:28px;width:40px;opacity:0.55;" viewBox="0 0 40 44"><polygon points="0,44 20,0 40,44" fill="none" stroke="#fbbf24" stroke-width="2.5"/></svg>

    <div class="container" style="position:relative;z-index:2;">
        <h2 class="team-tabs-title">Tim Pengembang Simagang</h2>

        <div class="team-tabs-nav">
            <button class="team-tab-btn active" data-tab="angkatan1">Simagang v2</button>
            <button class="team-tab-btn" data-tab="angkatan2">Simagang v1</button>
        </div>

        <div class="team-tab-panel active" id="tab-angkatan1">
            <div class="team-carousel-wrapper">
                <div class="team-members-grid" id="carousel-grid-1">
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ asset('storage/profiles/user1.jpeg') }}" alt="Diza Sazkia" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Diza Sazkia</div><div class="tmember-meta">Universitas Hasanuddin | Sistem Informasi</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ asset('storage/profiles/user2.jpg') }}" alt="Nur Fadillah" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Nur Fadillah</div><div class="tmember-meta">Universitas Hasanuddin | Sistem Informasi</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ asset('storage/profiles/user3.jpg') }}" alt="Resky Auliyah Kartini A" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Resky Auliyah Kartini A</div><div class="tmember-meta">Universitas Hasanuddin | Sistem Informasi</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ asset('storage/profiles/user4.jpeg') }}" alt="Novi Rezkiyah Azzahrah R" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Novi Rezkiyah Azzahrah R</div><div class="tmember-meta">Universitas Hasanuddin | Sistem Informasi</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ asset('storage/profiles/user5.png') }}" alt="An Naura Erwana Dwi P" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">An Naura Erwana Dwi P</div><div class="tmember-meta">Universitas Hasanuddin | Sistem Informasi</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ asset('storage/profiles/user6.png') }}" alt="Cholyn Sharon Enos" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Cholyn Sharon Enos</div><div class="tmember-meta">Universitas Hasanuddin | Sistem Informasi</div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="team-carousel-dots" id="carousel-dots-1"></div>
            <div class="team-carousel-progress" id="carousel-progress-1"><div class="team-carousel-progress-bar" id="carousel-bar-1"></div></div>
        </div>

        <div class="team-tab-panel" id="tab-angkatan2">
            <div class="team-carousel-wrapper">
                <div class="team-members-grid" id="carousel-grid-2">
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ url('storage/partners/pnup.png') }}" alt="Rezki Andika" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Rezki Andika</div><div class="tmember-meta">Politeknik Negeri Ujung Pandang</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ url('storage/partners/stialan.png') }}" alt="Husnul Khatimah" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Husnul Khatimah</div><div class="tmember-meta">Politeknik STIA LAN Makassar</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ url('storage/partners/stialan.png') }}" alt="Dominikus Dikky" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Dominikus Dikky</div><div class="tmember-meta">Politeknik STIA LAN Makassar</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ url('storage/partners/stialan.png') }}" alt="Aurrely Aprilia Putri Oppusunggu" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Aurrely Aprilia Putri Oppusunggu</div><div class="tmember-meta">Politeknik STIA LAN Makassar</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ url('storage/partners/stialan.png') }}" alt="Willyan Imanuel Rari" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Willyan Imanuel Rari</div><div class="tmember-meta">Politeknik STIA LAN Makassar</div></div>
                        </div>
                    </div>
                    <div class="tmember-card">
                        <div class="tmember-photo-wrap">
                            <img src="{{ url('storage/partners/stialan.png') }}" alt="Fadhil Darmawan Jibran" class="tmember-photo">
                            <div class="tmember-info"><div class="tmember-name">Fadhil Darmawan Jibran</div><div class="tmember-meta">Politeknik STIA LAN Makassar</div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="team-carousel-dots" id="carousel-dots-2"></div>
            <div class="team-carousel-progress" id="carousel-progress-2"><div class="team-carousel-progress-bar" id="carousel-bar-2"></div></div>
        </div>

    </div>
</section>

<script>
/* ── Team Tabs ── */
document.querySelectorAll('.team-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.team-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.team-tab-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        // re-init carousel for the newly active panel if mobile
        if (window.innerWidth <= 480) {
            const panelId = 'tab-' + btn.dataset.tab;
            const instance = carouselInstances[panelId];
            if (instance) instance.reset();
        }
    });
});

/* ── Mobile Carousel ── */
const carouselInstances = {};

function destroyAllCarousels() {
    Object.values(carouselInstances).forEach(instance => {
        if (instance && typeof instance.destroy === 'function') {
            instance.destroy();
        }
    });

    Object.keys(carouselInstances).forEach(key => {
        delete carouselInstances[key];
    });
}

function initMobileCarousel(gridId, dotsId, barId) {
    const grid  = document.getElementById(gridId);
    const dots  = document.getElementById(dotsId);
    const bar   = document.getElementById(barId);
    if (!grid || !dots || !bar) return;

    const panelEl = grid.closest('.team-tab-panel');
    const panelId = panelEl ? panelEl.id : null;
    const existing = panelId ? carouselInstances[panelId] : null;

    if (existing && existing.active) {
        return;
    }

    if (existing && typeof existing.destroy === 'function') {
        existing.destroy();
    }

    const cards = Array.from(grid.querySelectorAll('.tmember-card'));
    const total = cards.length;
    let current = 0;
    let timer   = null;
    let progTimer = null;
    let progStart = null;
    const DURATION = 5000;
    let destroyed = false;

    // build dots
    dots.innerHTML = '';
    cards.forEach((_, i) => {
        const d = document.createElement('button');
        d.className = 'cdot' + (i === 0 ? ' active' : '');
        d.setAttribute('aria-label', 'Slide ' + (i + 1));
        d.addEventListener('click', () => { goTo(i); resetTimer(); });
        dots.appendChild(d);
    });

    function updateDots() {
        dots.querySelectorAll('.cdot').forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function goTo(n) {
        if (destroyed) return;
        current = ((n % total) + total) % total;
        grid.style.transform = `translateX(-${current * 100}%)`;
        updateDots();
        // reset progress bar
        bar.style.transition = 'none';
        bar.style.width = '0%';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                bar.style.transition = `width ${DURATION}ms linear`;
                bar.style.width = '100%';
            });
        });
    }

    function next() { goTo(current + 1); }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(next, DURATION);
    }

    // touch swipe
    let touchStartX = 0;
    const handleTouchStart = e => { touchStartX = e.changedTouches[0].screenX; };
    const handleTouchEnd = e => {
        if (destroyed) return;
        const dx = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(dx) > 40) { goTo(current + (dx > 0 ? 1 : -1)); resetTimer(); }
    };
    grid.addEventListener('touchstart', handleTouchStart, { passive: true });
    grid.addEventListener('touchend', handleTouchEnd);

    function start() {
        goTo(0);
        resetTimer();
    }

    function reset() {
        if (destroyed) return;
        clearInterval(timer);
        start();
    }

    function destroy() {
        destroyed = true;
        clearInterval(timer);
        clearInterval(progTimer);
        grid.removeEventListener('touchstart', handleTouchStart);
        grid.removeEventListener('touchend', handleTouchEnd);
        grid.style.transform = '';
        bar.style.transition = '';
        bar.style.width = '';
    }

    start();

    // expose reset for tab switching
    if (panelId) carouselInstances[panelId] = { reset, destroy, active: true };
}

function setupCarousels() {
    if (window.innerWidth <= 480) {
        initMobileCarousel('carousel-grid-1', 'carousel-dots-1', 'carousel-bar-1');
        initMobileCarousel('carousel-grid-2', 'carousel-dots-2', 'carousel-bar-2');
    } else {
        destroyAllCarousels();
        // desktop: reset transform if any
        ['carousel-grid-1','carousel-grid-2'].forEach(id => {
            const g = document.getElementById(id);
            if (g) g.style.transform = '';
        });
        ['carousel-dots-1','carousel-dots-2'].forEach(id => {
            const d = document.getElementById(id);
            if (d) d.innerHTML = '';
        });
        ['carousel-bar-1','carousel-bar-2'].forEach(id => {
            const b = document.getElementById(id);
            if (b) {
                b.style.transition = '';
                b.style.width = '';
            }
        });
    }
}

setupCarousels();

let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(setupCarousels, 200);
});
</script>

<!-- ===== CTA / PENDAFTARAN ===== -->
<section class="section-cta">
    <div id="daftar" class="container">
        <div class="cta-inner">
            <div class="reveal">
                <div class="cta-tag">Pendaftaran Mitra</div>
                <h2 class="cta-title">Khusus untuk Sekolah & Kampus</h2>
                <p class="cta-desc">Bergabunglah sekarang dan mulai kelola program magang institusi Anda dengan lebih efisien dan profesional bersama Simagang.</p>
                <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap">
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.65);font-size:14px">
                        <i class="fas fa-check-circle" style="color:#22d3ee;font-size:16px"></i>
                        Gratis untuk institusi pendidikan
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.65);font-size:14px">
                        <i class="fas fa-check-circle" style="color:#22d3ee;font-size:16px"></i>
                        Dukungan teknis 24/7
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.65);font-size:14px">
                        <i class="fas fa-check-circle" style="color:#22d3ee;font-size:16px"></i>
                        Setup dalam hitungan menit
                    </div>
                </div>
            </div>
            <div class="cta-cards reveal">
                <a href="{{ route('institusi.create') }}" class="cta-card">
                    <div class="cta-card-left">
                        <div class="cta-card-icon" style="background:linear-gradient(135deg,#0ea5e9,#22d3ee)">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="cta-card-name">Sekolah</div>
                            <div class="cta-card-sub">Daftar melalui Tata Usaha (TU) Sekolah</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right cta-arrow"></i>
                </a>
                <a href="{{ route('institusi.create') }}" class="cta-card">
                    <div class="cta-card-left">
                        <div class="cta-card-icon" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="cta-card-name">Universitas / Kampus</div>
                            <div class="cta-card-sub">Wajib melalui Departemen Kampus terkait</div>
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
<footer class="main-footer">
    <div class="footer-simple-inner">
        <div class="footer-logos-simple">
            <img src="{{ url('storage/vendor/logo_berakhlak.png') }}" alt="BerAkhlak"> 
            <img src="{{ url('storage/vendor/logo_banggamelayani.png') }}" alt="Bangga Melayani">
            <img src="{{ url('storage/vendor/logo_antikorupsi.png') }}" alt="Anti Korupsi">
        </div>

        <div class="copyright-simple">
            &copy; 2026 <strong>Simagang</strong> — BBLSDM Komdigi Makassar. All rights reserved.
        </div>

        <div class="social-links-simple">
            <a href="https://www.instagram.com/bblsdm.komdigi.makassar/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://www.komdigi.go.id/" target="_blank" title="Website"><i class="fas fa-globe"></i></a>
            <a href="https://www.tiktok.com/@balaikomdigimakassar" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
            <a href="https://www.youtube.com/@bblsdm.komdigi.makassar" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</footer>

<script>
/* ── Scroll Reveal ── */
const revealObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('visible'), entry.target.dataset.delay || 0);
            revealObs.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach((el, i) => {
    el.dataset.delay = (i % 3) * 100;
    revealObs.observe(el);
});

/* ── Active Nav ── */
const navLinks = document.querySelectorAll('.nav-links a');
const navObs = new IntersectionObserver((entries) => {
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
document.querySelectorAll('section[id]').forEach(s => navObs.observe(s));

/* ── Mobile Menu ── */
const toggle = document.querySelector('.nav-toggle');
const menu   = document.querySelector('.mobile-menu');
if (toggle && menu) {
    toggle.addEventListener('click', () => {
        const open = menu.classList.toggle('open');
        toggle.setAttribute('aria-expanded', open);
        menu.setAttribute('aria-hidden', !open);
    });
    menu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            menu.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-hidden', 'true');
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('newsSlider');
        const slides = slider.children;
        let index = 0;

        function nextSlide() {
            index++;
            if (index >= slides.length) {
                index = 0;
            }
            slider.style.transform = `translateX(-${index * 100}%)`;
        }

        setInterval(nextSlide, 5000);
    });

/* ── Carousel Factory ── */
function initCarousel({ wrapperId, dotsId, prevId, nextId, interval = 5000 }) {
    const wrapper = document.getElementById(wrapperId);
    if (!wrapper) return;
    const dotsWrap = document.getElementById(dotsId);
    const dots     = dotsWrap ? Array.from(dotsWrap.querySelectorAll('.dot')) : [];
    const total    = wrapper.children.length;
    let cur = 0, timer;

    const go = (n) => {
        cur = ((n % total) + total) % total;
        wrapper.style.transform = `translateX(-${cur * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === cur));
    };

    const reset = () => { clearInterval(timer); timer = setInterval(() => go(cur + 1), interval); };

    document.getElementById(prevId)?.addEventListener('click', () => { go(cur - 1); reset(); });
    document.getElementById(nextId)?.addEventListener('click', () => { go(cur + 1); reset(); });
    dots.forEach((d, i) => d.addEventListener('click', () => { go(i); reset(); }));

    /* Touch swipe */
    let sx = 0;
    const root = wrapper.closest('.process-carousel, .testi-carousel') || wrapper.parentElement;
    root.addEventListener('touchstart', e => { sx = e.changedTouches[0].screenX; }, { passive: true });
    root.addEventListener('touchend',   e => {
        const dx = sx - e.changedTouches[0].screenX;
        if (Math.abs(dx) > 50) { go(cur + (dx > 0 ? 1 : -1)); reset(); }
    });

    go(0);
    reset();
}

initCarousel({ wrapperId:'process-wrapper', dotsId:'process-dots', prevId:'process-prev', nextId:'process-next' });
initCarousel({ wrapperId:'testi-wrapper',   dotsId:'testi-dots',   prevId:'testi-prev',   nextId:'testi-next' });
</script>

</body>
</html>