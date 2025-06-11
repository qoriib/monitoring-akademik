<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::with(['students', 'subjects'])->get();

        $selectedClassroom = null;
        $students = [];
        $subjects = [];

        if ($request->has('classroom_id') && $request->classroom_id) {
            $selectedClassroom = Classroom::with(['students', 'subjects'])
                ->findOrFail($request->classroom_id);

            $students = $selectedClassroom->students;
            $subjects = $selectedClassroom->subjects;
        }

        return view('scores.index', compact('classrooms', 'selectedClassroom', 'students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
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

        return redirect()->route('scores.index', ['classroom_id' => $request->classroom_id])
            ->with('success', 'Nilai berhasil disimpan.');
    }
}
