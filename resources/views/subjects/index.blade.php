@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
    <div class="hstack justify-content-between gap-3 mb-4">
        <h4 class="mb-0">Daftar Mata Pelajaran</h4>
        <a href="{{ route('subjects.create') }}" class="btn btn-success">Tambah</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th style="min-width: 15rem">Nama Mata Pelajaran</th>
                    <th style="width: 8rem">Aksi</th>
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
    </div>

    {{ $subjects->links() }}
@endsection