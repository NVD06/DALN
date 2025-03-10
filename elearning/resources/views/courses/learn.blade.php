@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Tiêu đề khóa học -->
    <h1 class="text-primary text-center mb-4">📚 {{ $course->title }}</h1>

    <!-- Danh sách Chương -->
    <h2 class="text-secondary mb-4">📖 Danh sách Chương</h2>

    <div class="row">
        @foreach($course->modules as $index => $module)
            @php
                $isCompleted = in_array($module->id, $completedModules);
                $isUnlocked = $index === 0 || in_array($course->modules[$index - 1]->id, $completedModules);
            @endphp

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $module->title }}</h5>

                        <!-- Trạng thái -->
                        @if($isUnlocked)
                            <a href="{{ route('modules.show', ['module' => $module->id]) }}" class="btn btn-info">🎥 Học bài</a>

                            @if($isCompleted)
                                <button class="btn btn-success ms-2" disabled>✅ Đã hoàn thành</button>
                            @endif
                        @else
                            <button class="btn btn-secondary" disabled>🔒 Chưa mở khóa</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
