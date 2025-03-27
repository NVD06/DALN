@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Welcome Section -->
    <div class="welcome-section text-center py-5 bg-light rounded mb-4">
        <h1 class="display-4">Chào mentor, {{ Auth::user()->name }} 👋</h1>
        <p class="lead">Quản lý khóa học của bạn một cách dễ dàng và hiệu quả.</p>
    </div>

    <!-- Course Management Section -->
    <div class="course-management">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Khóa học của bạn</h2>
            <a href="{{ route('mentor.create') }}" class="btn btn-success btn-lg">➕ Tạo khóa học</a>
        </div>

        @if($courses->isEmpty())
            <div class="alert alert-info text-center py-4">
                <p class="mb-0">Bạn chưa có khóa học nào. Hãy tạo khóa học mới!</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Giá</th>
                            <th scope="col" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td class="fw-bold align-middle">{{ $course->title }}</td>
                            <td class="align-middle">{{ Str::limit($course->description, 50) }}</td>
                            <td class="text-success fw-bold align-middle">{{ number_format($course->price) }} VND</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('mentor.show', $course->id) }}" class="btn btn-primary btn-sm">👀 Xem</a>
                                    <a href="{{ route('mentor.edit', $course->id) }}" class="btn btn-warning btn-sm">✏️ Sửa</a>
                                    <form action="{{ route('mentor.destroy', $course->id) }}" method="post" style="display:inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">🗑️ Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
    .welcome-section {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: white;
        padding: 2rem;
        border-radius: 10px;
    }

    .welcome-section h1 {
        font-weight: 700;
    }

    .welcome-section p {
        font-size: 1.25rem;
    }

    .course-management {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .gap-2 {
        gap: 0.5rem;
    }
</style>

@endsection