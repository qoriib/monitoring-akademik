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

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Nama Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Jumlah Siswa</th>
                    <th>Jumlah Mapel</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($classrooms as $i => $classroom)
                    <tr>
                        <td class="text-center">{{ $classrooms->firstItem() + $i }}</td>
                        <td>{{ $classroom->name }}</td>
                        <td>{{ $classroom->academic_year }}</td>
                        <td>
                            @if ($classroom->semester === 'Ganjil')
                                <span class="badge bg-success">{{ $classroom->semester }}</span>
                            @elseif ($classroom->semester === 'Genap')
                                <span class="badge bg-primary">{{ $classroom->semester }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $classroom->semester }}</span>
                            @endif
                        </td>
                        <td>{{ $classroom->students->count() }}</td>
                        <td>{{ $classroom->subjects->count() }}</td>
                        <td>
                            <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $classrooms->links() }}
@endsection
