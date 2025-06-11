@csrf

<div class="mb-3">
    <label class="form-label">Siswa</label>
    <select name="student_id" class="form-select" required>
        <option value="">-- Pilih Siswa --</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}" @selected(old('student_id', $achievement->student_id ?? '') == $student->id)>
                {{ $student->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Judul Prestasi</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $achievement->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $achievement->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Tingkat</label>
    <select name="level" class="form-select" required>
        @foreach (['Lokal', 'Kota', 'Provinsi', 'Nasional'] as $level)
            <option value="{{ $level }}" @selected(old('level', $achievement->level ?? '') == $level)>
                {{ $level }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', $achievement->date ?? '') }}" required>
</div>

<button type="submit" class="btn btn-success">{{ $submit ?? 'Simpan' }}</button>
<a href="{{ route('achievements.index') }}" class="btn btn-secondary">Kembali</a>