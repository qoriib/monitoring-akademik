@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
    <h4 class="mb-4">Tambah Siswa</h4>
    <form method="POST" action="{{ route('students.store') }}">
        @include('students._form', ['submit' => 'Simpan'])
    </form>
@endsection