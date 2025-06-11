@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container">
    <h4>Tambah Kelas</h4>
    <form method="POST" action="{{ route('classrooms.store') }}">
        @include('classrooms._form', ['submit' => 'Simpan'])
    </form>
</div>
@endsection
