@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="container">
    <h4>Daftar Kelas</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('classrooms.create') }}" class="btn btn-primary mb-3">+ Tambah Kelas</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($classrooms as $classroom)
            <tr>
                <td>{{ $classroom->name }}</td>
                <td>{{ $classroom->academic_year }}</td>
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
</div>
@endsection
