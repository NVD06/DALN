@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h1 class="text-primary fw-bold">{{ $course->title }}</h1>
            <h5 class="text-muted">👨‍🏫 Giảng viên: <strong>{{ $course->mentor ? $course->mentor->name : 'Không xác định' }}</strong></h5>

            {{-- Ảnh khóa học --}}
            {{-- <div class="text-center my-3">
                <img src="{{ asset('images/course-placeholder.jpg') }}" class="img-fluid rounded-3 shadow-sm" width="400">
            </div> --}}

            {{-- Thông tin khóa học --}}
            <p class="mt-3"><strong>📖 Mô tả:</strong> {{ $course->description }}</p>
            <p><strong>📚 Số chương:</strong> {{ $course->modules->count() }}</p>
            <p class="text-danger fw-bold fs-4">💰 Giá: {{ number_format($course->price, 0, ',', '.') }} VNĐ</p>

            {{-- Kiểm tra xem người dùng đã đăng ký chưa --}}
            @if($course->isRegistered(Auth::id()))
                <div class="alert alert-info text-center">
                    <h5>📊 Tiến trình: {{ $course->getProgress(Auth::id()) }}%</h5>
                    <a href="{{ route('courses.learn', $course->id) }}" class="btn btn-success btn-lg fw-bold">🎓 Vào học ngay</a>
                </div>
            @else
                <div class="text-center">
                    <a href="{{ route('courses.register', $course->id) }}" class="btn btn-warning btn-lg fw-bold">📌 Đăng ký ngay</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Đánh giá khóa học --}}
    <div class="mt-5">
        <h3 class="text-primary fw-bold text-center">⭐ Đánh giá khóa học</h3>
        @if($course->reviews->count() > 0)
            <div class="card shadow-sm p-3 border-0 rounded-3 mt-3">
                <div class="card-body">
                    <h4 class="text-center text-warning">⭐ Trung bình: {{ number_format($course->reviews->avg('rating'), 1) }}/5</h4>
                    <ul class="list-group mt-3">
                        @foreach($course->reviews as $review)
                            <li class="list-group-item bg-light rounded-3 shadow-sm mb-2 p-3">
                                <strong class="text-primary">{{ $review->user->name }}</strong> 
                                - <span class="text-warning">{{ str_repeat('⭐', $review->rating) }}</span>
                                <p class="mb-1 text-dark">{{ $review->comment }}</p>
                                <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <p class="text-muted text-center mt-3">📢 Chưa có đánh giá nào.</p>
        @endif
    </div>

    {{-- Nút quay lại --}}
    <div class="text-center mt-4">
        <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-lg fw-bold">⬅ Quay lại</a>
    </div>
</div>
@endsection
