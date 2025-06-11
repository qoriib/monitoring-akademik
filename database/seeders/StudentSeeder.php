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
            ['nisn' => '1234567890', 'name' => 'Ahmad Fajar'],
            ['nisn' => '1234567891', 'name' => 'Siti Rahma'],
            ['nisn' => '1234567892', 'name' => 'Budi Santoso'],
            ['nisn' => '1234567893', 'name' => 'Rina Marlina'],
            ['nisn' => '1234567894', 'name' => 'Dedi Prasetyo'],
            ['nisn' => '1234567895', 'name' => 'Linda Kurnia'],
            ['nisn' => '1234567896', 'name' => 'Eka Putri'],
            ['nisn' => '1234567897', 'name' => 'Rizky Maulana'],
            ['nisn' => '1234567898', 'name' => 'Maya Sari'],
            ['nisn' => '1234567899', 'name' => 'Fajar Nugroho'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
