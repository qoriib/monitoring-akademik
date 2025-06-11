<?php

namespace Database\Seeders;

use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $subjects = Subject::all();

        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                Score::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'semester' => 'Ganjil 2024/2025',
                    'score' => rand(60, 100),
                ]);
            }
        }
    }
}
