@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
    <h4 class="mb-4">Tambah Mata Pelajaran</h4>
    <form method="POST" action="{{ route('subjects.store') }}">
        @include('subjects._form', ['submit' => 'Simpan'])
    </form>
@endsection