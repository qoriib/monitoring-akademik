<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Score;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop semua kelas
        foreach (Classroom::with(['students', 'subjects'])->get() as $classroom) {
            $students = $classroom->students;
            $subjects = $classroom->subjects;

            // Untuk setiap siswa di kelas itu
            foreach ($students as $student) {
                // Untuk setiap mata pelajaran di kelas itu
                foreach ($subjects as $subject) {
                    // Buat nilai acak antara 60 dan 100
                    Score::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'classroom_id' => $classroom->id,
                        'score' => rand(60, 100) + rand(0, 99) / 100, // nilai decimal 2 digit
                    ]);
                }
            }
        }
    }
}
