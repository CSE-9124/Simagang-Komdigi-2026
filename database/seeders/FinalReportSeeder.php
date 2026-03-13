<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinalReport;
use App\Models\Intern;
use Carbon\Carbon;

class FinalReportSeeder extends Seeder
{
    public function run(): void
    {
        $interns = Intern::all();
        
        if ($interns->isEmpty()) {
            $this->command->warn('Tidak ada data intern. Jalankan InternSeeder terlebih dahulu.');
            return;
        }

        // Deskripsi aktivitas yang panjang (1 teks per varian)
        $activitiesDescriptions = [
            "Selama melaksanakan magang selama 3 bulan di Kementerian Komunikasi dan Informatika, saya terlibat dalam pengembangan sistem informasi manajemen magang yang komprehensif. Pada awal periode magang, saya mempelajari Laravel Framework dan memahami arsitektur MVC Pattern untuk membangun fondasi yang kuat. Saya kemudian fokus pada pengembangan frontend menggunakan Laravel Blade Template dan Tailwind CSS dengan memastikan tampilan responsive dan mobile-friendly. Selanjutnya, saya mengimplementasikan fitur CRUD (Create, Read, Update, Delete) untuk berbagai modul seperti manajemen user, absensi, micro skill, logbook, dan laporan akhir. Saya juga berhasil membuat sistem authentication multi-role (Admin, Mentor, Intern) dengan middleware untuk pembatasan akses yang sesuai. Dalam proses pengembangan, saya mengimplementasikan fitur upload file untuk foto absensi, dokumen izin/sakit, bukti micro skill, dan laporan akhir dengan validasi tipe dan ukuran file yang ketat. Database design dilakukan dengan normalisasi yang baik, membuat migration files, dan menggunakan Eloquent ORM untuk relasi antar tabel. Selama pengembangan, saya melakukan testing berkelanjutan dan debugging untuk setiap fitur, memperbaiki bug yang ditemukan, dan optimasi performa aplikasi. Terakhir, saya membuat dokumentasi lengkap tentang kode dan user manual untuk memudahkan pengguna dalam menggunakan aplikasi.",

            "Pengalaman magang ini memberikan kesempatan emas untuk mendalami web development dengan teknologi modern. Saya memulai dengan analisis requirement sistem magang digital dan membuat user stories bersama dengan tim mentor. Desain database schema dilakukan dengan mempertimbangkan normalisasi data, membuat migration files, dan melakukan data seeding untuk testing. Saya mempelajari dan mengimplementasikan Eloquent ORM secara mendalam, termasuk relasi one-to-many dan many-to-many antar tabel. Dalam pengembangan API, saya membuat REST API endpoints yang terstruktur dengan response JSON yang konsisten dan error handling yang proper. Form validation diimplementasikan menggunakan Laravel Form Request dengan menampilkan error messages yang informatif kepada pengguna. Session management dikonfigurasi untuk fitur remember me dan flash messages untuk notifikasi kepada pengguna. Saya juga melakukan code review berkala dengan mentor dan melakukan refactoring untuk meningkatkan code quality sesuai dengan best practices Laravel development. Kolaborasi dengan tim development dilakukan menggunakan Git version control dengan branching strategy yang baik untuk setiap fitur development.",

            "Periode magang ini memberikan pengalaman mendalam dalam full-stack web development. Saya memulai dengan mempelajari version control menggunakan Git dan GitHub untuk memahami collaborative development workflow. Implementasi security features menjadi prioritas, termasuk CSRF protection, XSS prevention, SQL injection prevention, dan secure password hashing menggunakan bcrypt. Optimasi database query dilakukan dengan eager loading dan indexing untuk meningkatkan kecepatan response aplikasi secara signifikan. Fitur logbook dikembangkan dengan mengintegrasikan date picker dan photo upload untuk dokumentasi aktivitas harian yang komprehensif. Sistem micro skill dikembangkan dengan mekanisme submission dan approval yang user-friendly untuk tracking pengembangan skill. Email notification diintegrasikan untuk memberikan notifikasi otomatis kepada pengguna tentang status approval dokumen. Persiapan deployment aplikasi ke production server dilakukan dengan konfigurasi environment variables yang aman dan optimasi asset untuk production build.",

            "Selama menjalankan praktik magang, saya berhasil memahami arsitektur aplikasi Laravel secara menyeluruh dan menerapkan best practices dalam pengembangan web modern. Fitur attendance tracking dikembangkan dengan sistem check-in dan check-out menggunakan foto dokumentasi untuk keamanan dan akurasi. Dashboard interaktif dibuat untuk visualisasi data menggunakan chart dan statistik real-time yang memudahkan monitoring. Sistem approval workflow dikembangkan untuk dokumen izin dan sakit dengan multi-level approval sesuai dengan hirarki organizational. Export data ke format PDF dan Excel diimplementasikan untuk laporan dan dokumentasi yang memudahkan pelaporan kepada stakeholder. Daily standup meeting dengan mentor dilakukan untuk diskusi progress, troubleshooting, dan feedback berkelanjutan. Code review session secara regular membantu saya menerima feedback konstruktif dan terus meningkatkan kemampuan programming.",

            "Pembelajaran selama magang mencakup pemahaman mendalam tentang Eloquent relationships dan query optimization techniques untuk meningkatkan performance aplikasi. Fitur laporan akhir dikembangkan dengan dukungan upload multiple files dan project links untuk dokumentasi project yang komprehensif. Sistem penilaian otomatis diimplementasikan berdasarkan kriteria yang telah ditetapkan untuk transparansi dan objektifitas evaluasi. Middleware custom dikembangkan untuk role-based access control pada berbagai halaman aplikasi sesuai dengan permission pengguna. Integration testing dilakukan untuk memastikan setiap modul berjalan sesuai dengan requirements dan tidak ada konflik antar fitur. Asset optimization dilakukan dengan minification CSS dan JavaScript untuk production build guna meningkatkan kecepatan loading. Dokumentasi API lengkap dengan Postman collection dibuat untuk memudahkan integrasi dengan sistem lain atau tim development yang berbeda.",
        ];

        foreach ($interns as $intern) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $submittedAt = Carbon::now()->subDays(rand(1, 14));
            
            // Ambil 1 deskripsi aktivitas panjang (random)
            $selectedDescription = $activitiesDescriptions[array_rand($activitiesDescriptions)];
            
            // ✅ Array dengan 1 item yang berisi deskripsi panjang
            $activities = [
                ['description' => $selectedDescription]
            ];
            
            $data = [
                'intern_id' => $intern->id,
                'file_path' => 'dummy/reports/final_report_' . $intern->id . '.pdf',
                'file_name' => 'Laporan_Akhir_' . str_replace(' ', '_', $intern->name) . '.pdf',
                'status' => $status,
                'submitted_at' => $submittedAt,
                
                // ✅ ACTIVITIES: Array dengan 1 item
                'activities' => $activities,
                
                // ✅ PROJECT_LINKS: Array
                'project_links' => [
                    'https://github.com/' . strtolower(str_replace(' ', '-', $intern->name)) . '/simagang-project',
                    'https://demo-simagang.example.com/' . strtolower(str_replace(' ', '-', $intern->name))
                ],
                
                'project_file' => 'dummy/projects/project_' . $intern->id . '.zip',
                'project_file_name' => 'Project_' . str_replace(' ', '_', $intern->name) . '.zip',
                'project_link' => 'https://github.com/' . strtolower(str_replace(' ', '-', $intern->name)) . '/simagang-project',
            ];

            // Jika approved, berikan grade dan score
            if ($status === 'approved') {
                $score = rand(75, 100);
                $data['score'] = $score;
                $data['grade'] = $score >= 85 ? 'A' : ($score >= 70 ? 'B' : 'C');
                $data['needs_revision'] = false;
                $data['admin_note'] = 'Laporan berkualitas baik dengan deskripsi aktivitas yang sangat detail dan terukur. Dokumentasi lengkap dan mudah dipahami. Pertahankan standar kerja yang baik!';
            } elseif ($status === 'pending') {
                $data['needs_revision'] = rand(0, 1) ? true : false;
                if ($data['needs_revision']) {
                    $data['admin_note'] = 'Laporan masih dalam tahap review. Mohon perbaiki beberapa bagian: lengkapi deskripsi aktivitas, tambahkan hasil output, dan perbaiki format penulisan sesuai guidelines.';
                } else {
                    $data['admin_note'] = null;
                }
            } else {
                $data['admin_note'] = 'Laporan ditolak karena tidak memenuhi standar minimal. Deskripsi aktivitas terlalu singkat, kurang detail, dan tidak sesuai dengan kriteria penilaian. Silakan revisi dan submit ulang.';
            }

            FinalReport::create($data);
        }

        $this->command->info('✅ FinalReport seeder berhasil dijalankan!');
    }
}