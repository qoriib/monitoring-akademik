@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    @if($errors->has('email'))
        <div class="alert alert-danger">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.handle') }}">
        @csrf

        <div class="mb-3 text-start">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Masuk</button>
    </form>
@endsection
