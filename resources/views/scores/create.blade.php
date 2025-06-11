@extends('layouts.app')

@section('title', 'Tambah Nilai')

@section('content')
<div class="container">
    <h4>Tambah Nilai Siswa</h4>
    <form method="POST" action="{{ route('scores.store') }}">
        @include('scores._form', ['submit' => 'Simpan'])
    </form>
</div>
@endsection