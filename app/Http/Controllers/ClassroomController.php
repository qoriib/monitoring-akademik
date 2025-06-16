<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::latest()->paginate(10);
        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'academic_year' => 'required',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $classroom = Classroom::create($request->all());

        return redirect()->route('classrooms.edit', $classroom->id);
    }

    public function edit(Classroom $classroom)
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('classrooms.edit', compact('classroom', 'students', 'subjects'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required',
            'academic_year' => 'required',
            'semester' => 'required|in:Ganjil,Genap',
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

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route('classrooms.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
