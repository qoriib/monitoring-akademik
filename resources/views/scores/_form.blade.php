@csrf

<div class="mb-3">
    <label class="form-label">Nama Siswa</label>
    <select name="student_id" class="form-select" required>
        <option value="">-- Pilih Siswa --</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}" @selected(old('student_id', $score->student_id ?? '') == $student->id)>
                {{ $student->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Mata Pelajaran</label>
    <select name="subject_id" class="form-select" required>
        <option value="">-- Pilih Mata Pelajaran --</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}" @selected(old('subject_id', $score->subject_id ?? '') == $subject->id)>
                {{ $subject->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Semester</label>
    <input type="text" name="semester" class="form-control" value="{{ old('semester', $score->semester ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Nilai</label>
    <input type="number" name="score" class="form-control" min="0" max="100" value="{{ old('score', $score->score ?? '') }}" required>
</div>

<button type="submit" class="btn btn-success">{{ $submit ?? 'Simpan' }}</button>
<a href="{{ route('scores.index') }}" class="btn btn-secondary">Batal</a>