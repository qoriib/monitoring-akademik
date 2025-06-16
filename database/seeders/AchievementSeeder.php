<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Student;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = ['Lokal', 'Kota', 'Provinsi', 'Nasional'];
        $students = Student::has('classrooms')->take(5)->get(); // pastikan siswa punya kelas

        foreach ($students as $student) {
            $classroomId = $student->classrooms()->inRandomOrder()->first()?->id;

            if ($classroomId) {
                Achievement::create([
                    'student_id' => $student->id,
                    'classroom_id' => $classroomId,
                    'title' => 'Juara ' . rand(1, 3) . ' Olimpiade',
                    'description' => 'Prestasi dalam bidang akademik',
                    'level' => $levels[array_rand($levels)],
                    'date' => now()->subMonths(rand(1, 6)),
                ]);
            }
        }
    }
}
