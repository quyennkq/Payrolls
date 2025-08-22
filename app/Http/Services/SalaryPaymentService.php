<?php
namespace App\Http\Services;

use App\Models\SalaryPayment;
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
}
