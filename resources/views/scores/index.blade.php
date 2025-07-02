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
        @php
            // Hitung rata-rata dulu dan simpan ke array baru
            $rankingData = [];

            foreach ($students as $student) {
                $total = 0;
                $count = 0;
                foreach ($subjects as $subject) {
                    $score = $student->scores->where('subject_id', $subject->id)
                        ->where('classroom_id', $selectedClassroom->id)
                        ->first();
                    if ($score) {
                        $total += $score->score;
                        $count++;
                    }
                }

                $avg = $count > 0 ? $total / $count : null;

                $rankingData[] = [
                    'student' => $student,
                    'scores' => $student->scores,
                    'average' => $avg,
                ];
            }

            // Urutkan berdasarkan rata-rata nilai
            usort($rankingData, fn($a, $b) => ($b['average'] ?? 0) <=> ($a['average'] ?? 0));
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Rank</th>
                        <th style="min-width: 15rem">Nama Siswa</th>
                        @foreach ($subjects as $subject)
                            <th style="min-width: 10rem;">{{ $subject->name }}</th>
                        @endforeach
                        <th style="min-width: 10rem;">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rankingData as $index => $data)
                        <tr>
                            <td class="text-center">{{ $data['average'] !== null ? $index + 1 : '-' }}</td>
                            <td>{{ $data['student']->name }}</td>
                            @foreach ($subjects as $subject)
                                @php
                                    $score = $data['scores']
                                        ->where('subject_id', $subject->id)
                                        ->where('classroom_id', $selectedClassroom->id)
                                        ->first();
                                    $nilai = $score?->score ?? '-';
                                @endphp
                                <td class="text-center">{{ is_numeric($nilai) ? number_format($nilai, 2) : '-' }}</td>
                            @endforeach
                            <td class="text-center fw-bold">
                                {{ $data['average'] !== null ? number_format($data['average'], 2) : '-' }}
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