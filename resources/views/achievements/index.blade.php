@extends('layouts.app')

@section('title', 'Prestasi Siswa')

@section('content')
    <div class="hstack justify-content-between gap-3 mb-4">
        <h4 class="mb-0">Daftar Prestasi Siswa</h4>
        <a href="{{ route('achievements.create') }}" class="btn btn-success">Tambah</a>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('achievements.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-select" onchange="this.form.submit()">
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kelas</label>
            <select name="classroom_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" 
                        {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }} ({{ $classroom->academic_year }})
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nama Siswa</th>
                    <th>Judul Prestasi</th>
                    <th>Tingkat</th>
                    <th>Tanggal</th>
                    <th style="width: 8rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($achievements as $achievement)
                <tr>
                    <td>{{ $achievement->student->name }}</td>
                    <td>{{ $achievement->title }}</td>
                    <td>{{ $achievement->level }}</td>
                    <td class="font-monospace text-center">{{ $achievement->date }}</td>
                    <td>
                        <a href="{{ route('achievements.edit', $achievement) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('achievements.destroy', $achievement) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data prestasi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $achievements->withQueryString()->links() }}
@endsection