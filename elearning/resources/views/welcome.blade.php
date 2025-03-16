@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Chào mừng người dùng -->
    <div class="text-center welcome-container mb-5">
        <h1 class="fw-bold">Chào mừng bạn đến với E-Learning</h1>
        <p class="lead">Học tập mọi lúc, mọi nơi với hàng ngàn khóa học chất lượng!</p>
        {{-- <div class="mt-4">
            <a href="{{ route('register') }}" class="btn btn-success btn-custom me-3">Đăng ký</a>
            <a href="{{ route('login') }}" class="btn btn-primary btn-custom">Đăng nhập</a>
        </div> --}}
    </div>

    <!-- Thanh tìm kiếm -->
    <div class="d-flex justify-content-center mb-4">
        <form method="GET" action="#" class="w-50 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="🔍 Tìm khóa học...">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <!-- Tiêu đề danh sách khóa học -->
    <h2 class="text-secondary text-center mb-4">📚 Danh sách khóa học</h2>

    <!-- Hiển thị danh sách khóa học -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-dark fw-bold">Tên khóa học mẫu</h5>
                    <p class="text-muted">📖 X chương</p>
                    <button type="button" class="btn btn-primary w-100" onclick="window.location.href='{{ route('login') }}'">
                        📝 Đăng ký học
                    </button>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection