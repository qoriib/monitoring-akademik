@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="container">
    <h4>Tambah Mata Pelajaran</h4>
    <form method="POST" action="{{ route('subjects.store') }}">
        @include('subjects._form', ['submit' => 'Simpan'])
    </form>
</div>
@endsection