@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<div class="container">
    <h4>Edit Mata Pelajaran</h4>
    <form method="POST" action="{{ route('subjects.update', $subject) }}">
        @csrf
        @method('PUT')
        @include('subjects._form', ['submit' => 'Perbarui'])
    </form>
</div>
@endsection