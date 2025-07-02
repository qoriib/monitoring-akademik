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
        <h5 class="mb-3">Siswa Terbaik (Keseluruhan)</h5>
        <div class="row">
            <div class="col-md-4">
                {{-- Nilai Tertinggi --}}
                <div class="mb-3">
                    <h6>Nilai Rata-rata Tertinggi</h6>
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
            </div>
            <div class="col-md-4">
                {{-- Absensi Terbanyak --}}
                <div class="mb-3">
                    <h6>Kehadiran Terbanyak</h6>
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
            </div>
            <div class="col-md-4">
                {{-- Prestasi Terbanyak --}}
                <div>
                    <h6>Prestasi Terbanyak</h6>
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

    {{-- DATA PER KELAS --}}
    <div class="mb-4">
        <h5 class="mb-3">Siswa Terbaik per Kelas</h5>

        @php
            $result = $classrooms->map(function ($classroom) {
                $topStudent = $classroom->students->map(function ($s) use ($classroom) {
                    $avg = $s->scores->where('classroom_id', $classroom->id)->avg('score');
                    return $avg ? ['student' => $s, 'avg' => $avg] : null;
                })->filter()->sortByDesc('avg')->first();

                $topAttendance = $classroom->students->map(function ($s) {
                    $hadir = $s->attendances->where('status', 'Hadir')->count();
                    return ['student' => $s, 'hadir' => $hadir];
                })->sortByDesc('hadir')->first();

                $topAchievement = $classroom->students->map(function ($s) use ($classroom) {
                    $count = $s->achievements->where('classroom_id', $classroom->id)->count();
                    return ['student' => $s, 'count' => $count];
                })->sortByDesc('count')->first();

                return [
                    'classroom' => $classroom,
                    'top_score' => $topStudent,
                    'top_attendance' => $topAttendance,
                    'top_achievement' => $topAchievement,
                ];
            });
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="min-width: 10rem">Kelas</th>
                        <th style="min-width: 15rem">Nilai Tertinggi</th>
                        <th style="min-width: 15rem">Kehadiran Terbanyak</th>
                        <th style="min-width: 15rem">Prestasi Terbanyak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($result as $row)
                        <tr>
                            <td>
                                <strong>{{ $row['classroom']->name }}</strong><br>
                                <small class="text-muted">{{ $row['classroom']->academic_year }} - {{ $row['classroom']->semester }}</small>
                            </td>
                            <td>
                                @if ($row['top_score'])
                                    {{ $row['top_score']['student']->name }}<br>
                                    <span class="text-muted">{{ number_format($row['top_score']['avg'], 2) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($row['top_attendance'])
                                    {{ $row['top_attendance']['student']->name }}<br>
                                    <span class="text-muted">{{ $row['top_attendance']['hadir'] }} Hari</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($row['top_achievement'] && $row['top_achievement']['count'] > 0)
                                    {{ $row['top_achievement']['student']->name }}<br>
                                    <span class="text-muted">{{ $row['top_achievement']['count'] }} Prestasi</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">Tidak ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection