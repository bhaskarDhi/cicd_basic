@extends('layout')

@section('title', 'Log in')

@section('content')
<div class="card">
    <h1>Log in</h1>
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>

        <p><button type="submit">Log in</button></p>
        <p class="muted">Demo user: admin@example.com / password</p>
    </form>
</div>
@endsection
