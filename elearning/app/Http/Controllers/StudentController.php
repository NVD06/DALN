<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    // Hiển thị danh sách khóa học, có tìm kiếm
    public function index(Request $request)
    {
        $search = $request->query('search');
        $courses = Course::when($search, function($query, $search) {
            return $query->where('title', 'like', "%$search%");
        })->withCount('modules')->get();

        return view('courses.index', compact('courses'));
    }

    // Hiển thị chi tiết một khóa học
    public function show($id)
    {
        $course = Course::with(['modules', 'creator'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }
    
    public function register($id)
    {
        $userId = Auth::id();
    
        // Kiểm tra xem đã thanh toán hay chưa
        $payment = CourseUser::where('user_id', $userId)
                             ->where('course_id', $id)
                             ->first();
    
        if ($payment && !$payment->paid) {
            return redirect()->route('courses.payment', $id)->with('error', 'Bạn cần thanh toán trước khi đăng ký học.');
        }
    
        if (!$payment) {
            CourseUser::create([
                'user_id' => $userId,
                'course_id' => $id,
                'paid' => false // Chưa thanh toán
            ]);
            return redirect()->route('courses.payment', $id)->with('error', 'Bạn cần thanh toán trước khi đăng ký học.');
        }
    
        return redirect()->route('courses.index')->with('success', 'Đã đăng ký khóa học thành công!');
    }
    public function showPaymentForm($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.payment', compact('course'));
    }
    public function processPayment(Request $request, $id)
    {
        $userId = Auth::id();
        $course = Course::findOrFail($id);
    
        // Kiểm tra nếu khóa học đã được thanh toán
        $courseUser = CourseUser::where('user_id', $userId)->where('course_id', $id)->first();
    
        if (!$courseUser) {
            return redirect()->route('courses.index')->with('error', 'Không tìm thấy khóa học!');
        }
    
        // Giả lập thanh toán thành công (ở thực tế có thể tích hợp cổng thanh toán VNPay, Momo, PayPal)
        $paymentSuccess = true;
    
        if ($paymentSuccess) {
            $courseUser->update(['paid' => true]);
    
            return redirect()->route('courses.index')->with('success', 'Thanh toán thành công! Bạn đã đăng ký khóa học.');
        }
    
        return redirect()->route('courses.payment', $id)->with('error', 'Thanh toán thất bại, vui lòng thử lại.');
    }
            
    // Học khóa học - hiển thị danh sách modules và trạng thái hoàn thành
    public function learn($courseId)
    {
        $course = Course::with('modules')->findOrFail($courseId);
    
        $completedModules = DB::table('completed_modules')
            ->where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->pluck('module_id')
            ->toArray();
    
        // Lấy module đầu tiên (nếu có) để chuyển hướng người dùng vào học ngay
        $firstModule = $course->modules->first();
    
        return view('courses.learn', compact('course', 'completedModules', 'firstModule'));
    }
    

    // Xem nội dung của một module
    public function viewModule($moduleId)
    {
        $module = Module::findOrFail($moduleId);
        return view('courses.module', compact('module'));
    }

    public function complete($moduleId)
    {
        $module = Module::findOrFail($moduleId);
        $user = Auth::user();
    
        // Kiểm tra nếu module đã được hoàn thành chưa
        $exists = DB::table('completed_modules')
            ->where([
                ['user_id', '=', $user->id],
                ['module_id', '=', $module->id],
                ['course_id', '=', $module->course_id]
            ])
            ->exists();
    
        if (!$exists) {
            // Nếu chưa hoàn thành thì thêm vào
            DB::table('completed_modules')->insert([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'course_id' => $module->course_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Tìm chương tiếp theo
        $nextModule = Module::where('course_id', $module->course_id)
            ->where('id', '>', $module->id) // Chương tiếp theo có ID lớn hơn
            ->orderBy('id') // Sắp xếp theo thứ tự ID
            ->first();
    
        if ($nextModule) {
            // **🔹 Chuyển hướng trực tiếp đến chương tiếp theo**
            return redirect()->route('modules.show', ['module' => $nextModule->id])
                ->with('success', 'Bạn đã hoàn thành chương này! Đang chuyển đến chương tiếp theo...');
        }
    
        return redirect()->route('courses.index')->with('success', 'Bạn đã hoàn thành khóa học!');
    }
    
    // Lấy danh sách module đã hoàn thành của người dùng cho một khóa học
    public function getCompletedModules($courseId)
    {
        $userId = Auth::id();

        $completedModules = DB::table('completed_modules')
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->pluck('module_id')
            ->toArray();

        return view('courses.learn', compact('completedModules', 'courseId'));
    }
}
