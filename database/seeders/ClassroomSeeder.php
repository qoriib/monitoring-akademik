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
        // 1. Data kelas
        $classroomData = [
            ['name' => 'X IPA 1', 'academic_year' => '2024/2025'],
            ['name' => 'X IPA 2', 'academic_year' => '2024/2025'],
            ['name' => 'X IPS 1', 'academic_year' => '2024/2025'],
        ];

        // 2. Buat kelas
        foreach ($classroomData as $data) {
            $classroom = Classroom::create($data);

            // 3. Ambil 3–5 siswa acak dan masukkan ke kelas
            $students = Student::inRandomOrder()->take(rand(3, 5))->pluck('id');
            $classroom->students()->attach($students);

            // 4. Ambil 2–4 mata pelajaran acak dan masukkan ke kelas
            $subjects = Subject::inRandomOrder()->take(rand(2, 4))->pluck('id');
            $classroom->subjects()->attach($subjects);
        }
    }
}
