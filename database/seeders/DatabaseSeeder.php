<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            SubjectSeeder::class,
            ClassroomSeeder::class,
            ScoreSeeder::class,
            AttendanceSeeder::class,
            AchievementSeeder::class,
        ]);
    }
}
