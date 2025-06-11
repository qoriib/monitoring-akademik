@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="container">
    <h4>Tambah Siswa</h4>
    <form method="POST" action="{{ route('students.store') }}">
        @include('students._form', ['submit' => 'Simpan'])
    </form>
</div>
@endsection