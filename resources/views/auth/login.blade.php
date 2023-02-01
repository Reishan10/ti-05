@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
    <!-- title-->
    <h4 class="mt-0">Masuk</h4>
    <p class="text-muted mb-4">Masukkan alamat email dan kata sandi anda!.</p>

    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                name="email"placeholder="Masukan email anda" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Lupa Password?</small></a>
            @endif

            <label for="password" class="form-label">Password</label>
            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password"
                name="password" placeholder="Masukan password anda">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
        </div>
        <div class="d-grid mb-0 text-center">
            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Masuk
            </button>
        </div>
    </form>
@endsection
