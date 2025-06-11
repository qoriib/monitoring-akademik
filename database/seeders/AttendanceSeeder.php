<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['Hadir', 'Sakit', 'Izin', 'Alfa'];
        $students = Student::all();

        foreach ($students as $student) {
            for ($i = 0; $i < 10; $i++) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => now()->subDays(rand(1, 30)),
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
