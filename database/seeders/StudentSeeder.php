<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['nisn' => '1234567890', 'name' => 'Ahmad Fajar', 'class' => 'X IPA 1'],
            ['nisn' => '1234567891', 'name' => 'Siti Rahma', 'class' => 'X IPA 1'],
            ['nisn' => '1234567892', 'name' => 'Budi Santoso', 'class' => 'X IPA 1'],
            ['nisn' => '1234567893', 'name' => 'Rina Marlina', 'class' => 'X IPA 2'],
            ['nisn' => '1234567894', 'name' => 'Dedi Prasetyo', 'class' => 'X IPA 2'],
            ['nisn' => '1234567895', 'name' => 'Linda Kurnia', 'class' => 'X IPS 1'],
            ['nisn' => '1234567896', 'name' => 'Eka Putri', 'class' => 'X IPS 1'],
            ['nisn' => '1234567897', 'name' => 'Rizky Maulana', 'class' => 'X IPS 1'],
            ['nisn' => '1234567898', 'name' => 'Maya Sari', 'class' => 'X IPS 2'],
            ['nisn' => '1234567899', 'name' => 'Fajar Nugroho', 'class' => 'X IPS 2'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
