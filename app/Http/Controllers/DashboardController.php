<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $studentCount = Student::count();
        $classroomCount = Classroom::count();
        $subjectCount = Subject::count();

        // Rata-rata nilai per siswa
        $averageScores = Score::select('student_id', DB::raw('AVG(score) as avg_score'))
            ->groupBy('student_id')
            ->with('student')
            ->orderByDesc('avg_score')
            ->take(5)
            ->get();

        // Absensi terbaik (paling banyak hadir)
        $topAttendance = Attendance::where('status', 'Hadir')
            ->select('student_id', DB::raw('COUNT(*) as hadir_count'))
            ->groupBy('student_id')
            ->orderByDesc('hadir_count')
            ->take(5)
            ->get();

        // Prestasi terbanyak
        $topAchievements = Achievement::select('student_id', DB::raw('COUNT(*) as count'))
            ->groupBy('student_id')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'studentCount',
            'classroomCount',
            'subjectCount',
            'averageScores',
            'topAttendance',
            'topAchievements'
        ));
    }
}
