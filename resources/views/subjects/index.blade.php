@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="container">
    <h4>Daftar Mata Pelajaran</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">+ Tambah Mata Pelajaran</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Mata Pelajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($subjects as $subject)
            <tr>
                <td>{{ $subject->name }}</td>
                <td>
                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="2" class="text-center">Belum ada mata pelajaran.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $subjects->links() }}
</div>
@endsection