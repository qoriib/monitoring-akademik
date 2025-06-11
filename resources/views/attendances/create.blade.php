@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
<div class="container">
    <h4>Tambah Absensi Siswa</h4>
    <form method="POST" action="{{ route('attendances.store') }}">
        @include('attendances._form', ['submit' => 'Simpan'])
    </form>
</div>
@endsection