@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
    <h4 class="mb-4">Sesuaikan Kelas: {{ $classroom->name }}</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- === Form Kelas === --}}
    <form method="POST" action="{{ route('classrooms.update', $classroom) }}" class="mb-5">
        @csrf @method('PUT')
        @include('classrooms._form', ['submit' => 'Perbarui Kelas'])
    </form>

    <div class="row">
        {{-- === Form Siswa === --}}
        <div class="col-md-6 mb-4">
            <h5>Kelola Siswa</h5>
            <form method="POST" action="{{ route('classrooms.students.update', $classroom) }}">
                @csrf

                <input type="text" id="studentSearch" class="form-control mb-2" placeholder="Cari siswa...">

                <div class="border rounded p-2" style="max-height: 300px; overflow-y: auto;">
                    @foreach ($students as $student)
                        <div class="form-check student-item">
                            <input class="form-check-input" type="checkbox"
                                   name="student_ids[]" value="{{ $student->id }}"
                                   id="student{{ $student->id }}"
                                   {{ $classroom->students->contains($student->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="student{{ $student->id }}">
                                {{ $student->name }} ({{ $student->nisn }})
                            </label>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-primary btn-sm mt-3">Simpan Siswa</button>
            </form>
        </div>

        {{-- === Form Mata Pelajaran === --}}
        <div class="col-md-6 mb-4">
            <h5>Kelola Mata Pelajaran</h5>
            <form method="POST" action="{{ route('classrooms.subjects.update', $classroom) }}">
                @csrf

                <input type="text" id="subjectSearch" class="form-control mb-2" placeholder="Cari mata pelajaran...">

                <div class="border rounded p-2" style="max-height: 300px; overflow-y: auto;">
                    @foreach ($subjects as $subject)
                        <div class="form-check subject-item">
                            <input class="form-check-input" type="checkbox"
                                   name="subject_ids[]" value="{{ $subject->id }}"
                                   id="subject{{ $subject->id }}"
                                   {{ $classroom->subjects->contains($subject->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject{{ $subject->id }}">
                                {{ $subject->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-primary btn-sm mt-3">Simpan Mapel</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Filter siswa
    document.getElementById('studentSearch').addEventListener('input', function () {
        let val = this.value.toLowerCase();
        document.querySelectorAll('.student-item').forEach(function (el) {
            el.style.display = el.textContent.toLowerCase().includes(val) ? 'block' : 'none';
        });
    });

    // Filter mapel
    document.getElementById('subjectSearch').addEventListener('input', function () {
        let val = this.value.toLowerCase();
        document.querySelectorAll('.subject-item').forEach(function (el) {
            el.style.display = el.textContent.toLowerCase().includes(val) ? 'block' : 'none';
        });
    });
</script>
@endpush
