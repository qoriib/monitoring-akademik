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

    {{-- GLOBAL DATA --}}
    <div class="mb-4">
        <div class="row">
            <div class="col-12">
                {{-- Nilai Tertinggi --}}
                <div class="mb-4">
                    <h4 class="mb-3">Nilai Rata-rata Tertinggi</h4>
                    @if ($averageScores->isEmpty())
                        <p class="text-muted">Tidak ada data nilai.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($averageScores as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->student->name }}</strong><br>
                                        <small class="text-muted">{{ $item->student->classrooms->last()?->name ?? '-' }}</small>
                                    </div>
                                    <span><strong>{{ number_format($item->avg_score, 2) }}</strong></span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                {{-- Absensi Terbanyak --}}
                <div class="mb-4">
                    <h4 class="mb-3">Kehadiran Terbanyak</h4>
                    @if ($topAttendance->isEmpty())
                        <p class="text-muted">Tidak ada data absensi.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($topAttendance as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->student->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $item->student?->classrooms->last()?->name ?? '-' }}</small>
                                    </div>
                                    <span><strong>{{ $item->hadir_count }} Hari</strong></span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                {{-- Prestasi Terbanyak --}}
                <div>
                    <h4 class="mb-3">Prestasi Terbanyak</h4>
                    @if ($topAchievements->isEmpty())
                        <p class="text-muted">Tidak ada data prestasi.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($topAchievements as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->student->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $item->student?->classrooms->last()?->name ?? '-' }}</small>
                                    </div>
                                    <span><strong>{{ $item->count }} Prestasi</strong></span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection