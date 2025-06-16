<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Achievement::with('student', 'classroom');

        // Filter data prestasi berdasarkan semester
        if ($request->filled('semester')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $achievements = $query->latest()->paginate(10);

        // Filter daftar kelas yang ditampilkan di dropdown berdasarkan semester juga
        $classroomsQuery = Classroom::orderBy('name');

        if ($request->filled('semester')) {
            $classroomsQuery->where('semester', $request->semester);
        }

        $classrooms = $classroomsQuery->get();

        return view('achievements.index', [
            'achievements' => $achievements,
            'classrooms' => $classrooms,
            'semester' => $request->semester,
            'classroom_id' => $request->classroom_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $classrooms = Classroom::all();
        return view('achievements.create', compact('students', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string',
            'date' => 'required|date',
        ]);

        Achievement::create($request->all());

        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        $students = Student::all();
        $classrooms = Classroom::all();
        return view('achievements.edit', compact('achievement', 'students', 'classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string',
            'date' => 'required|date',
        ]);

        $achievement->update($request->all());

        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
