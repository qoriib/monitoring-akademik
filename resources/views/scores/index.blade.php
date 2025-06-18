@extends('layouts.app')

@section('title', 'Rekap Nilai Siswa')

@section('content')
    <h4 class="mb-4">Rekap Nilai Siswa</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Semester dan Kelas --}}
    <form method="GET" action="{{ route('scores.index') }}" class="row mb-4">
        <div class="col-md-3">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-select" onchange="this.form.submit()">
                <option value="Ganjil" {{ ($semester ?? '') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ ($semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="form-label">Pilih Kelas</label>
            <select name="classroom_id" class="form-select" onchange="this.form.submit()" {{ empty($semester) ? 'disabled' : '' }}>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($classrooms as $classroom)
                    @if($classroom->semester === $semester)
                        <option value="{{ $classroom->id }}"
                            {{ (request('classroom_id') ?? $selectedClassroom?->id) == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }} ({{ $classroom->academic_year }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        @if($selectedClassroom)
        <div class="col-md-4 d-flex align-items-end">
            <a href="{{ route('scores.edit-form', ['classroom_id' => $selectedClassroom->id, 'semester' => $semester]) }}"
               class="btn btn-warning w-100">
                Edit / Input Nilai
            </a>
        </div>
        @endif
    </form>

    {{-- Rekap Tabel Nilai --}}
    @if($selectedClassroom && count($students) > 0 && count($subjects) > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="min-width: 15rem">Nama Siswa</th>
                        @foreach ($subjects as $subject)
                            <th style="min-width: 10rem;">{{ $subject->name }}</th>
                        @endforeach
                        <th style="min-width: 10rem;">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            @php
                                $total = 0;
                                $count = 0;
                            @endphp
                            @foreach ($subjects as $subject)
                                @php
                                    $score = $student->scores
                                        ->where('subject_id', $subject->id)
                                        ->where('classroom_id', $selectedClassroom->id)
                                        ->first();
                                    $nilai = $score?->score ?? '-';
                                    if (is_numeric($nilai)) {
                                        $total += $nilai;
                                        $count++;
                                    }
                                @endphp
                                <td class="text-center">{{ is_numeric($nilai) ? number_format($nilai, 2) : '-' }}</td>
                            @endforeach
                            <td class="text-center fw-bold">
                                {{ $count > 0 ? number_format($total / $count, 2) : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif($selectedClassroom)
        <div class="alert alert-warning">
            Belum ada data siswa atau mata pelajaran pada kelas ini.
        </div>
    @elseif($semester)
        <div class="alert alert-warning">
            Silakan pilih kelas untuk semester <strong>{{ $semester }}</strong>.
        </div>
    @endif
@endsection