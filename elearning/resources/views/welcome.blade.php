@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Tiêu đề chào mừng --}}
        <h1 class="text-primary text-center mb-4">Chào mừng {{ Auth::check() ? Auth::user()->name : 'bạn' }} đến với
            <span class="text-warning">E-Learning</span></h1>
        <p class="lead text-center text-info">Học tập mọi lúc, mọi nơi với hàng ngàn khóa học chất lượng!</p>

        {{-- Thanh tìm kiếm --}}
        <form method="GET" action="{{ route('courses.index') }}" class="my-4 d-flex justify-content-center">
            <input type="text" name="search" class="form-control w-50 me-2 border-primary shadow-sm" placeholder="Tìm kiếm khóa học..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        {{-- Tiêu đề danh sách khóa học --}}
        <h2 class="text-secondary text-center mb-4">📚 <span class="text-success">Danh sách khóa học</span></h2>

        {{-- Hiển thị danh sách khóa học dưới dạng card --}}
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/250?random={{ $loop->index }}" class="card-img-top" alt="Course Image">
                        <div class="card-body d-flex flex-column bg-light p-4">
                            <h5 class="card-title text-primary mb-2">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-decoration-none fw-bold">
                                    {{ $course->title }}
                                </a>
                            </h5>
                            <p class="card-text text-warning mb-3">⭐ {{ number_format(optional($course->reviews)->avg('rating'), 1, '.', ',') }}/5</p>
                            {{-- <div class="position-absolute top-0 start-0 bg-danger text-white px-3 py-1 fw-bold rounded-bottom-end">
                                Mới
                            </div> --}}
                            <div class="mt-auto text-center">
                                @if (Auth::check() && $course->isRegistered(Auth::id()))
                                    <button class="btn btn-outline-secondary w-100" disabled>Đã đăng ký</button>
                                @else
                                    <a href="{{ Auth::check() ? route('courses.register', $course->id) : route('login') }}"
                                        class="btn btn-gradient w-100 fw-bold text-white">
                                        Đăng ký ngay
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .btn-gradient {
        background: linear-gradient(45deg, #556fc5, #f06595);
        border: none;
        transition: 0.3s;
    }
    .btn-gradient:hover {
        background: linear-gradient(45deg, #f06595, #40bfb0);
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
</style>
