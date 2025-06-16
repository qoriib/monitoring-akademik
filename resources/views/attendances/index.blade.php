@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
    <h4 class="mb-4">Absensi Siswa</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Pilih Semester, Kelas & Bulan --}}
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

    {{-- Tabel Absensi --}}
    @if ($selectedClassroom && $month)
        <form method="POST" action="{{ route('attendances.store') }}">
            @csrf
            <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
            <input type="hidden" name="month" value="{{ $month }}">

            @php
                $daysInMonth = \Carbon\Carbon::parse($month)->daysInMonth;
                $yearMonth = \Carbon\Carbon::parse($month)->format('Y-m');
                $statusOptions = ['Hadir', 'Sakit', 'Izin', 'Alfa'];
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="min-width: 15rem">Nama Siswa</th>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th>{{ $day }}</th>
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
                                        $existing = $student->attendances->where('date', $date)->first();
                                    @endphp
                                    <td>
                                        @php
                                            $statusClass = match($existing->status ?? null) {
                                                'Hadir' => 'bg-success text-white',
                                                'Sakit' => 'bg-warning text-dark',
                                                'Izin'  => 'bg-info text-dark',
                                                'Alfa'  => 'bg-danger text-white',
                                                default => '',
                                            };
                                        @endphp

                                        <select name="attendances[{{ $student->id }}][{{ $date }}]"
                                                class="form-control form-control-sm text-center {{ $statusClass }}"
                                                style="width: 4rem; margin: auto;">
                                            <option value="">-</option>
                                            @foreach ($statusOptions as $status)
                                                <option value="{{ $status }}" {{ $existing && $existing->status === $status ? 'selected' : '' }}>
                                                    {{ substr($status, 0, 1) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $daysInMonth + 1 }}" class="text-muted text-center">Tidak ada siswa dalam kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <button class="btn btn-success mt-3">Simpan Absensi</button>
        </form>
    @endif
@endsection