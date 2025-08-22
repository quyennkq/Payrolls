<?php

namespace App\Http\Controllers\Admin;

use App\Consts;

use App\Models\Extracurricular;
use App\Models\Student;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->routeDefault  = 'health';
        $this->viewPart = 'admin.pages.extracurricular';
        $this->responseData['module_name'] = 'Quản lý hoạt động ngoại khóa';
    }
    public function index()
    {
        $rows = Extracurricular::orderBy('created_at', 'desc')->paginate(10);
        $this->responseData['rows'] = $rows;
        return $this->responseView($this->viewPart . '.index');
    }

    public function create()
    {
        return $this->responseView($this->viewPart . '.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'first_date' => 'nullable|date|before_or_equal:last_date',
            'last_date' => 'nullable|date|after_or_equal:first_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'form_participation' => 'nullable|string|max:255',
            'form_organizational' => 'nullable|string|max:255',
            'expense' => 'nullable|numeric|min:0',
            'date' => 'nullable|array',
            'date.*' => 'nullable|date',
        ], [
            'name.required' => 'Tên chương trình ngoại khóa là bắt buộc.',
            'name.string' => 'Tên chương trình phải là chuỗi ký tự.',
            'name.max' => 'Tên chương trình không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả chương trình phải là chuỗi ký tự.',
            'description.max' => 'Mô tả chương trình không được vượt quá 1000 ký tự.',
            'first_date.date' => 'Ngày bắt đầu phải là định dạng ngày hợp lệ.',
            'first_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày kết thúc.',
            'last_date.date' => 'Ngày kết thúc phải là định dạng ngày hợp lệ.',
            'last_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'start_time.date_format' => 'Thời gian bắt đầu phải có định dạng HH:mm.',
            'end_time.date_format' => 'Thời gian kết thúc phải có định dạng HH:mm.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
            'location.string' => 'Địa điểm tổ chức phải là chuỗi ký tự.',
            'location.max' => 'Địa điểm tổ chức không được vượt quá 255 ký tự.',
            'form_participation.string' => 'Hình thức tham gia phải là chuỗi ký tự.',
            'form_participation.max' => 'Hình thức tham gia không được vượt quá 255 ký tự.',
            'form_organizational.string' => 'Hình thức tổ chức phải là chuỗi ký tự.',
            'form_organizational.max' => 'Hình thức tổ chức không được vượt quá 255 ký tự.',
            'expense.numeric' => 'Giá tiền phải là số.',
            'expense.min' => 'Giá tiền không được nhỏ hơn 0.',
            'date.array' => 'Danh sách ngày phải là mảng.',
            'date.*.date' => 'Mỗi ngày trong danh sách phải là định dạng ngày hợp lệ.',
        ]);

        $param = $request->all();
        $extracurricular = Extracurricular::create($param);
        $extracurricular->save();

        return redirect()->route($this->routeDefault .'.index')->with('success','Thêm thành công');
    }

    public function show($id)
    {
        $rows = Extracurricular::with('tb_students')->findOrFail($id);
        $students = Student::all();
        $this->responseData['rows'] = $rows;
        $this->responseData['students'] = $students;

        $this->responseData['module_name'] = 'Chi tiết sức khoẻ học sinh';
        return $this->responseView($this->viewPart . '.show');
    }


}
