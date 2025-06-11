@csrf

<div class="mb-3">
    <label class="form-label">Nama Siswa</label>
    <select name="student_id" class="form-select" required>
        <option value="">-- Pilih Siswa --</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}" @selected(old('student_id', $attendance->student_id ?? '') == $student->id)>
                {{ $student->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', $attendance->date ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Status Kehadiran</label>
    <select name="status" class="form-select" required>
        @foreach (['Hadir', 'Izin', 'Sakit', 'Alfa'] as $status)
            <option value="{{ $status }}" @selected(old('status', $attendance->status ?? '') == $status)>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-success">{{ $submit ?? 'Simpan' }}</button>
<a href="{{ route('attendances.index') }}" class="btn btn-secondary">Kembali</a>