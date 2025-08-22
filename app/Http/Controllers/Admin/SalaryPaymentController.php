<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\SalaryPaymentService;
use App\Models\SalaryPayment;

use Illuminate\Http\Request;

class SalaryPaymentController extends Controller
{
    protected $salaryPaymentService;
    public function __construct(SalaryPaymentService $salaryPaymentService)
    {
        parent::__construct();
        $this->responseData['module_name'] = 'Quản lý mức lương';
        $this->routeDefault = 'salary_payment';
        $this->viewPart = 'admin.pages.salary_payments';
        $this->salaryPaymentService = $salaryPaymentService;
    }

    public function index(Request $request)
    {

       $query = SalaryPayment::query();

        // lọc theo mã nhân viên
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        //lọc theo khoảng ngày
        if ($request->filled('date')) {
            $query->whereDate('leave_date', '=', $request->form_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //sắp xếp
        // $sort = $request->get('sort', 'asc');
        // $query->orderBy('leave_date', $sort);

        $rows = $query->paginate(10);
        $this->responseData['rows'] = $rows;
        return $this->responseView($this->viewPart . '.index', $this->responseData);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('excel_file');
        $this->salaryPaymentService->importFormExcel($file);
        return redirect()->route('salary_payment.index')->with('successMessage','Thêm dữ liệu mức lương thành công');
    }

    public function create()
    {

        return $this->responseView($this->viewPart .'.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'base_salary' => 'required|numeric',
            'competency_salary' => 'required|numeric',
            'performance_salary' => 'required|numeric',
            'position_income' => 'required|numeric',
            'social_insurance_salary' => 'required|numeric',
        ]);
        $this->salaryPaymentService->createOrUpdateSalaryPayment($request->all());
        return redirect()->route('salary_payment.index')->with('successMessage','Thêm mới thành công');
    }

    public function edit($id)
    {
        $salary_payment = SalaryPayment::findOrFail($id);
        $this->responseData['salary_payment'] = $salary_payment;
        return $this->responseView($this->viewPart .'.edit', $this->responseData);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'base_salary' => 'required|numeric',
            'competency_salary' => 'required|numeric',
            'performance_salary' => 'required|numeric',
            'position_income' => 'required|numeric',
            'social_insurance_salary' => 'required|numeric',
        ]);
        $this->salaryPaymentService->createOrUpdateSalaryPayment($request->all(), $id);
        return redirect()->route('salary_payment.index')->with('successMessage','Sửa thành công');
    }

    public function destroy($id)
    {
        $salary_payment = SalaryPayment::findOrFail($id);
        $salary_payment->delete();
        $this->responseData['salary_payment'] = $salary_payment;
        return redirect()->route('salary_payment.index', $this->responseData)->with('successMessage','Xóa thành công');
    }
}
