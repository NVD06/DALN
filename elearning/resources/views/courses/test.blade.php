@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Hiển thị thông báo -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tiêu đề bài kiểm tra -->
    <div class="text-center mb-4">
        <h2 class="text-primary fw-bold">📝 {{ $test->title }}</h2>
        <p class="text-muted">Khóa học: <strong>{{ $test->course->title }}</strong></p>
    </div>

    @if($test->questions->isEmpty())
        <div class="alert alert-warning text-center">⚠️ Chưa có câu hỏi nào.</div>
    @else
        <div class="card shadow-sm p-4">
            <form action="{{ route('courses.test.submit', ['course' => $test->course->id, 'test' => $test->id]) }}" method="POST">
                @csrf

                @foreach($test->questions as $index => $question)
                    <div class="mb-4">
                        <h5 class="fw-bold">❓ Câu {{ $index + 1 }}: {{ $question->question }}</h5>

                        @if($question->answers->isEmpty())
                            <p class="text-danger">⚠️ Chưa có câu trả lời.</p>
                        @else
                            <div class="list-group">
                                @foreach($question->answers as $answer)
                                    <label class="list-group-item d-flex align-items-center">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="form-check-input me-2" required>
                                        {{ $answer->answer }}
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Nút submit -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-lg btn-success">📤 Nộp bài</button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection