<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MicroSkillSubmission;
use App\Models\Intern;
use Carbon\Carbon;

class MicroSkillSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $interns = Intern::all();
        
        if ($interns->isEmpty()) {
            $this->command->warn('Tidak ada data intern. Jalankan InternSeeder terlebih dahulu.');
            return;
        }

        $skills = [
            'HTML & CSS Fundamentals',
            'JavaScript ES6+',
            'Laravel Blade Templates',
            'Database Design',
            'API Integration',
            'Git Version Control',
            'Tailwind CSS Styling',
            'PHP OOP Concepts',
            'Authentication & Authorization',
            'Responsive Web Design',
            'RESTful API Development',
            'Laravel Eloquent ORM',
            'Middleware Implementation',
            'Form Validation',
            'File Upload Handling',
            'Session Management',
            'Error Handling & Debugging',
            'Database Migration',
            'Query Optimization',
            'Laravel Seeder & Factory'
        ];

        foreach ($interns as $intern) {
            // Shuffle skills array untuk variasi antar intern
            $shuffledSkills = $skills;
            shuffle($shuffledSkills);
            
            // Setiap intern submit 5-10 micro skills (BERURUTAN, TIDAK DUPLIKAT)
            $count = rand(5, min(10, count($skills))); // Pastikan tidak melebihi jumlah skill
            
            for ($i = 0; $i < $count; $i++) {
                $submittedAt = Carbon::now()->subDays(rand(1, 60));
                $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
                
                $data = [
                    'intern_id' => $intern->id,
                    'title' => $shuffledSkills[$i], // Ambil BERURUTAN dari array yang sudah di-shuffle
                    'description' => fake()->paragraph(3),
                    'photo_path' => 'dummy/microskill_' . uniqid() . '.jpg',
                    'status' => $status,
                    'submitted_at' => $submittedAt,
                ];

                // Jika sudah direview (approved/rejected)
                if ($status !== 'pending') {
                    $data['reviewed_at'] = $submittedAt->copy()->addDays(rand(1, 3));
                    $data['review_note'] = fake()->sentence();
                }

                MicroSkillSubmission::create($data);
            }
        }

        $this->command->info('✅ MicroSkillSubmission seeder berhasil dijalankan!');
    }
}