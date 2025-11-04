<?php

namespace Database\Seeders;

use App\Models\Intern;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create/Update Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@simagang.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@simagang.com');
        $this->command->info('Password: password123');

        // Reset mentors and mentor users, then seed mentor names per request
        \App\Models\Intern::query()->update(['mentor_id' => null]);
        Mentor::query()->delete();
        User::where('role', 'mentor')->delete();

        $mentorNames = [
            'andar', 'aswar', 'bahrawi', 'fadly', 'fajriani', 'farhan',
            'harbaedy', 'herman', 'olga', 'rudy', 'solehuddin', 'tasmil', 'yayat', 'irfan',
        ];

        $mentors = collect($mentorNames)->map(function ($name) {
            return Mentor::create([
                'name' => ucwords($name),
                'email' => null,
                'position' => null,
                'phone' => null,
                'is_active' => true,
                'user_id' => null,
            ]);
        });
        $this->command->info('Mentors seeded: ' . $mentors->count());

        // Create sample intern users
        $interns = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'Laki-laki',
                'education_level' => 'S1/D4',
                'major' => 'Teknik Informatika',
                'student_id' => '1234567890',
                'institution' => 'Universitas Contoh',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'Perempuan',
                'education_level' => 'SMA/SMK',
                'major' => 'Rekayasa Perangkat Lunak',
                'student_id' => '9876543210',
                'institution' => 'SMK Teknologi',
                'start_date' => now()->subDays(20),
                'end_date' => now()->addDays(70),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'Laki-laki',
                'education_level' => 'S1/D4',
                'major' => 'Sistem Informasi',
                'student_id' => '1122334455',
                'institution' => 'Universitas Negeri',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(80),
            ],
        ];

        foreach ($interns as $internData) {
            $user = User::updateOrCreate(
                ['email' => $internData['email']],
                [
                    'name' => $internData['name'],
                    'password' => $internData['password'],
                    'role' => 'intern',
                ]
            );

            $intern = Intern::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $internData['name'],
                    'gender' => $internData['gender'],
                    'education_level' => $internData['education_level'],
                    'major' => $internData['major'],
                    'student_id' => $internData['student_id'],
                    'institution' => $internData['institution'],
                    'mentor_id' => null,
                    'start_date' => $internData['start_date'],
                    'end_date' => $internData['end_date'],
                    'photo_path' => null, // No photo for seeded users
                    'is_active' => true,
                ]
            );

            // Distribute mentors round-robin
            if ($mentors->count() > 0) {
                $index = ($intern->id - 1) % $mentors->count();
                $intern->mentor_id = $mentors[$index]->id;
            }
            $intern->save();
        }

        $this->command->info('Sample intern users created (password: password123):');
        foreach ($interns as $intern) {
            $this->command->info('- ' . $intern['email']);
        }
    }
}