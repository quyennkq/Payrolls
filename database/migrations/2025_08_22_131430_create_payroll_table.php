<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('admins')->onDelete('cascade'); // Liên kết nhân viên
            $table->date('month'); // Tháng tính lương (yyyy-mm-01)

            // Thu nhập tính theo ngày công
            $table->decimal('base_salary_by_days', 15, 2)->nullable()->default(0); // Lương cơ bản theo ngày công
            $table->decimal('competency_salary_by_days', 15, 2)->nullable()->default(0); // Lương năng lực theo ngày công
            $table->decimal('performance_salary_by_days', 15, 2)->nullable()->default(0); // Lương HQCV theo ngày công
            $table->decimal('subtotal_income', 15, 2)->nullable()->default(0); // Tổng thu nhập lương chính

            // Các khoản cộng thêm
            $table->decimal('late_sat_cost', 15, 2)->nullable()->default(0); // Phạt đi muộn/sớm/thứ 7
            $table->decimal('travel_phone_ticket', 15, 2)->nullable()->default(0); // Hỗ trợ xăng xe, điện thoại, vé xe
            $table->decimal('multitask_allowance', 15, 2)->nullable()->default(0); // Phụ cấp kiêm nhiệm
            $table->decimal('saturday_meal_support', 15, 2)->nullable()->default(0); // Hỗ trợ bữa trưa thứ 7
            $table->decimal('business_bonus', 15, 2)->nullable()->default(0); // Thưởng kinh doanh
            $table->decimal('handover_support', 15, 2)->nullable()->default(0); // Hỗ trợ bàn giao công việc
            $table->decimal('adjustment', 15, 2)->nullable()->default(0); // Truy lĩnh hoặc truy thu

            // Tổng thu nhập và thu nhập tính thuế
            $table->decimal('total_income', 15, 2)->nullable()->default(0); // Tổng thu nhập trước thuế
            $table->decimal('non_taxable_income', 15, 2)->nullable()->default(0); // Thu nhập không chịu thuế
            $table->decimal('taxable_income', 15, 2)->nullable()->default(0); // Thu nhập chịu thuế

            // Giảm trừ
            $table->decimal('personal_deduction', 15, 2)->nullable()->default(0); // Giảm trừ gia cảnh
            $table->decimal('taxable_base', 15, 2)->nullable()->default(0); // Thu nhập tính thuế sau giảm trừ

            // Các khoản khấu trừ
            $table->decimal('union_fee', 15, 2)->nullable()->default(0); // Đoàn phí công đoàn 1%
            $table->decimal('social_insurance', 15, 2)->nullable()->default(0); // BHXH nhân viên đóng
            $table->decimal('income_tax', 15, 2)->nullable()->default(0); // Thuế TNCN
            $table->decimal('other_deductions', 15, 2)->nullable()->default(0); // Các khoản trừ khác

            $table->decimal('total_deductions', 15, 2)->nullable()->default(0); // Tổng khấu trừ
            $table->decimal('advance_payment', 15, 2)->nullable()->default(0); // Tạm ứng
            $table->decimal('net_income', 15, 2)->nullable()->default(0); // Lương thực lĩnh
            $table->json('json_params')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll');
    }
}
