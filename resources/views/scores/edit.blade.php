@extends('layouts.app')

@section('title', 'Edit Nilai')

@section('content')
<div class="container">
    <h4>Edit Nilai Siswa</h4>
    <form method="POST" action="{{ route('scores.update', $score) }}">
        @csrf
        @method('PUT')
        @include('scores._form', ['submit' => 'Perbarui'])
    </form>
</div>
@endsection