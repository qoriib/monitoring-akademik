@csrf

<div class="mb-3">
    <label class="form-label">NISN</label>
    <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $student->nisn ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $student->name ?? '') }}" required>
</div>

<button class="btn btn-success">{{ $submit ?? 'Simpan' }}</button>
<a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>