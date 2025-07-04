<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Halaman rekap absensi bulanan.
     */
    public function index(Request $request)
    {
        $semester = $request->semester ?? 'Ganjil';
        $month = $request->month ?? now()->format('Y-m');

        $classrooms = Classroom::where('semester', $semester)
            ->with('students.attendances')->orderBy('name')->get();

        $classroomId = $request->classroom_id ?? $classrooms->first()?->id;

        $selectedClassroom = $classrooms->firstWhere('id', $classroomId);
        $students = $selectedClassroom?->students ?? [];

        return view('attendances.index', compact(
            'classrooms',
            'selectedClassroom',
            'students',
            'semester',
            'month'
        ));
    }

    /**
     * Halaman input atau edit absensi bulanan.
     */
    public function editForm(Request $request)
    {
        $semester = $request->semester ?? 'Ganjil';
        $month = $request->month ?? now()->format('Y-m');

        $classrooms = Classroom::where('semester', $semester)
            ->with('students.attendances')->orderBy('name')->get();

        $classroomId = $request->classroom_id ?? $classrooms->first()?->id;

        $selectedClassroom = $classrooms->firstWhere('id', $classroomId);
        $students = $selectedClassroom?->students ?? [];

        return view('attendances.edit', compact(
            'classrooms',
            'selectedClassroom',
            'students',
            'semester',
            'month'
        ));
    }

    /**
     * Simpan absensi bulanan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'month' => 'required|date_format:Y-m',
            'attendances' => 'required|array',
        ]);

        foreach ($request->attendances as $studentId => $dates) {
            foreach ($dates as $date => $status) {
                if (!empty($status)) {
                    Attendance::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'date' => $date,
                        ],
                        [
                            'status' => $status,
                        ]
                    );
                }
            }
        }

        // Ambil semester dari kelas (agar tetap konsisten setelah submit)
        $semester = Classroom::find($request->classroom_id)?->semester ?? 'Ganjil';

        return redirect()->route('attendances.edit-form', [
            'semester' => $semester,
            'classroom_id' => $request->classroom_id,
            'month' => $request->month,
        ])->with('success', 'Absensi berhasil disimpan.');
    }
}
