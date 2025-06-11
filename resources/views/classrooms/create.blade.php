@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
    <h4 class="mb-4">Tambah Kelas</h4>
    <form method="POST" action="{{ route('classrooms.store') }}">
        @include('classrooms._form', ['submit' => 'Simpan'])
    </form>
@endsection
