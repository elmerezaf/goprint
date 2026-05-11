@extends('layouts.app')

@section('title', '用戶登入')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-4">用戶登入</h2>

            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">電子郵箱</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">記住我</label>
                </div>

                <div class="d-flex justify-end gap-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none">忘記密碼？</a>
                    @endif
                    <button type="submit" class="btn btn-primary">登入</button>
                </div>
            </form>

            <p class="text-center mt-4">
                還沒有帳戶？ <a href="{{ route('register') }}">立即註冊</a>
            </p>
        </div>
    </div>
</div>
@endsection
