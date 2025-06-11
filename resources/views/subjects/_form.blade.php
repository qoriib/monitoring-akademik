@csrf

<div class="mb-3">
    <label class="form-label">Nama Mata Pelajaran</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name ?? '') }}" required>
</div>

<button type="submit" class="btn btn-success">{{ $submit ?? 'Simpan' }}</button>
<a href="{{ route('subjects.index') }}" class="btn btn-secondary">Kembali</a>