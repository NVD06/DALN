@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">
        <div class="card-body text-center">
            <h2 class="text-primary fw-bold mb-3">💳 Thanh toán khóa học</h2>
            <h4 class="text-secondary mb-3">{{ $course->title }}</h4>
            <h3 class="text-danger fw-bold">{{ number_format($course->price, 0, ',', '.') }} VNĐ</h3>

            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('courses.processPayment', $course->id) }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-success btn-lg w-100">💰 Thanh toán ngay</button>
            </form>

            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary mt-3 w-100">🔙 Quay lại</a>
        </div>
    </div>
</div>
@endsection
