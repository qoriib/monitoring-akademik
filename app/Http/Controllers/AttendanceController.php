<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classrooms = Classroom::with('students')->get();

        $selectedClassroom = null;
        $students = [];

        if ($request->has(['classroom_id', 'date']) && $request->filled(['classroom_id', 'date'])) {
            $selectedClassroom = Classroom::with('students')->findOrFail($request->classroom_id);
            $students = $selectedClassroom->students;
        }

        return view('attendances.index', compact('classrooms', 'selectedClassroom', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
        ]);

        foreach ($request->attendances as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('attendances.index', [
            'classroom_id' => $request->classroom_id,
            'date' => $request->date,
        ])->with('success', 'Absensi berhasil disimpan.');
    }
}
