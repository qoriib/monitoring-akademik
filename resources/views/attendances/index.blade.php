@extends('layouts.app')

@section('title', 'Rekap Absensi Siswa')

@section('content')
    <h4 class="mb-4">Rekap Absensi Siswa</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('attendances.index') }}" class="row mb-4">
        <div class="col-md-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select" onchange="this.form.submit()">
                <option value="Ganjil" {{ ($semester ?? '') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ ($semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="classroom_id" class="form-label">Pilih Kelas</label>
            <select name="classroom_id" id="classroom_id" class="form-select" onchange="this.form.submit()" {{ $semester ? '' : 'disabled' }}>
                <option value="">-- Pilih --</option>
                @foreach($classrooms as $classroom)
                    @if ($classroom->semester == $semester)
                        <option value="{{ $classroom->id }}" {{ request('classroom_id', $selectedClassroom?->id) == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }} ({{ $classroom->academic_year }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="month" class="form-label">Bulan</label>
            <input type="month" name="month" id="month" class="form-control"
                   value="{{ request('month') ?? $month }}" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    {{-- Tabel Rekap --}}
    @if ($selectedClassroom && $month)
        @php
            $daysInMonth = \Carbon\Carbon::parse($month)->daysInMonth;
            $yearMonth = \Carbon\Carbon::parse($month)->format('Y-m');
            $statusMap = [
                'Hadir' => ['H', 'bg-success text-white'],
                'Sakit' => ['S', 'bg-warning text-dark'],
                'Izin'  => ['I', 'bg-info text-dark'],
                'Alfa'  => ['A', 'bg-danger text-white'],
            ];
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered table-sm text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="text-start" style="min-width: 15rem">Nama Siswa</th>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            <th style="min-width: 3rem;">{{ $day }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="text-start">{{ $student->name }}</td>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = $yearMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $attendance = $student->attendances->firstWhere('date', $date);
                                    [$abbr, $color] = $statusMap[$attendance->status ?? ''] ?? ['-', ''];
                                @endphp
                                <td class="{{ $color }}">{{ $abbr }}</td>
                            @endfor
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $daysInMonth + 1 }}" class="text-center text-muted">
                                Tidak ada data siswa pada kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('attendances.edit-form', [
            'semester' => $semester,
            'classroom_id' => $selectedClassroom->id,
            'month' => $month
        ]) }}" class="btn btn-warning mt-3">
            Edit Absensi
        </a>
    @endif
@endsection