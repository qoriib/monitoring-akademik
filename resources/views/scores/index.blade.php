@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
    <h4 class="mb-4">Nilai Siswa</h4>

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
    </form>

    @if($selectedClassroom)
        <form method="POST" action="{{ route('scores.store') }}">
            @csrf
            <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
            <input type="hidden" name="semester" value="{{ $semester }}">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="min-width: 15rem">Siswa</th>
                            @foreach ($subjects as $subject)
                                <th style="width: 10rem">{{ $subject->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                @foreach ($subjects as $subject)
                                    @php
                                        $existing = $student->scores
                                            ->where('subject_id', $subject->id)
                                            ->where('classroom_id', $selectedClassroom->id)
                                            ->first();
                                    @endphp
                                    <td>
                                        <input type="number" step="0.01" min="0" max="100"
                                            name="scores[{{ $student->id }}][{{ $subject->id }}]"
                                            class="form-control text-center"
                                            value="{{ $existing->score ?? '' }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button class="btn btn-primary mt-2">Simpan Nilai</button>
        </form>
    @elseif($semester)
        <div class="alert alert-warning">Silakan pilih kelas untuk semester <strong>{{ $semester }}</strong>.</div>
    @endif
@endsection