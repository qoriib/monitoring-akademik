<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = '2024/2025';
        $baseNames = ['X IPA', 'X IPS', 'XI IPA', 'XI IPS', 'XII IPA', 'XII IPS'];
        $maxKelasPerBase = 3;

        $counterPerBase = [];

        // Total kelas yang akan dibuat
        $totalClassrooms = 12;

        for ($i = 0; $i < $totalClassrooms; $i++) {
            // Ambil base nama secara urut
            $baseName = $baseNames[$i % count($baseNames)];

            // Hitung index per base
            if (!isset($counterPerBase[$baseName])) {
                $counterPerBase[$baseName] = 1;
            }

            $className = "$baseName {$counterPerBase[$baseName]}";
            $counterPerBase[$baseName]++;

            // Tetapkan semester: 1-6 Ganjil, sisanya Genap
            $semester = $i < ($totalClassrooms / 2) ? 'Ganjil' : 'Genap';

            $classroom = Classroom::create([
                'name' => $className,
                'academic_year' => $academicYear,
                'semester' => $semester,
            ]);

            // Ambil 5–10 siswa acak
            $students = Student::inRandomOrder()->take(rand(5, 10))->pluck('id');
            $classroom->students()->attach($students);

            // Ambil 3–6 mata pelajaran acak
            $subjects = Subject::inRandomOrder()->take(rand(3, 6))->pluck('id');
            $classroom->subjects()->attach($subjects);
        }
    }
}
