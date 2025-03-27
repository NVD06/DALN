@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Tiêu đề chào mừng --}}
        <h1 class="text-primary text-center mb-4">Chào mừng {{ Auth::check() ? Auth::user()->name : 'bạn' }} đến với
            E-Learning</h1>
        <p class="lead text-center">Học tập mọi lúc, mọi nơi với hàng ngàn khóa học chất lượng!</p>

        {{-- Thanh tìm kiếm --}}
        <form method="GET" action="{{ route('courses.index') }}" class="my-4 d-flex justify-content-center">
            <input type="text" name="search" class="form-control w-50 me-2" placeholder="Tìm kiếm khóa học..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        {{-- Tiêu đề danh sách khóa học --}}
        <h2 class="text-secondary text-center mb-4">📚 Danh sách khóa học</h2>

        {{-- Hiển thị danh sách khóa học --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Khóa học</th>
                        {{-- <th>Số module</th>
                    <th>Trạng thái</th> --}}
                        <th>Đánh giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>
                                <a href="{{ route('courses.show', $course->id) }}"
                                    class="text-decoration-none fw-bold">{{ $course->title }}</a>
                            </td>
                            {{-- <td>{{ $course->modules_count }}</td> --}}
                            {{-- <td>
                        @if (Auth::check() && $course->isRegistered(Auth::id()))
                            <span class="badge bg-success">{{ $course->getProgress(Auth::id()) }}%</span>
                        @else
                            <span class="badge bg-secondary">Chưa đăng ký</span>
                        @endif
                    </td> --}}
                            <td>
                                ⭐ {{ number_format(optional($course->reviews)->avg('rating'), 1, '.', ',') }}/5
                            </td>
                            <td>
                                @if (Auth::check() && $course->isRegistered(Auth::id()))
                                    <button class="btn btn-outline-secondary" disabled>Đã đăng ký</button>
                                @else
                                    <a href="{{ Auth::check() ? route('courses.register', $course->id) : route('login') }}"
                                        class="btn btn-success">
                                        Đăng ký
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
