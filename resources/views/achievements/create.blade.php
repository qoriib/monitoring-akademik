@extends('layouts.app')

@section('title', 'Tambah Prestasi')

@section('content')
    <h4 class="mb-4">Tambah Prestasi Siswa</h4>
    <form method="POST" action="{{ route('achievements.store') }}">
        @include('achievements._form', ['submit' => 'Simpan'])
    </form>
@endsection