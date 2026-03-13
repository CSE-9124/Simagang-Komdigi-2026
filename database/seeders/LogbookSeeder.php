<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logbook;
use App\Models\Intern;
use Carbon\Carbon;

class LogbookSeeder extends Seeder
{
    public function run(): void
    {
        $interns = Intern::all();
        
        if ($interns->isEmpty()) {
            $this->command->warn('Tidak ada data intern. Jalankan InternSeeder terlebih dahulu.');
            return;
        }

        $activities = [
            'Mempelajari Laravel Routing dan Controller',
            'Implementasi CRUD untuk module User Management',
            'Membuat tampilan responsive dengan Tailwind CSS',
            'Debugging error pada fitur upload file',
            'Meeting dengan mentor membahas progress project',
            'Refactoring kode untuk meningkatkan performa',
            'Membuat dokumentasi API endpoints',
            'Testing fitur authentication dan authorization',
            'Integrasi database dengan migration dan seeder',
            'Code review bersama tim development'
        ];

        foreach ($interns as $intern) {
            // Generate logbook untuk 30 hari kerja terakhir
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                
                // Skip weekend (Sabtu & Minggu)
                if ($date->isWeekend()) {
                    continue;
                }

                Logbook::create([
                    'intern_id' => $intern->id,
                    'date' => $date->format('Y-m-d'),
                    'activity' => implode("\n\n", [
                        $activities[array_rand($activities)],
                        $activities[array_rand($activities)],
                        fake()->paragraph(2)
                    ]),
                    'photo_path' => rand(0, 1) ? 'dummy/logbook_' . uniqid() . '.jpg' : null,
                ]);
            }
        }

        $this->command->info('✅ Logbook seeder berhasil dijalankan!');
    }
}