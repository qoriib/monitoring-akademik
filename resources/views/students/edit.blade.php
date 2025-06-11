@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
    <h4 class="mb-4">Edit Siswa</h4>
    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        @include('students._form', ['submit' => 'Perbarui'])
    </form>
@endsection