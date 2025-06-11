@extends('layouts.app')

@section('title', 'Prestasi Siswa')

@section('content')
    <div class="hstack justify-content-between gap-3 mb-4">
        <h4 class="mb-0">Daftar Prestasi Siswa</h4>
        <a href="{{ route('achievements.create') }}" class="btn btn-success">Tambah</a>
    </div>

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
                <tr><td colspan="5" class="text-center">Belum ada data prestasi</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $achievements->links() }}
@endsection