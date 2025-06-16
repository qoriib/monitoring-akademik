@csrf

<div class="mb-3">
    <label for="name" class="form-label">Nama Kelas</label>
    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $classroom->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="academic_year" class="form-label">Tahun Ajaran</label>
    <input type="text" id="academic_year" name="academic_year" class="form-control" value="{{ old('academic_year', $classroom->academic_year ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="semester" class="form-label">Semester</label>
    <select id="semester" name="semester" class="form-select" required>
        <option value="">-- Pilih Semester --</option>
        <option value="Ganjil" {{ old('semester', $classroom->semester ?? '') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
        <option value="Genap" {{ old('semester', $classroom->semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap</option>
    </select>
</div>

<button type="submit" class="btn btn-success">{{ $submit }}</button>
<a href="{{ route('classrooms.index') }}" class="btn btn-secondary">Kembali</a>