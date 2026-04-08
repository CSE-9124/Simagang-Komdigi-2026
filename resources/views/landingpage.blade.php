<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simagang - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .section-card {
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(14px);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-sky-950 via-slate-950 to-blue-950 text-slate-100">
    <div class="min-h-screen">
        <header class="sticky top-0 z-50 border-b border-slate-700 bg-slate-950/90 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="#hero" class="flex items-center gap-3 text-white">
                    <img src="{{ url('storage/vendor/logo_komdigi.png') }}" alt="Komdigi" class="h-12 w-12 rounded-full border border-slate-500 bg-white/10 p-1" />
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-300">Simagang</p>
                        <p class="text-xl font-bold text-white">Komdigi</p>
                    </div>
                </a>
                <nav class="hidden items-center gap-6 text-sm font-medium text-slate-300 lg:flex">
                    <a href="#hero" class="hover:text-white">Hero</a>
                    <a href="#process" class="hover:text-white">Proses</a>
                    <a href="#usage" class="hover:text-white">Penggunaan</a>
                    <a href="#testimonials" class="hover:text-white">Testimoni</a>
                    <a href="#partners" class="hover:text-white">Partner</a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="rounded-full bg-cyan-500 px-5 py-2.5 text-sm font-semibold text-slate-950 shadow-lg shadow-cyan-500/30 transition hover:bg-cyan-400">Login</a>
                </div>
            </div>
        </header>

        <main>
            <section id="hero" class="relative overflow-hidden bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.18),_transparent_32rem),radial-gradient(circle_at_bottom_right,_rgba(56,189,248,0.14),_transparent_24rem)] py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                        <div class="space-y-8">
                            <span class="inline-flex items-center rounded-full bg-cyan-500/15 px-3 py-1 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-200">Portal Magang Terintegrasi</span>
                            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Sistem Manajemen Anak Magang Komdigi</h1>
                            <p class="max-w-xl text-lg leading-8 text-slate-300">Pantau absensi, kelola logbook, nilai laporan, dan ajarkan mikro skill dengan satu aplikasi yang mudah digunakan bagi siswa, mentor, dan admin.</p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-cyan-500 px-6 py-3 text-base font-semibold text-slate-950 transition hover:bg-cyan-400">Masuk Sekarang</a>
                                <a href="#process" class="inline-flex items-center justify-center rounded-full border border-slate-600 bg-white/5 px-6 py-3 text-base font-semibold text-slate-100 transition hover:border-cyan-400 hover:text-cyan-200">Lihat Alur</a>
                            </div>
                        </div>
                        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-3 rounded-3xl border border-white/10 bg-slate-900/80 p-6">
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-500 text-slate-950"><i class="fas fa-user-check"></i></div>
                                    <h3 class="text-lg font-semibold text-white">Daftar Cepat</h3>
                                    <p class="text-sm leading-6 text-slate-400">Buat akun dan lengkapi profil kampus atau sekolah.</p>
                                </div>
                                <div class="space-y-3 rounded-3xl border border-white/10 bg-slate-900/80 p-6">
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-500 text-white"><i class="fas fa-calendar-check"></i></div>
                                    <h3 class="text-lg font-semibold text-white">Absensi dan Logbook</h3>
                                    <p class="text-sm leading-6 text-slate-400">Kelola jadwal dan catatan praktik selama magang.</p>
                                </div>
                                <div class="space-y-3 rounded-3xl border border-white/10 bg-slate-900/80 p-6">
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-400 text-slate-950"><i class="fas fa-file-alt"></i></div>
                                    <h3 class="text-lg font-semibold text-white">Laporan Akhir</h3>
                                    <p class="text-sm leading-6 text-slate-400">Upload dan review hasil laporan dengan mudah.</p>
                                </div>
                                <div class="space-y-3 rounded-3xl border border-white/10 bg-slate-900/80 p-6">
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-500 text-white"><i class="fas fa-award"></i></div>
                                    <h3 class="text-lg font-semibold text-white">Sertifikat Digital</h3>
                                    <p class="text-sm leading-6 text-slate-400">Dapatkan sertifikat resmi setelah selesai magang.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="process" class="bg-slate-950 py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto mb-12 max-w-2xl text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-400">Proses Alur Magang</p>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">Sistem magang langkah demi langkah.</h2>
                        <p class="mt-4 text-lg leading-8 text-slate-400">Dari pendaftaran hingga sertifikat, semua proses magang dikelola di satu platform.</p>
                    </div>
                    <div class="grid gap-8 lg:grid-cols-3">
                        <article class="section-card rounded-3xl border border-white/10 p-8 shadow-lg shadow-slate-950/20">
                            <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500 text-white"><i class="fas fa-edit text-xl"></i></div>
                            <h3 class="text-xl font-semibold text-white">1. Pendaftaran & Profil</h3>
                            <p class="mt-3 text-slate-300">Lengkapi data peserta, pilih lembaga, dan siapkan detail mentor secara cepat.</p>
                        </article>
                        <article class="section-card rounded-3xl border border-white/10 p-8 shadow-lg shadow-slate-950/20">
                            <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-500 text-slate-950"><i class="fas fa-calendar-day text-xl"></i></div>
                            <h3 class="text-xl font-semibold text-white">2. Absensi & Logbook</h3>
                            <p class="mt-3 text-slate-300">Catat kehadiran dan tulis laporan harian untuk memantau perkembangan magang.</p>
                        </article>
                        <article class="section-card rounded-3xl border border-white/10 p-8 shadow-lg shadow-slate-950/20">
                            <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-400 text-slate-950"><i class="fas fa-chart-line text-xl"></i></div>
                            <h3 class="text-xl font-semibold text-white">3. Laporan & Sertifikat</h3>
                            <p class="mt-3 text-slate-300">Mentor dan admin menilai laporan akhir, lalu terbitkan sertifikat digital resmi.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="usage" class="bg-slate-900 py-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">

                    <!-- HEADER -->
                    <div class="text-center max-w-2xl mx-auto">
                        <h2 class="text-3xl font-bold text-white sm:text-4xl">
                            Cara Menggunakan Aplikasi
                        </h2>
                        <p class="mt-4 text-slate-400">
                            Ikuti langkah-langkah berikut untuk memahami alur penggunaan sistem.
                        </p>
                    </div>

                    <!-- STEP 1 -->
                    <div class="grid md:grid-cols-2 gap-10 items-center">
                        <div>
                            <img src="{{ asset('storage/tutorial/dashboardLP.png') }}" 
                                class="rounded-2xl shadow-xl hover:scale-105 transition duration-500"
                                alt="Dashboard">
                        </div>
                        <div>
                            <p class="text-cyan-400 uppercase text-sm tracking-widest">Step 1</p>
                            <h3 class="text-white text-2xl font-semibold mt-2">
                                Login & Pilih Role
                            </h3>
                            <p class="text-slate-400 mt-4">
                                Masuk menggunakan akun Anda, lalu pilih role seperti Intern, Mentor, atau Admin untuk mengakses fitur sesuai kebutuhan.
                            </p>
                        </div>
                    </div>

                    <!-- STEP 2 (REVERSE) -->
                    <div class="grid md:grid-cols-2 gap-10 items-center">
                        <div class="order-2 md:order-1">
                            <p class="text-cyan-400 uppercase text-sm tracking-widest">Step 2</p>
                            <h3 class="text-white text-2xl font-semibold mt-2">
                                Kelola Absensi
                            </h3>
                            <p class="text-slate-400 mt-4">
                                Lakukan absensi harian dan pantau kehadiran secara real-time melalui dashboard sistem.
                            </p>
                        </div>
                        <div class="order-1 md:order-2">
                            <img src="{{ asset('storage/tutorial/absensi.png') }}" 
                                class="rounded-2xl shadow-xl hover:scale-105 transition duration-500"
                                alt="Absensi">
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div class="grid md:grid-cols-2 gap-10 items-center">
                        <div>
                            <img src="{{ asset('storage/tutorial/logbook.png') }}" 
                                class="rounded-2xl shadow-xl hover:scale-105 transition duration-500"
                                alt="Logbook">
                        </div>
                        <div>
                            <p class="text-cyan-400 uppercase text-sm tracking-widest">Step 3</p>
                            <h3 class="text-white text-2xl font-semibold mt-2">
                                Isi Logbook Harian
                            </h3>
                            <p class="text-slate-400 mt-4">
                                Catat semua aktivitas selama magang sebagai dokumentasi dan bahan evaluasi.
                            </p>
                        </div>
                    </div>

                    <!-- STEP 4 (REVERSE) -->
                    <div class="grid md:grid-cols-2 gap-10 items-center">
                        <div class="order-2 md:order-1">
                            <p class="text-cyan-400 uppercase text-sm tracking-widest">Step 4</p>
                            <h3 class="text-white text-2xl font-semibold mt-2">
                                Upload Laporan
                            </h3>
                            <p class="text-slate-400 mt-4">
                                Unggah laporan akhir, cek penilaian, dan unduh sertifikat setelah program selesai.
                            </p>
                        </div>
                        <div class="order-1 md:order-2">
                            <img src="{{ asset('storage/tutorial/laporan.png') }}" 
                                class="rounded-2xl shadow-xl hover:scale-105 transition duration-500"
                                alt="Laporan">
                        </div>
                    </div>

                </div>
            </section>

            <section id="testimonials" class="bg-slate-950 py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto mb-12 max-w-2xl text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-400">Testimoni</p>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">Apa kata partner dan peserta magang?</h2>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="section-card rounded-3xl border border-white/10 p-8 shadow-lg shadow-slate-950/20">
                            <p class="text-slate-300">“Simagang membuat proses pelaporan dan pendampingan magang jauh lebih teratur. Mentor mudah memeriksa logbook dan melaporkan hasil magang.”</p>
                            <div class="mt-6">
                                <p class="font-semibold text-white">Mentor Program</p>
                                <p class="text-sm text-slate-400">Universitas Hasanuddin</p>
                            </div>
                        </div>
                        <div class="section-card rounded-3xl border border-white/10 p-8 shadow-lg shadow-slate-950/20">
                            <p class="text-slate-300">“Platformnya sangat membantu siswa untuk mencatat aktivitas magang dan mengumpulkan laporan tepat waktu.”</p>
                            <div class="mt-6">
                                <p class="font-semibold text-white">Peserta Magang</p>
                                <p class="text-sm text-slate-400">SMK Telkom Makassar</p>
                            </div>
                        </div>
                        <div class="section-card rounded-3xl border border-white/10 p-8 shadow-lg shadow-slate-950/20">
                            <p class="text-slate-300">“Komdigi memberikan pengalaman digital yang profesional untuk koordinasi magang kampus dan industri.”</p>
                            <div class="mt-6">
                                <p class="font-semibold text-white">Koordinator Magang</p>
                                <p class="text-sm text-slate-400">Universitas Negeri Makassar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="partners" class="bg-slate-900 py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto mb-10 max-w-2xl text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-400">Sekolah & Universitas</p>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">Institusi yang pernah magang di Komdigi</h2>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas Hasanuddin</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas Negeri Makassar</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas DIPA Makassar</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas Islam Negeri Alauddin Makassar</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas Bosowa</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas Sulawesi Barat</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">Universitas Multimedia Nusantara</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">SMK Telkom Makassar</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">SMK Handayani Makassar</div>
                        <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-6 text-center text-slate-200 shadow-lg shadow-slate-950/20">SMK Negeri 5 Gowa</div>
                    </div>
                </div>
            </section>

            <section class="bg-slate-950 py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-8 text-center text-slate-300 shadow-lg shadow-slate-950/20">
                        <p class="text-sm uppercase tracking-[0.3em] text-cyan-400">Mulai magang bersama Komdigi</p>
                        <h2 class="mt-4 text-2xl font-bold text-white sm:text-3xl">Sistem manajemen magang yang siap mendukung pembelajaran dan praktik.</h2>
                        <a href="{{ route('login') }}" class="mt-8 inline-flex rounded-full bg-cyan-500 px-8 py-3 text-base font-semibold text-slate-950 transition hover:bg-cyan-400">Login Sekarang</a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
