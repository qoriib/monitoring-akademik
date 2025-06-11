<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = Score::with('student', 'subject')->latest()->paginate(10);
        return view('scores.index', compact('scores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('scores.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        Score::create($request->all());

        return redirect()->route('scores.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Score $score)
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('scores.edit', compact('score', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Score $score)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $score->update($request->all());

        return redirect()->route('scores.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Score $score)
    {
        $score->delete();
        return redirect()->route('scores.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
