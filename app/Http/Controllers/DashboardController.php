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

        // Data kelas
        $classrooms = Classroom::with(['students.scores', 'students.attendances', 'students.achievements'])->get();

        // Rata-rata nilai per siswa keseluruhan
        $averageScores = Score::select('student_id', DB::raw('AVG(score) as avg_score'))
            ->groupBy('student_id')
            ->with('student.classrooms') // include kelas
            ->orderByDesc('avg_score')
            ->take(5)
            ->get();

        // Rata-rata nilai per siswa per kelas
        $topStudentsPerClassroom = Classroom::with(['students.scores'])
            ->get()
            ->mapWithKeys(function ($classroom) {
                $topStudents = $classroom->students
                    ->map(function ($student) use ($classroom) {
                        $avg = $student->scores
                            ->where('classroom_id', $classroom->id)
                            ->avg('score');
                        return [
                            'student' => $student,
                            'avg_score' => $avg
                        ];
                    })
                    ->filter(fn($data) => $data['avg_score'] !== null)
                    ->sortByDesc('avg_score')
                    ->take(1)
                    ->values();

                return [$classroom->name => $topStudents];
            });

        // Absensi terbaik (paling banyak hadir)
        $topAttendance = Attendance::where('status', 'Hadir')
            ->select('student_id', DB::raw('COUNT(*) as hadir_count'))
            ->groupBy('student_id')
            ->with('student')
            ->orderByDesc('hadir_count')
            ->take(5)
            ->get();

        // Prestasi terbanyak
        $topAchievements = Achievement::select('student_id', DB::raw('COUNT(*) as count'))
            ->groupBy('student_id')
            ->with('student')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'classrooms',
            'studentCount',
            'classroomCount',
            'subjectCount',
            'averageScores',
            'topStudentsPerClassroom',
            'topAttendance',
            'topAchievements'
        ));
    }
}
