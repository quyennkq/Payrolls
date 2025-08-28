<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\PayrollService;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $payrollService;
    public function __construct(PayrollService $payrollService)
    {
        parent::__construct();
        $this->routeDefault  = 'payroll';
        $this->viewPart = 'admin.pages.payroll';
        $this->responseData['module_name'] = 'Quản lý bảng lương';
        $this->payrollService = $payrollService;
    }

    public function index(Request $request)
    {
        // $query = Payroll::query();

        // // lọc theo mã nhân viên
        // if ($request->filled('employee_id')) {
        //     $query->where('employee_id', $request->employee_id);
        // }

        // if ($request->filled('month')) {
        //     $month = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        //     $query->whereMonth('month', $month->month)
        //         ->whereYear('month', $month->year);
        // }
        //   if ($request->filled('form_date')) {
        //     $query->whereDate('created_at', '>=', $request->form_date);
        // }
        // if ($request->filled('to_date')) {
        //     $query->whereDate('created_at', '<=', $request->to_date);
        // }

        // if ($request->filled('status')) {
        //     $query->where('status', $request->status);
        // }

        // //sắp xếp
        // $sort = $request->get('sort', 'asc');
        // $query->orderBy('month', $sort);

        $rows = $this->payrollService->filter($request);
        $this->responseData['rows'] = $rows;
        return $this->responseView($this->viewPart . '.index');
    }

    public function import(Request $request)
    {

        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('excel_file');
        $this->payrollService->importFormExcel($file);
        return redirect()->route('payroll.index')->with('successMessage', 'Bạn đã thêm bảng lương thành công.');
    }
    public function create()
    {
        return $this->responseView($this->viewPart . '.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'month' => 'required|date',
            'travel_phone_ticket' => 'required|numeric',
            'saturday_meal_support' => 'required|numeric',
        ]);
        $this->payrollService->createOrUpdatePayroll($request->all());
        return redirect()->route('payroll.index')->with('successMessage', 'Bạn đã thêm mới thành công');
    }
    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $this->responseData['payroll'] = $payroll;
        return $this->responseView($this->viewPart . '.edit', $this->responseData);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'month' => 'required|date',
            'travel_phone_ticket' => 'required|numeric',
            'saturday_meal_support' => 'required|numeric',
        ]);
        $this->payrollService->createOrUpdatePayroll($request->all(), $id);
        return redirect()->route('payroll.index')->with('successMessage', 'Bạn đã sửa thành công');
    }
    public function show(Payroll $payroll, $id)
    {
        $payroll = Payroll::findOrFail($id);
        $this->responseData['payroll'] = $payroll;
        return $this->responseView($this->viewPart . '.show', $this->responseData);
    }
    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payroll.index')->with('successMessage', 'Bạn đã xóa thành công');
    }
}
