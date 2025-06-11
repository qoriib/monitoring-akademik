@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="container">
    <h4>Edit Siswa</h4>
    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        @include('students._form', ['submit' => 'Perbarui'])
    </form>
</div>
@endsection