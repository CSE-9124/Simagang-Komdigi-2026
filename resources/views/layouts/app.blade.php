<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Manajemen Anak Magang')</title>
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
    </style>

</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar untuk desktop -->
        <aside id="sidebar" class="hidden lg:flex lg:flex-col lg:w-64 bg-white shadow-lg">
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
                            <i class="fas fa-home w-5 mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.intern.index') }}" class="{{ request()->routeIs('admin.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-user-graduate w-5 mr-3"></i>
                            Anak Magang
                        </a>
                        <a href="{{ route('admin.mentor.index') }}" class="{{ request()->routeIs('admin.mentor.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-chalkboard-teacher w-5 mr-3"></i>
                            Mentor
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>
                            Absensi
                        </a>
                        <a href="{{ route('admin.logbook.index') }}" class="{{ request()->routeIs('admin.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-book w-5 mr-3"></i>
                            Logbook
                        </a>
                        <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-file-alt w-5 mr-3"></i>
                            Laporan
                        </a>
                        <a href="{{ route('admin.microskill.index') }}" class="{{ request()->routeIs('admin.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-star w-5 mr-3"></i>
                            Mikro Skill
                        </a>
                        <a href="{{ route('admin.monitoring.index') }}" class="{{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-chart-line w-5 mr-3"></i>
                            Monitoring
                        </a>
                    @elseif(auth()->user()->isMentor())
                        <a href="{{ route('mentor.dashboard') }}" class="{{ request()->routeIs('mentor.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-home w-5 mr-3"></i>
                            Dashboard Mentor
                        </a>
                        <a href="{{ route('mentor.intern.index') }}" class="{{ request()->routeIs('mentor.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-users w-5 mr-3"></i>
                            Anak Bimbingan
                        </a>
                        <a href="{{ route('mentor.attendance.index') }}" class="{{ request()->routeIs('mentor.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>
                            Absensi
                        </a>
                        <a href="{{ route('mentor.logbook.index') }}" class="{{ request()->routeIs('mentor.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-book w-5 mr-3"></i>
                            Logbook
                        </a>
                        <a href="{{ route('mentor.report.index') }}" class="{{ request()->routeIs('mentor.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-file-alt w-5 mr-3"></i>
                            Laporan Akhir
                        </a>
                        <a href="{{ route('mentor.microskill.index') }}" class="{{ request()->routeIs('mentor.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-star w-5 mr-3"></i>
                            Mikro Skill
                        </a>
                    @else
                        <a href="{{ route('intern.dashboard') }}" class="{{ request()->routeIs('intern.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-home w-5 mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('intern.attendance.index') }}" class="{{ request()->routeIs('intern.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>
                            Absensi
                        </a>
                        <a href="{{ route('intern.logbook.index') }}" class="{{ request()->routeIs('intern.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-book w-5 mr-3"></i>
                            Logbook
                        </a>
                        <a href="{{ route('intern.report.index') }}" class="{{ request()->routeIs('intern.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-file-alt w-5 mr-3"></i>
                            Laporan
                        </a>
                        <a href="{{ route('intern.microskill.index') }}" class="{{ request()->routeIs('intern.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-medium">
                            <i class="fas fa-star w-5 mr-3"></i>
                            Mikro Skill
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- User Info & Logout -->
            <div class="border-t p-4">
                @auth
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-sign-in-alt w-5 mr-3"></i>
                        Login
                    </a>
                @endauth
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header (Mobile) -->
            <header class="lg:hidden bg-white shadow-sm">
                <div class="flex items-center justify-between p-4">
                    <!-- Logo & Brand -->
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

            <!-- Mobile Sidebar -->
            <div id="mobile-sidebar" class="lg:hidden hidden fixed inset-0 z-50">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="mobile-sidebar-backdrop"></div>
                
                <!-- Sidebar Panel -->
                <div class="fixed inset-y-0 left-0 flex flex-col w-64 bg-white">
                    <!-- Close Button -->
                    <div class="flex justify-between">
                        <div>
                            <p></p>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b">
                            <!-- Logo & Brand -->
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
                    
                    <!-- Mobile Navigation -->
                    <nav class="flex-1 overflow-y-auto py-4">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.intern.index') }}" class="{{ request()->routeIs('admin.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-user-graduate w-5 mr-3"></i>
                                    Anak Magang
                                </a>
                                <a href="{{ route('admin.mentor.index') }}" class="{{ request()->routeIs('admin.mentor.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-chalkboard-teacher w-5 mr-3"></i>
                                    Mentor
                                </a>
                                <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                                    Absensi
                                </a>
                                <a href="{{ route('admin.logbook.index') }}" class="{{ request()->routeIs('admin.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-book w-5 mr-3"></i>
                                    Logbook
                                </a>
                                <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-file-alt w-5 mr-3"></i>
                                    Laporan
                                </a>
                                <a href="{{ route('admin.microskill.index') }}" class="{{ request()->routeIs('admin.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-star w-5 mr-3"></i>
                                    Mikro Skill
                                </a>
                                <a href="{{ route('admin.monitoring.index') }}" class="{{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-chart-line w-5 mr-3"></i>
                                    Monitoring
                                </a>
                            @elseif(auth()->user()->isMentor())
                                <a href="{{ route('mentor.dashboard') }}" class="{{ request()->routeIs('mentor.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>
                                    Dashboard Mentor
                                </a>
                                <a href="{{ route('mentor.intern.index') }}" class="{{ request()->routeIs('mentor.intern.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-users w-5 mr-3"></i>
                                    Anak Bimbingan
                                </a>
                                <a href="{{ route('mentor.attendance.index') }}" class="{{ request()->routeIs('mentor.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                                    Absensi
                                </a>
                                <a href="{{ route('mentor.logbook.index') }}" class="{{ request()->routeIs('mentor.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-book w-5 mr-3"></i>
                                    Logbook
                                </a>
                                <a href="{{ route('mentor.report.index') }}" class="{{ request()->routeIs('mentor.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-file-alt w-5 mr-3"></i>
                                    Laporan Akhir
                                </a>
                                <a href="{{ route('mentor.microskill.index') }}" class="{{ request()->routeIs('mentor.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-star w-5 mr-3"></i>
                                    Mikro Skill
                                </a>
                            @else
                                <a href="{{ route('intern.dashboard') }}" class="{{ request()->routeIs('intern.dashboard') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-home w-5 mr-3"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('intern.attendance.index') }}" class="{{ request()->routeIs('intern.attendance.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                                    Absensi
                                </a>
                                <a href="{{ route('intern.logbook.index') }}" class="{{ request()->routeIs('intern.logbook.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-book w-5 mr-3"></i>
                                    Logbook
                                </a>
                                <a href="{{ route('intern.report.index') }}" class="{{ request()->routeIs('intern.report.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-file-alt w-5 mr-3"></i>
                                    Laporan
                                </a>
                                <a href="{{ route('intern.microskill.index') }}" class="{{ request()->routeIs('intern.microskill.*') ? 'bg-blue-50 border-r-4 border-blue-500 text-blue-700' : 'text-gray-600' }} flex items-center px-4 py-3 text-sm font-medium">
                                    <i class="fas fa-star w-5 mr-3"></i>
                                    Mikro Skill
                                </a>
                            @endif
                        @endauth
                    </nav>

                    <!-- Mobile User Info -->
                    <div class="border-t p-4">
                        @auth
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md">
                                <i class="fas fa-sign-in-alt w-5 mr-3"></i>
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
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
        (function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileCloseBtn = document.getElementById('mobile-close-button');
            const mobileSidebarBackdrop = document.getElementById('mobile-sidebar-backdrop');
            const iconMenu = document.getElementById('icon-menu');
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

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    if (mobileSidebar.classList.contains('hidden')) {
                        openMobileSidebar();
                    } else {
                        closeMobileSidebar();
                    }
                });
            }

            if (mobileCloseBtn) {
                mobileCloseBtn.addEventListener('click', closeMobileSidebar);
            }

            if (mobileSidebarBackdrop) {
                mobileSidebarBackdrop.addEventListener('click', closeMobileSidebar);
            }
        })();
    </script>
</body>
</html>