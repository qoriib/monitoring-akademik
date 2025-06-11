@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
    <div class="hstack justify-content-between gap-3 mb-4">
        <h4 class="mb-0">Data Kelas</h4>
        <a href="{{ route('classrooms.create') }}" class="btn btn-success">Tambah</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th style="min-width: 15rem">Nama Kelas</th>
                <th>Tahun Ajaran</th>
                <th style="width: 8rem">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($classrooms as $classroom)
            <tr>
                <td>{{ $classroom->name }}</td>
                <td class="font-monospace text-center">{{ $classroom->academic_year }}</td>
                <td>
                    <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kelas ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center">Belum ada data kelas.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $classrooms->links() }}
@endsection
