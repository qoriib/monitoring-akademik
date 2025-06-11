@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="container">
    <h4>Edit Absensi Siswa</h4>
    <form method="POST" action="{{ route('attendances.update', $attendance) }}">
        @csrf
        @method('PUT')
        @include('attendances._form', ['submit' => 'Perbarui'])
    </form>
</div>
@endsection