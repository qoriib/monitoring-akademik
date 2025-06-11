<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::latest()->paginate(10);
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'academic_year' => 'required',
        ]);

        $classroom = Classroom::create($request->all());

        return redirect()->route('classrooms.edit', $classroom->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('classrooms.edit', compact('classroom', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required',
            'academic_year' => 'required',
        ]);

        $classroom->update($request->all());

        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function updateStudents(Request $request, Classroom $classroom)
    {
        $classroom->students()->sync($request->student_ids ?? []);
        return redirect()->route('classrooms.edit', $classroom)->with('success', 'Siswa berhasil diperbarui.');
    }

    public function updateSubjects(Request $request, Classroom $classroom)
    {
        $classroom->subjects()->sync($request->subject_ids ?? []);
        return redirect()->route('classrooms.edit', $classroom)->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
