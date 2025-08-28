<?php
namespace App\Http\Services;

use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalaryPaymentService{
    public function importFormExcel($file)
    {
        $data = Excel::toArray(null, $file);
        foreach ($data[0] as $key => $row) {
            if ($key === 0) continue; // Skip header row
            SalaryPayment::create([
                'employee_id' => $row[0],
                'base_salary' => $row[1],
                'competency_salary' => $row[2],
                'performance_salary' => $row[3],
                'position_income' => $row[4],
                'social_insurance_salary' => $row[5],
            ]);
        }
    }

    public function createOrUpdateSalaryPayment(array $data, $id = null)
    {
        // tính work_hours
        if ($id) {
            $salaryPayment = SalaryPayment::findOrFail($id);
            $salaryPayment->update($data);
            return $salaryPayment;
        }

        return SalaryPayment::create($data);
    }

    public function filter(Request $request)
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

        return $query->paginate(10);
    }
}
