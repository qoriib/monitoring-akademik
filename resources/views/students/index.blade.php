@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="container">
    <h4>Data Siswa</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">+ Tambah Siswa</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->nisn }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->class }}</td>
                <td>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus siswa ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Belum ada data siswa</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $students->links() }}
</div>
@endsection