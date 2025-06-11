@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="hstack justify-content-between gap-3 mb-4">
        <h4 class="mb-0">Data Siswa</h4>
        <a href="{{ route('students.create') }}" class="btn btn-success">Tambah Siswa</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 8rem">NISN</th>
                    <th style="width: 14rem">Nama</th>
                    <th>Kelas Diikuti</th>
                    <th style="width: 8rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($students as $student)
                <tr>
                    <td class="font-monospace">{{ $student->nisn }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        @foreach ($student->classrooms as $classroom)
                            <span class="badge bg-secondary">{{ $classroom->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $students->links() }}
@endsection
