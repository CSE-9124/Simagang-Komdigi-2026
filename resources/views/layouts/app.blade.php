<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Manajemen Anak Magang')</title>
    <link rel="icon" type="image/png" href="{{ url('storage/vendor/icon-komdigi.png') }}">
    <link rel="shortcut icon" href="{{ url('storage/vendor/icon-komdigi.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        @font-face {
            font-family: 'Etna';
            src: url('/fonts/Etna-Free-Font.otf') format('opentype');
        }
        .font-etna {
            font-family: 'Etna', sans-serif;
        }

        /* ==============================
        Desktop Sidebar Toggle (Tab)
        ============================== */

        /* Sidebar harus relative agar tab bisa di-absolute di dalamnya */
        #sidebar {
            position: relative;
            flex-shrink: 0;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: visible !important; /* biarkan tab menonjol keluar */
        }

        /*
         * Tab tombol — menempel di sisi kanan sidebar, posisi vertikal tengah.
         * Border kiri tidak ada agar menyatu dengan sidebar (efek bookmark/buku).
         */
        #sidebar-tab {
            position: absolute;
            top: 50%;
            right: -20px;           /* menonjol keluar dari sidebar */
            transform: translateY(-50%);
            z-index: 20;

            width: 20px;
            height: 60px;
            background: white;
            border: 1px solid #e5e7eb;
            border-left: none;       /* sisi kiri menyatu dengan sidebar */
            border-radius: 0 10px 10px 0;

            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 3px 0 8px rgba(0, 0, 0, 0.08);
            transition: background 0.15s ease, box-shadow 0.15s ease;
        }

        #sidebar-tab:hover {
            background: #eff6ff;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.13);
        }

        /* Ikon panah di dalam tab */
        #sidebar-tab-icon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ==============================
        State: Sidebar collapsed
        ============================== */
        #sidebar.sidebar-collapsed {
            width: 0 !important;
            min-width: 0 !important;
        }

        /* Sembunyikan semua isi kecuali tab-nya */
        #sidebar.sidebar-collapsed > *:not(#sidebar-tab) {
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
        }

        /* Saat collapsed, tab "menempel ke tepi kiri layar" */
        #sidebar.sidebar-collapsed #sidebar-tab {
            border-left: 1px solid #e5e7eb; /* tampilkan border kiri agar terlihat tab berdiri sendiri */
            border-radius: 0 10px 10px 0;
            box-shadow: 3px 0 8px rgba(0, 0, 0, 0.1);
        }

        /* Rotasi panah saat collapsed */
        #sidebar.sidebar-collapsed #sidebar-tab-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <!-- ===========================
        Sidebar Desktop
        ============================ -->
        <aside id="sidebar" class="hidden lg:flex lg:flex-col lg:w-64 bg-white shadow-lg">

            <!-- Tab toggle — menempel di tepi kanan sidebar, vertikal tengah -->
            <button id="sidebar-tab" onclick="toggleDesktopSidebar()" title="Buka / Tutup sidebar" aria-label="Toggle sidebar">
                <svg id="sidebar-tab-icon" xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24"
                    fill="none" stroke="#6b7280" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>

            <!-- Logo & Brand -->
            <div class="flex flex-col items-center p-4 border-b">
                <img src="{{ url('storage/vendor/logo_komdigi.png') }}" alt="Logo" class="object-contain" style="width: 60px; height: 60px"/>
                <h1 class="text-3xl font-extrabold font-etna">
                    <span style="color: #9d272a">SI</span><span style="color: #086bb0">MA</span><span style="color: #2dabe2">GA</span><span style="color: #efc400">NG</span>
                </h1>
                <p class="font-etna" style="color: #626161; font-size:10px">Sistem Manajemen Magang</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto py-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-home w-5 mr-3"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.intern.index') }}" class="{{ request()->routeIs('admin.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-user-graduate w-5 mr-3"></i>Anak Magang
                        </a>
                        <a href="{{ route('admin.mentor.index') }}" class="{{ request()->routeIs('admin.mentor.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-chalkboard-teacher w-5 mr-3"></i>Mentor
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>Absensi
                        </a>
                        <a href="{{ route('admin.logbook.index') }}" class="{{ request()->routeIs('admin.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-book w-5 mr-3"></i>Logbook
                        </a>
                        <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-file-alt w-5 mr-3"></i>Laporan
                        </a>
                        <a href="{{ route('admin.microskill.index') }}" class="{{ request()->routeIs('admin.microskill.index', 'admin.microskill.create', 'admin.microskill.edit', 'admin.microskill.show') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-star w-5 mr-3"></i>Mikro Skill
                        </a>
                        <a href="{{ route('admin.monitoring.index') }}" class="{{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-chart-line w-5 mr-3"></i>Monitoring
                        </a>
                        <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.index.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-users w-5 mr-3"></i>Manage Tim
                        </a>
                    @elseif(auth()->user()->isMentor())
                        <a href="{{ route('mentor.dashboard') }}" class="{{ request()->routeIs('mentor.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-home w-5 mr-3"></i>Dashboard Mentor
                        </a>
                        <a href="{{ route('mentor.intern.index') }}" class="{{ request()->routeIs('mentor.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-users w-5 mr-3"></i>Anak Bimbingan
                        </a>
                        <a href="{{ route('mentor.attendance.index') }}" class="{{ request()->routeIs('mentor.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>Absensi
                        </a>
                        <a href="{{ route('mentor.logbook.index') }}" class="{{ request()->routeIs('mentor.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-book w-5 mr-3"></i>Logbook
                        </a>
                        <a href="{{ route('mentor.report.index') }}" class="{{ request()->routeIs('mentor.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-file-alt w-5 mr-3"></i>Laporan Akhir
                        </a>
                        <a href="{{ route('mentor.microskill.index') }}" class="{{ request()->routeIs('mentor.microskill.index', 'mentor.microskill.create', 'mentor.microskill.edit', 'mentor.microskill.show') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-star w-5 mr-3"></i>Mikro Skill
                        </a>
                    @elseif(auth()->user()->isInstitusi())
                        <a href="{{ route('institusi.dashboard') }}" class="{{ request()->routeIs('institusi.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-home w-5 mr-3"></i>Dashboard
                        </a>
                        <a href="{{ route('institusi.pengajuan.index') }}" class="{{ request()->routeIs('institusi.pengajuan.index') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-paper-plane w-5 mr-3"></i>Pengajuan Magang
                        </a>
                    @else
                        <a href="{{ route('intern.dashboard') }}" class="{{ request()->routeIs('intern.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-home w-5 mr-3"></i>Dashboard
                        </a>
                        <a href="{{ route('intern.attendance.index') }}" class="{{ request()->routeIs('intern.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>Absensi
                        </a>
                        <a href="{{ route('intern.logbook.index') }}" class="{{ request()->routeIs('intern.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-book w-5 mr-3"></i>Logbook
                        </a>
                        <a href="{{ route('intern.report.index') }}" class="{{ request()->routeIs('intern.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-file-alt w-5 mr-3"></i>Laporan
                        </a>
                        <a href="{{ route('intern.microskill.index') }}" class="{{ request()->routeIs('intern.microskill.index', 'intern.microskill.create', 'intern.microskill.edit', 'intern.microskill.show') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-star w-5 mr-3"></i>Mikro Skill
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- User Info & Logout -->
            <div class="border-t p-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                    @else
                        <a href="{{ auth()->user()->isMentor() ? route('mentor.profile.show') : route('intern.profile.show') }}" class="flex items-center space-x-3 mb-3 hover:bg-gray-50 rounded-lg p-2 transition-colors duration-200">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->isMentor() ? 'Mentor' : 'Anak Magang' }}</p>
                            </div>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-sign-in-alt w-5 mr-3"></i>Login
                    </a>
                @endauth
            </div>
        </aside>

        <!-- ===========================
            Main Content Area
        ============================ -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Header (Mobile only) -->
            <header class="lg:hidden bg-white shadow-sm">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">
                        <img src="{{ url('storage/vendor/logo_komdigi.png') }}" alt="Logo" class="object-contain" style="width: 60px; height: 60px"/>
                    </div>
                    <button type="button" id="mobile-menu-button" class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <svg class="h-6 w-6" id="icon-menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6 hidden" id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Mobile Sidebar Overlay -->
            <div id="mobile-sidebar" class="lg:hidden hidden fixed inset-0 z-50">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="mobile-sidebar-backdrop"></div>
                <div class="fixed inset-y-0 left-0 flex flex-col w-64 bg-white">
                    <div class="flex justify-between">
                        <div><p></p></div>
                        <div class="flex items-center justify-between p-4 border-b">
                            <div class="flex flex-col items-center p-4 border-b">
                                <img src="{{ url('storage/vendor/logo_komdigi.png') }}" alt="Logo" class="object-contain" style="width: 60px; height: 60px"/>
                                <h1 class="text-3xl font-extrabold font-etna">
                                    <span style="color: #9d272a">SI</span><span style="color: #086bb0">MA</span><span style="color: #2dabe2">GA</span><span style="color: #efc400">NG</span>
                                </h1>
                                <p class="font-etna" style="color: #626161; font-size:10px">Sistem Manajemen Magang</p>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="mobile-close-button" class="p-2 rounded-md text-gray-600 hover:text-gray-900">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <nav class="flex-1 overflow-y-auto py-4">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>Dashboard
                                </a>
                                <a href="{{ route('admin.intern.index') }}" class="{{ request()->routeIs('admin.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-user-graduate w-5 mr-3"></i>Anak Magang
                                </a>
                                <a href="{{ route('admin.mentor.index') }}" class="{{ request()->routeIs('admin.mentor.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-chalkboard-teacher w-5 mr-3"></i>Mentor
                                </a>
                                <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>Absensi
                                </a>
                                <a href="{{ route('admin.logbook.index') }}" class="{{ request()->routeIs('admin.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-book w-5 mr-3"></i>Logbook
                                </a>
                                <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-file-alt w-5 mr-3"></i>Laporan
                                </a>
                                <a href="{{ route('admin.microskill.index') }}" class="{{ request()->routeIs('admin.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-star w-5 mr-3"></i>Mikro Skill
                                </a>
                                <a href="{{ route('admin.monitoring.index') }}" class="{{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-chart-line w-5 mr-3"></i>Monitoring
                                </a>
                                <a href="{{ route('admin.team.index') }}" class="{{ request()->routeIs('admin.team.index*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-users w-5 mr-3"></i>Manage Tim
                                </a>
                            @elseif(auth()->user()->isMentor())
                                <a href="{{ route('mentor.dashboard') }}" class="{{ request()->routeIs('mentor.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>Dashboard Mentor
                                </a>
                                <a href="{{ route('mentor.intern.index') }}" class="{{ request()->routeIs('mentor.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-users w-5 mr-3"></i>Anak Bimbingan
                                </a>
                                <a href="{{ route('mentor.attendance.index') }}" class="{{ request()->routeIs('mentor.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>Absensi
                                </a>
                                <a href="{{ route('mentor.logbook.index') }}" class="{{ request()->routeIs('mentor.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-book w-5 mr-3"></i>Logbook
                                </a>
                                <a href="{{ route('mentor.report.index') }}" class="{{ request()->routeIs('mentor.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-file-alt w-5 mr-3"></i>Laporan Akhir
                                </a>
                                <a href="{{ route('mentor.microskill.index') }}" class="{{ request()->routeIs('mentor.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-star w-5 mr-3"></i>Mikro Skill
                                </a>
                            @elseif(auth()->user()->isInstitusi())
                                <a href="{{ route('institusi.dashboard') }}" class="{{ request()->routeIs('institusi.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>Dashboard
                                </a>
                                <a href="{{ route('institusi.pengajuan.index') }}" class="{{ request()->routeIs('institusi.pengajuan.index') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-paper-plane w-5 mr-3"></i>Pengajuan Magang
                                </a>
                            @else
                                <a href="{{ route('intern.dashboard') }}" class="{{ request()->routeIs('intern.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>Dashboard
                                </a>
                                <a href="{{ route('intern.attendance.index') }}" class="{{ request()->routeIs('intern.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>Absensi
                                </a>
                                <a href="{{ route('intern.logbook.index') }}" class="{{ request()->routeIs('intern.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-book w-5 mr-3"></i>Logbook
                                </a>
                                <a href="{{ route('intern.report.index') }}" class="{{ request()->routeIs('intern.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-file-alt w-5 mr-3"></i>Laporan
                                </a>
                                <a href="{{ route('intern.microskill.index') }}" class="{{ request()->routeIs('intern.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-star w-5 mr-3"></i>Mikro Skill
                                </a>
                            @endif
                        @endauth
                    </nav>

                    <div class="border-t p-4">
                        @auth
                            @if(auth()->user()->isAdmin() || auth()->user()->isInstitusi())
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                            @else
                                <a href="{{ auth()->user()->isMentor() ? route('mentor.profile.show') : route('intern.profile.show') }}"
                                    class="flex items-center space-x-3 mb-3 hover:bg-gray-50 rounded-lg p-2 transition-colors duration-200">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->isMentor() ? 'Mentor' : 'Anak Magang' }}</p>
                                    </div>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                                <i class="fas fa-sign-in-alt w-5 mr-3"></i>Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto">
                @if(session('success'))
                    <div class="mb-4">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div class="mb-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            @if(session('error'))
                                <span class="block sm:inline">{{ session('error') }}</span>
                            @endif
                            @if($errors->any())
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="mb-4">
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        (function () {
            // ========================
            // Mobile Sidebar
            // ========================
            const mobileMenuBtn = document.getElementById('mobile-menu-button');
            const mobileSidebar  = document.getElementById('mobile-sidebar');
            const mobileCloseBtn = document.getElementById('mobile-close-button');
            const mobileBackdrop = document.getElementById('mobile-sidebar-backdrop');
            const iconMenu  = document.getElementById('icon-menu');
            const iconClose = document.getElementById('icon-close');

            function openMobileSidebar() {
                mobileSidebar.classList.remove('hidden');
                iconMenu.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }
            function closeMobileSidebar() {
                mobileSidebar.classList.add('hidden');
                iconMenu.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }

            if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', () =>
                mobileSidebar.classList.contains('hidden') ? openMobileSidebar() : closeMobileSidebar()
            );
            if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileSidebar);
            if (mobileBackdrop)  mobileBackdrop.addEventListener('click', closeMobileSidebar);

            // ========================
            // Desktop Sidebar Toggle
            // ========================
            const sidebar = document.getElementById('sidebar');

            window.toggleDesktopSidebar = function () {
                sidebar.classList.toggle('sidebar-collapsed');
            };
        })();
    </script>
</body>
</html>