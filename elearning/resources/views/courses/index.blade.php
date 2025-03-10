@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Chào mừng người dùng -->
    <h1 class="text-primary text-center mb-4">Chào mừng, <strong>{{ Auth::user()->name }}</strong> 👋</h1>

    <!-- Thanh tìm kiếm -->
    <div class="d-flex justify-content-center mb-4">
        <form method="GET" action="{{ route('courses.index') }}" class="w-50 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="🔍 Tìm khóa học..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>

    <!-- Tiêu đề danh sách khóa học -->
    <h2 class="text-secondary text-center mb-4">📚 Danh sách khóa học</h2>

    <!-- Hiển thị danh sách khóa học -->
    <div class="row">
        @foreach($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <!-- Tiêu đề khóa học -->
                        <h5 class="card-title">
                            <a href="{{ route('courses.show', $course->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $course->title }}
                            </a>
                        </h5>
                        <p class="text-muted">📖 {{ $course->modules_count }} chương</p>

                        <!-- Tiến trình -->
                        @if($course->isRegistered(Auth::user()->id))
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ $course->getProgress(Auth::user()->id) }}%;" 
                                    aria-valuenow="{{ $course->getProgress(Auth::user()->id) }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $course->getProgress(Auth::user()->id) }}%
                                </div>
                            </div>
                        @else
                            <span class="badge bg-secondary">Chưa đăng ký</span>
                        @endif

                        <!-- Đánh giá -->
                        <p class="mb-1">⭐ <strong>{{ number_format($course->reviews->avg('rating'), 1) }}/5</strong></p>

                        <!-- Trạng thái khóa học -->
                        @if($course->isRegistered(Auth::user()->id))
                            @php
                                $progress = $course->getProgress(Auth::user()->id);
                                $testResult = \App\Models\TestResult::where('user_id', Auth::id())->where('course_id', $course->id)->first();
                            @endphp

                            @if($progress == 100 && !$testResult)
                                @if($course->test)
                                    <a href="{{ route('courses.test', ['course' => $course->id, 'test' => $course->test->id]) }}" class="btn btn-info w-100">📄 Làm bài kiểm tra</a>
                                @else
                                    <span class="badge bg-warning">Chưa có bài kiểm tra</span>
                                @endif

                            @elseif($testResult && !$testResult->passed)
                                <span class="badge bg-danger">Chưa đạt yêu cầu</span>
                                @if($course->test)
                                    <a href="{{ route('courses.test', ['course' => $course->id, 'test' => $course->test->id]) }}" class="btn btn-warning w-100 mt-2">🔄 Thi lại</a>
                                @endif

                            @elseif($testResult && $testResult->passed)
                                <span class="badge bg-success">✅ Đã hoàn thành</span>
                                <a href="{{ route('courses.review', $course->id) }}" class="btn btn-primary w-100 mt-2">✍️ Đánh giá khóa học</a>
                            @else
                                <a href="{{ route('courses.learn', $course->id) }}" class="btn btn-success w-100">📚 Vào học</a>
                            @endif
                        @else
                            <form action="{{ route('courses.register', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">📝 Đăng ký học</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
