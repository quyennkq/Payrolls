<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Controllers\Admin\Controller;
use App\Http\Services\DataPermissionService;
use App\Models\Health;
use App\Models\Student;
use Exception;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->routeDefault  = 'health';
        $this->viewPart = 'admin.pages.health';
        $this->responseData['module_name'] = 'Quản lý sức khoẻ học sinh';
    }

    public function index()
    {
        $students = Student::with('latestHealth')->with('latestHealth')->paginate(10);
        $this->responseData['students'] = $students;
        return $this->responseView($this->viewPart . '.index');
    }


    public function create($id) {
        $student = Student::findOrFail($id);
        $health = Health::where('student_id', $id)->first();
        if (!$health) {
            $health = new Health();
            $health->student_id = $id;
        }
        $this->responseData['tb_health'] = $health;
        $this->responseData['student'] = $student;
        $this->responseData['module_name'] = 'Thêm lần khám học sinh';

        return $this->responseView($this->viewPart . '.create');
    }


    public function store(Request $request, $id){
        $request->validate([
            'height'=> 'required',
            'weight' => 'required',
            'health_rate' => 'required',
            'blood_pressure' => 'required'
        ]);
        $student = Student::findOrFail($id);

        $param = $request->all();
        $param['student_id'] = $student->id;

        $health = Health::create($param);
        $health->save();

        return redirect()->route($this->routeDefault .'.show', $student->id)->with('success','Thêm thành công');
    }

    public function show($id){
    $student = Student::findOrFail($id);
    $healths = Health::where('student_id', $id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    $latestHealth = $student->latestHealth()->first();
    $this->responseData['student'] = $student;
    $this->responseData['healths'] = $healths;
    $this->responseData['latestHealth'] = $latestHealth;

    $this->responseData['module_name'] = 'Chi tiết sức khoẻ học sinh';
    return $this->responseView($this->viewPart . '.show');
    }

    public function edit($id){
        $health = Health::find($id);
        $this->responseData['health'] = $health;
        return $this->responseView($this->viewPart . '.edit');
    }

    public function update(Request $request, $id)
    {
    $health = Health::findOrFail($id);

    $request->validate([

        'height' => 'required|numeric',
        'weight' => 'required|numeric',
        'health_rate' => 'required|numeric',
        'blood_pressure' => 'required|numeric',
    ]);

    // Giữ nguyên student_id cũ
    $health->height = $request->height;
    $health->weight = $request->weight;
    $health->health_rate = $request->health_rate;
    $health->blood_pressure = $request->blood_pressure;

    // BẮT BUỘC giữ nguyên student_id cũ nếu form không gửi lại student_id
    $health->student_id = $health->student_id;

    $health->save();

     return redirect()->route($this->routeDefault . '.index')->with('success', 'Xóa thành công');
    }




    public function destroy($id){
        $row = Health::find($id);
        $row->delete();
        return redirect()->route($this->routeDefault . '.show', $row->student_id )->with('success', 'Xóa thành công');
    }
}
