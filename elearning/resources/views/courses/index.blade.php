@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header với gradient --}}
    <div class="text-center py-5 mb-4" style="background: linear-gradient(135deg, #6a11cb, #2575fc); border-radius: 15px;">
        <h1 class="text-white display-4 fw-bold">Chào học sinh {{ Auth::user()->name }}</h1>
        <p class="text-white-50 mb-0">Hãy khám phá các khóa học của bạn!</p>
    </div>

    {{-- Thanh tìm kiếm --}}
    <form method="GET" action="{{ route('courses.index') }}" class="my-4 d-flex justify-content-center">
        <div class="input-group w-50 shadow-sm">
            <input type="text" name="search" class="form-control border-0" placeholder="Tìm kiếm khóa học..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    {{-- Tabs điều hướng --}}
    <ul class="nav nav-pills mb-4 justify-content-center" id="courseTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#allCourses">
                <i class="fas fa-book me-2"></i> Tất cả khóa học
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#ongoingCourses">
                <i class="fas fa-spinner me-2"></i> Đang học
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#completedCourses">
                <i class="fas fa-check-circle me-2"></i> Đã hoàn thành
            </a>
        </li>
    </ul>

    <div class="tab-content">
        {{-- Tất cả khóa học --}}
        <div id="allCourses" class="tab-pane fade show active">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($courses as $course)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-effect">
                        {{-- Ảnh ngẫu nhiên từ Picsum Photos --}}
                        <img src="https://picsum.photos/seed/{{ $course->id }}/400/300" class="card-img-top" alt="{{ $course->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title fw-bold">{{ $course->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                            </div>
                            {{-- <div class="progress mb-3">
                                <div class="progress-bar bg-gradient" role="progressbar" style="width: {{ $course->getProgress(Auth::id()) }}%;" aria-valuenow="{{ $course->getProgress(Auth::id()) }}" aria-valuemin="0" aria-valuemax="100">{{ $course->getProgress(Auth::id()) }}%</div>
                            </div> --}}
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-info-circle me-2"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Khóa học đang học --}}
        <div id="ongoingCourses" class="tab-pane fade">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @php
                    $ongoingCourses = $courses->filter(fn($course) => $course->isRegistered(Auth::id()) && $course->getProgress(Auth::id()) < 100);
                @endphp
                @foreach($ongoingCourses as $course)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-effect">
                        {{-- Ảnh ngẫu nhiên từ Picsum Photos --}}
                        <img src="https://picsum.photos/seed/{{ $course->id }}/400/300" class="card-img-top" alt="{{ $course->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $course->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-gradient" role="progressbar" style="width: {{ $course->getProgress(Auth::id()) }}%;" aria-valuenow="{{ $course->getProgress(Auth::id()) }}" aria-valuemin="0" aria-valuemax="100">{{ $course->getProgress(Auth::id()) }}%</div>
                            </div>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-info-circle me-2"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Khóa học đã hoàn thành --}}
        <div id="completedCourses" class="tab-pane fade">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @php
                    $completedCourses = $courses->filter(fn($course) => $course->isRegistered(Auth::id()) && $course->getProgress(Auth::id()) == 100);
                @endphp
                @foreach($completedCourses as $course)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-effect">
                        {{-- Ảnh ngẫu nhiên từ Picsum Photos --}}
                        <img src="https://picsum.photos/seed/{{ $course->id }}/400/300" class="card-img-top" alt="{{ $course->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $course->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success bg-gradient" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            </div>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    .bg-gradient {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }
    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-effect:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .nav-pills .nav-link {
        font-size: 1.1rem;
        color: #495057;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: white;
        border-radius: 50px;
    }
    .card-img-top {
        border-radius: 15px 15px 0 0;
    }
    .progress-bar {
        border-radius: 10px;
    }
</style>
@endsection