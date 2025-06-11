@extends('layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container">
    <h4>Edit Prestasi Siswa</h4>
    <form method="POST" action="{{ route('achievements.update', $achievement) }}">
        @csrf
        @method('PUT')
        @include('achievements._form', ['submit' => 'Perbarui'])
    </form>
</div>
@endsection