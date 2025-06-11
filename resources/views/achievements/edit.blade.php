@extends('layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
    <h4 class="mb-4">Edit Prestasi Siswa</h4>
    <form method="POST" action="{{ route('achievements.update', $achievement) }}">
        @csrf
        @method('PUT')
        @include('achievements._form', ['submit' => 'Perbarui'])
    </form>
@endsection