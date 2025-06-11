@extends('layouts.app')

@section('title', 'Data Nilai')

@section('content')
<div class="container">
    <h4>Data Nilai Siswa</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('scores.create') }}" class="btn btn-primary mb-3">+ Tambah Nilai</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Siswa</th>
                <th>Mata Pelajaran</th>
                <th>Semester</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($scores as $score)
            <tr>
                <td>{{ $score->student->name }}</td>
                <td>{{ $score->subject->name }}</td>
                <td>{{ $score->semester }}</td>
                <td>{{ $score->score }}</td>
                <td>
                    <a href="{{ route('scores.edit', $score) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('scores.destroy', $score) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Belum ada data nilai</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $scores->links() }}
</div>
@endsection