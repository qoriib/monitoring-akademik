@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="container">
    <h4>Edit Kelas</h4>
    <form method="POST" action="{{ route('classrooms.update', $classroom) }}">
        @csrf
        @method('PUT')
        @include('classrooms._form', ['submit' => 'Perbarui'])
    </form>
</div>
@endsection
