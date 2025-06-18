<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Halaman rekap nilai
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::orderByDesc('academic_year')->orderBy('name')->get();
        $semester = $request->semester ?? 'Ganjil';

        $selectedClassroom = null;
        $students = [];
        $subjects = [];

        if ($request->filled('classroom_id')) {
            $selectedClassroom = Classroom::with(['students.scores', 'subjects'])
                ->findOrFail($request->classroom_id);
        }

        if ($selectedClassroom) {
            $students = $selectedClassroom->students;
            $subjects = $selectedClassroom->subjects;
        }

        return view('scores.index', compact(
            'classrooms',
            'selectedClassroom',
            'students',
            'subjects',
            'semester'
        ));
    }

    /**
     * Halaman input/edit nilai
     */
    public function editForm(Request $request)
    {
        $semester = $request->semester ?? 'Ganjil';
        $classroomId = $request->classroom_id;

        if (!$classroomId) {
            return redirect()->route('scores.index')->with('warning', 'Pilih kelas terlebih dahulu.');
        }

        $selectedClassroom = Classroom::with(['students.scores', 'subjects'])->findOrFail($classroomId);
        $students = $selectedClassroom->students;
        $subjects = $selectedClassroom->subjects;
        $classrooms = Classroom::where('semester', $semester)->get();

        return view('scores.edit', compact(
            'selectedClassroom',
            'students',
            'subjects',
            'semester',
            'classrooms'
        ));
    }

    /**
     * Simpan nilai dari input/edit
     */
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'scores' => 'array',
        ]);

        foreach ($request->scores as $studentId => $subjectScores) {
            foreach ($subjectScores as $subjectId => $scoreValue) {
                if ($scoreValue !== null && $scoreValue !== '') {
                    Score::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'classroom_id' => $request->classroom_id,
                        ],
                        ['score' => $scoreValue]
                    );
                }
            }
        }

        return redirect()->route('scores.index', [
            'semester' => $request->semester,
            'classroom_id' => $request->classroom_id
        ])->with('success', 'Nilai berhasil disimpan.');
    }
}
