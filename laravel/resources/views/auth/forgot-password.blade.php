@extends('layouts.app')

@section('title', '忘記密碼')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-4">忘記密碼</h2>

            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">電子郵箱</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-end gap-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">返回登入</a>
                    <button type="submit" class="btn btn-primary">發送重置鏈接</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
