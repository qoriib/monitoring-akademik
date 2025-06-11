@extends('layouts.app')

@section('title', 'Prestasi Siswa')

@section('content')
<div class="container">
    <h4>Daftar Prestasi Siswa</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('achievements.create') }}" class="btn btn-primary mb-3">+ Tambah Prestasi</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Siswa</th>
                <th>Judul Prestasi</th>
                <th>Tingkat</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($achievements as $achievement)
            <tr>
                <td>{{ $achievement->student->name }}</td>
                <td>{{ $achievement->title }}</td>
                <td>{{ $achievement->level }}</td>
                <td>{{ $achievement->date }}</td>
                <td>
                    <a href="{{ route('achievements.edit', $achievement) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('achievements.destroy', $achievement) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Belum ada data prestasi</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $achievements->links() }}
</div>
@endsection