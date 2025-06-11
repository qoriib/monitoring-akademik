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
        $students = Student::take(5)->get(); // hanya 5 siswa yang punya prestasi

        foreach ($students as $student) {
            Achievement::create([
                'student_id' => $student->id,
                'title' => 'Juara ' . rand(1, 3) . ' Olimpiade',
                'description' => 'Prestasi dalam bidang akademik',
                'level' => $levels[array_rand($levels)],
                'date' => now()->subMonths(rand(1, 6)),
            ]);
        }
    }
}
