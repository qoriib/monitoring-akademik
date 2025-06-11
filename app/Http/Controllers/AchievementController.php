<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Student;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Achievement::with('student')->latest('date')->paginate(10);
        return view('achievements.index', compact('achievements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('achievements.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
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
        return view('achievements.edit', compact('achievement', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
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
