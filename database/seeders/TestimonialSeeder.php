<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\FinalReport;
use App\Models\Intern;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy testimonials data
        $dummyTestimonials = [
            [
                'testimony' => 'Aplikasi ini membuat koordinasi dengan mentor jadi lebih cepat. Saya bisa melihat nilai, laporan, dan tugas harian tanpa harus bolak-balik chat. Platform yang sangat membantu dalam mengelola program magang.',
            ],
            [
                'testimony' => 'Simagang memudahkan saya mencatat absensi, mengirim logbook, dan melihat progres magang dalam satu platform. Semua tugas dan feedback mentor jadi lebih terorganisir dan mudah dipantau.',
            ],
            [
                'testimony' => 'Tampilan Simagang bersih dan intuitif, jadi saya bisa bekerja lebih fokus. Sistem ini sangat membantu menyelesaikan laporan dan persiapan sertifikat magang dengan lebih efisien.',
            ],
            [
                'testimony' => 'Fitur monitoring real-time sangat membantu mentor dalam mengawasi perkembangan kami. Interface yang user-friendly membuat proses pelaporan menjadi lebih mudah dan cepat.',
            ],
            [
                'testimony' => 'Sistem Simagang sangat profesional dan terintegrasi dengan baik. Saya senang dengan fitur notifikasi yang membuat saya tidak pernah ketinggalan informasi penting dari mentor.',
            ],
            [
                'testimony' => 'Pengalaman menggunakan Simagang sangat memuaskan. Dari absensi hingga pembuatan laporan akhir, semuanya berjalan lancar. Rekomendasi aplikasi yang bagus untuk institusi magang.',
            ],
        ];

        // Get first 6 interns to have 6 testimonials
        $interns = Intern::orderBy('id')->limit(3)->get();

        if ($interns->isEmpty()) {
            $this->command->warn('❌ Tidak ada intern ditemukan.');
            return;
        }

        $this->command->info('✓ Ditemukan ' . $interns->count() . ' intern. Membuat ' . min(6, count($dummyTestimonials)) . ' testimoni...');

        // Create or get final reports and testimonials for first 6 interns
        foreach ($interns as $index => $intern) {
            if ($index >= count($dummyTestimonials)) {
                break; // Stop if we've used all dummy testimonials
            }

            $report = FinalReport::where('intern_id', $intern->id)->first();
            
            if (!$report) {
                // Create a dummy final report for this intern
                $report = FinalReport::create([
                    'intern_id' => $intern->id,
                    'file_path' => 'dummy/report_' . $intern->id . '.pdf',
                    'file_name' => 'Laporan_' . $intern->name . '.pdf',
                    'status' => 'approved',
                    'submitted_at' => now(),
                ]);
                $this->command->info("  ✓ FinalReport dibuat untuk " . $intern->name);
            }

            // Create testimonial if not exists
            $exists = Testimonial::where('final_report_id', $report->id)->exists();

            if (!$exists) {
                Testimonial::create([
                    'final_report_id' => $report->id,
                    'intern_id' => $intern->id,
                    'testimony' => $dummyTestimonials[$index]['testimony'],
                ]);
                $this->command->info("  ✓ Testimoni ditambahkan untuk " . $intern->name);
            }
        }

        $this->command->info("\n✓ Semua testimoni dummy berhasil disimpan!");
    }
}
