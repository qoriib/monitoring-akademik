@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="container">
    <h4>Data Absensi Siswa</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('attendances.create') }}" class="btn btn-primary mb-3">+ Tambah Absensi</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->student->name }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->status }}</td>
                <td>
                    <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Belum ada data absensi</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $attendances->links() }}
</div>
@endsection