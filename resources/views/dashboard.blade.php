@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h4 class="mb-3">Dashboard Akademik</h4>

    {{-- Statistik Umum --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <p class="display-6 mb-0">{{ $studentCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <p class="display-6 mb-0">{{ $classroomCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Mapel</h5>
                    <p class="display-6 mb-0">{{ $subjectCount }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Siswa dengan Nilai Tertinggi --}}
    <div class="mb-4">
        <h5 class="mb-3">Siswa dengan Nilai Tertinggi (Rata-rata)</h5>
        @if ($averageScores->isEmpty())
            <p class="text-muted">Belum ada data nilai yang tersedia.</p>
        @else
            <ul class="list-group">
                @foreach ($averageScores as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item->student->name }}</span>
                        <span><strong>{{ number_format($item->avg_score, 2) }}</strong></span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Siswa dengan Absensi Terbaik --}}
    <div class="mb-4">
        <h5 class="mb-3">Siswa dengan Kehadiran Terbanyak</h5>
        @if ($topAttendance->isEmpty())
            <p class="text-muted">Belum ada data absensi yang tersedia.</p>
        @else
            <ul class="list-group">
                @foreach ($topAttendance as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item->student->name ?? 'N/A' }}</span>
                        <span><strong>{{ $item->hadir_count }} Hari</strong></span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Siswa Berprestasi --}}
    <div class="mb-4">
        <h5 class="mb-3">Siswa dengan Prestasi Terbanyak</h5>
        @if ($topAchievements->isEmpty())
            <p class="text-muted">Belum ada data prestasi yang tersedia.</p>
        @else
            <ul class="list-group">
                @foreach ($topAchievements as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item->student->name ?? 'N/A' }}</span>
                        <span><strong>{{ $item->count }} Prestasi</strong></span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection