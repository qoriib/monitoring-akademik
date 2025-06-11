@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Siswa</h5>
                    <p class="display-6">{{ $studentCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Mata Pelajaran</h5>
                    <p class="display-6">{{ $subjectCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Nilai</h5>
                    <p class="display-6">{{ $scoreCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Prestasi Siswa</h5>
                    <p class="display-6">{{ $achievementCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection