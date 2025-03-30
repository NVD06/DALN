<div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($courses as $course)
        <div class="col">
            <div class="card text-white shadow-lg border-0 h-100" 
                 style="background-color: {{ ['#FF6F61', '#6B5B95', '#88B04B', '#F7CAC9', '#92A8D1'][ $course->id % 5 ] }};">
                
                {{-- Ảnh khóa học từ Picsum, random theo course ID --}}
                <img src="https://picsum.photos/seed/{{ $course->id }}/400/200" 
                     class="card-img-top" 
                     alt="Course Image">

                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        <a href="{{ route('courses.show', $course->id) }}" class="text-decoration-none text-light">
                            <i class="fas fa-book"></i> {{ $course->title }}
                        </a>
                    </h5>
                    
                    {{-- Hiển thị tiến trình học --}}
                    <p>
                        <i class="fas fa-chart-line"></i> Tiến trình: 
                        @if($course->isRegistered(Auth::user()->id))
                            <span class="badge bg-light text-dark">{{ $course->getProgress(Auth::user()->id) }}%</span>
                        @else
                            <span class="badge bg-dark">Chưa đăng ký</span>
                        @endif
                    </p>
                    
                    {{-- Hiển thị điểm đánh giá trung bình --}}
                    <p>
                        ⭐ <strong>{{ number_format($course->reviews->avg('rating'), 1) }}/5</strong>
                    </p>
                </div>
                
                <div class="card-footer text-center border-0">
                    @php
                        $userCourse = \App\Models\CourseUser::where('user_id', Auth::id())->where('course_id', $course->id)->first();
                        $progress = $course->getProgress(Auth::user()->id);
                        $testResult = \App\Models\TestResult::where('user_id', Auth::id())->where('course_id', $course->id)->first();
                    @endphp

                    {{-- Kiểm tra xem người dùng đã thanh toán chưa --}}
                    @if($userCourse && $userCourse->paid)
                        {{-- Nếu hoàn thành 100% nhưng chưa có kết quả bài kiểm tra --}}
                        @if($progress == 100 && !$testResult)
                            {{-- Nếu có bài kiểm tra thì hiển thị nút làm bài --}}
                            @if($course->test)
                                <a href="{{ route('courses.test', ['course' => $course->id, 'test' => $course->test->id]) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-clipboard-check"></i> Làm bài kiểm tra
                                </a>
                            @else
                                {{-- Nếu không có bài kiểm tra thì hiển thị thông báo --}}
                                <span class="badge bg-light text-dark">Chưa có bài kiểm tra</span>
                            @endif
                        {{-- Nếu đã làm bài kiểm tra nhưng chưa đạt --}}
                        @elseif($testResult && !$testResult->passed)
                            <span class="badge bg-danger">Chưa đạt</span>
                            @if($course->test)
                                <a href="{{ route('courses.test', ['course' => $course->id, 'test' => $course->test->id]) }}" 
                                   class="btn btn-light btn-sm text-dark">
                                    <i class="fas fa-sync-alt"></i> Thi lại
                                </a>
                            @endif
                        {{-- Nếu đã làm bài kiểm tra và đạt --}}
                        @elseif($testResult && $testResult->passed)
                            <span class="badge bg-success">Hoàn thành</span>
                            <a href="{{ route('courses.review', $course->id) }}" class="btn btn-light btn-sm text-dark">
                                <i class="fas fa-star"></i> Đánh giá
                            </a>
                        @else
                            {{-- Nếu chưa hoàn thành thì hiển thị nút vào học --}}
                            <a href="{{ route('courses.learn', $course->id) }}" class="btn btn-light btn-sm text-dark">
                                <i class="fas fa-play-circle"></i> Vào học
                            </a>
                        @endif
                    @else
                        {{-- Nếu chưa thanh toán thì hiển thị nút đăng ký học --}}
                        <a href="{{ route('courses.payment', $course->id) }}" class="btn btn-dark btn-sm">
                            <i class="fas fa-shopping-cart"></i> Đăng ký học
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
