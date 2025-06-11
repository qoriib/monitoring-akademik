@extends('layouts.app')

@section('title', 'Tambah Prestasi')

@section('content')
<div class="container">
    <h4>Tambah Prestasi Siswa</h4>
    <form method="POST" action="{{ route('achievements.store') }}">
        @include('achievements._form', ['submit' => 'Simpan'])
    </form>
</div>
@endsection