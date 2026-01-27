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
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center space-x-3">
                        <img src="{{ url('storage/vendor/vendor.png') }}" alt="Logo" class="object-contain" style="width : 80px; height : 80px"/>
                        <h1 class="text-sm font-bold text-blue-600">SIMAGANG</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.intern.index') }}" class="{{ request()->routeIs('admin.intern.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Anak Magang
                                </a>
                                <a href="{{ route('admin.mentor.index') }}" class="{{ request()->routeIs('admin.mentor.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Mentor
                                </a>
                                <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Absensi
                                </a>
                                <a href="{{ route('admin.logbook.index') }}" class="{{ request()->routeIs('admin.logbook.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Logbook
                                </a>
                                <a href="{{ route('admin.report.index') }}" class="{{ request()->routeIs('admin.report.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Laporan
                                </a>
                                <a href="{{ route('admin.microskill.index') }}" class="{{ request()->routeIs('admin.microskill.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Mikro Skill
                                </a>
                                <a href="{{ route('admin.monitoring.index') }}" class="{{ request()->routeIs('admin.monitoring.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Monitoring
                                </a>
                            @elseif(auth()->user()->isMentor())
                                <a href="{{ route('mentor.dashboard') }}" class="{{ request()->routeIs('mentor.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Dashboard Mentor
                                </a>
                                <a href="{{ route('mentor.intern.index') }}" class="{{ request()->routeIs('mentor.intern.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Anak Bimbingan
                                </a>
                                <a href="{{ route('mentor.attendance.index') }}" class="{{ request()->routeIs('mentor.attendance.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Absensi
                                </a>
                                <a href="{{ route('mentor.logbook.index') }}" class="{{ request()->routeIs('mentor.logbook.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Logbook
                                </a>
                                <a href="{{ route('mentor.report.index') }}" class="{{ request()->routeIs('mentor.report.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Laporan Akhir
                                </a>
                                <a href="{{ route('mentor.microskill.index') }}" class="{{ request()->routeIs('mentor.microskill.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Mikro Skill
                                </a>
                            @else
                                <a href="{{ route('intern.dashboard') }}" class="{{ request()->routeIs('intern.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Dashboard
                                </a>
                                <a href="{{ route('intern.attendance.index') }}" class="{{ request()->routeIs('intern.attendance.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Absensi
                                </a>
                                <a href="{{ route('intern.logbook.index') }}" class="{{ request()->routeIs('intern.logbook.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Logbook
                                </a>
                                <a href="{{ route('intern.report.index') }}" class="{{ request()->routeIs('intern.report.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Laporan
                                </a>
                                <a href="{{ route('intern.microskill.index') }}" class="{{ request()->routeIs('intern.microskill.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Mikro Skill
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" id="icon-menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu" style="display: none;">
        <div class="pt-2 pb-3 space-y-1 px-4 bg-white border-b">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900">Dashboard</a>
                    <a href="{{ route('admin.intern.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Anak Magang</a>
                    <a href="{{ route('admin.attendance.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Absensi</a>
                    <a href="{{ route('admin.logbook.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Logbook</a>
                    <a href="{{ route('admin.report.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Laporan</a>
                    <a href="{{ route('admin.microskill.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Mikro Skill</a>
                    <a href="{{ route('admin.monitoring.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Monitoring</a>
                @elseif(auth()->user()->isMentor())
                    <a href="{{ route('mentor.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900">Dashboard Mentor</a>
                    <a href="{{ route('mentor.intern.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Anak Bimbingan</a>
                    <a href="{{ route('mentor.attendance.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Absensi</a>
                    <a href="{{ route('mentor.logbook.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Logbook</a>
                    <a href="{{ route('mentor.report.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Laporan Akhir</a>
                    <a href="{{ route('mentor.microskill.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Mikro Skill</a>
                @else
                    <a href="{{ route('intern.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900">Dashboard</a>
                    <a href="{{ route('intern.attendance.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Absensi</a>
                    <a href="{{ route('intern.logbook.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Logbook</a>
                    <a href="{{ route('intern.report.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Laporan</a>
                @endif

                <div class="border-t pt-3 mt-3">
                    <div class="px-3 py-2 text-gray-700">{{ auth()->user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50">Login</a>
            @endauth
        </div>
    </div>

    <main class="py-6">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
    <script>
        (function() {
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            const iconMenu = document.getElementById('icon-menu');
            const iconClose = document.getElementById('icon-close');
            if (!btn || !menu) return;
            btn.addEventListener('click', function() {
                const isHidden = menu.style.display === 'none' || menu.style.display === '';
                menu.style.display = isHidden ? 'block' : 'none';
                if (iconMenu && iconClose) {
                    iconMenu.classList.toggle('hidden', !isHidden ? false : true);
                    iconClose.classList.toggle('hidden', isHidden ? false : true);
                }
            });
        })();
    </script>
</body>
</html>