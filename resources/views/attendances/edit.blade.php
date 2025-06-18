@extends('layouts.app')

@section('title', 'Input/Edit Absensi')

@section('content')
    <h4 class="mb-4">Input / Edit Absensi Bulanan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Informasi Kelas --}}
    @if ($selectedClassroom)
        <div class="mb-3">
            <strong>Kelas:</strong> {{ $selectedClassroom->name }} ({{ $selectedClassroom->academic_year }})<br>
            <strong>Semester:</strong> {{ $semester }}<br>
            <strong>Bulan:</strong> {{ \Carbon\Carbon::parse($month)->isoFormat('MMMM Y') }}
        </div>
    @endif

    {{-- Form Absensi --}}
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
                            <th class="text-start" style="min-width: 15rem">Nama Siswa</th>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th style="min-width: 5rem;">{{ $day }}</th>
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
                                        $currentStatus = $existing?->status;
                                        $statusClass = match($currentStatus) {
                                            'Hadir' => 'bg-success text-white',
                                            'Sakit' => 'bg-warning text-dark',
                                            'Izin'  => 'bg-info text-dark',
                                            'Alfa'  => 'bg-danger text-white',
                                            default => '',
                                        };
                                    @endphp
                                    <td>
                                        <select name="attendances[{{ $student->id }}][{{ $date }}]"
                                                class="form-select form-select-sm text-center {{ $statusClass }}"
                                                style="width: 4rem; margin: auto;">
                                            <option value="">-</option>
                                            @foreach ($statusOptions as $status)
                                                <option value="{{ $status }}" {{ $currentStatus === $status ? 'selected' : '' }}>
                                                    {{ substr($status, 0, 1) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $daysInMonth + 1 }}" class="text-center text-muted">
                                    Tidak ada siswa dalam kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success mt-3">Simpan Absensi</button>
            <a href="{{ route('attendances.index', [
                'semester' => $semester,
                'classroom_id' => $selectedClassroom->id,
                'month' => $month
            ]) }}" class="btn btn-secondary mt-3">Kembali ke Rekap</a>
        </form>
    @else
        <div class="alert alert-warning">Data tidak tersedia untuk ditampilkan.</div>
    @endif
@endsection