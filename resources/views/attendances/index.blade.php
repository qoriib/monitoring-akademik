@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
    <h4 class="mb-4">Absensi Siswa</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Pilih Kelas & Tanggal --}}
    <form method="GET" action="{{ route('attendances.index') }}" class="row mb-4">
        <div class="col-md-4">
            <label for="classroom_id" class="form-label">Pilih Kelas</label>
            <select name="classroom_id" id="classroom_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }} ({{ $classroom->academic_year }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    {{-- Form Absensi --}}
    @if ($selectedClassroom && request('date'))
    <form method="POST" action="{{ route('attendances.store') }}">
        @csrf
        <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
        <input type="hidden" name="date" value="{{ request('date') }}">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="min-width: 15rem">Nama Siswa</th>
                        <th style="width: 10rem">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        @php
                            $existing = $student->attendances->where('date', request('date'))->first();
                        @endphp
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <select name="attendances[{{ $student->id }}]" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach (['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $existing && $existing->status === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button class="btn btn-success">Simpan Absensi</button>
    </form>
    @endif
@endsection
