@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-4">
                    <h3 class="text-center mb-0"><i class="fas fa-sign-in-alt me-2"></i>{{ __('Đăng nhập') }}</h3>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label text-muted">{{ __('Địa chỉ Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input id="email" type="email" 
                                    class="form-control rounded-end @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="Nhập địa chỉ email"
                                    required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label text-muted">{{ __('Mật khẩu') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input id="password" type="password" 
                                    class="form-control rounded-end @error('password') is-invalid @enderror" 
                                    name="password" 
                                    placeholder="Nhập mật khẩu"
                                    required autocomplete="current-password">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Ghi nhớ đăng nhập') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none text-primary" href="{{ route('password.request') }}">
                                    {{ __('Quên mật khẩu?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-2 fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Đăng nhập') }}
                            </button>
                        </div>

                        <!-- Registration Link -->
                        <div class="text-center text-muted">
                            {{ __('Chưa có tài khoản?') }}
                            <a class="text-decoration-none text-primary fw-bold" href="{{ route('register') }}">
                                {{ __('Đăng ký ngay') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.min-vh-100 {
    min-height: 100vh;
}

.card {
    border: none;
    overflow: hidden;
}

.rounded-4 {
    border-radius: 1rem !important;
}

.rounded-top-4 {
    border-top-left-radius: 1rem !important;
    border-top-right-radius: 1rem !important;
}

.card-header {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    border-bottom: none;
}

.input-group-text {
    transition: border-color 0.3s ease;
}

.form-control {
    border-left: none !important;
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: none !important;
    border-color: #6a11cb !important;
}

.btn-primary {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    border: none;
    transition: transform 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
}

.text-primary {
    color: #6a11cb !important;
}
</style>