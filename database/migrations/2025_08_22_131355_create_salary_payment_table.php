<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('admins')->onDelete('cascade'); // Liên kết nhân viên
            $table->decimal('base_salary', 15, 2)->nullable()->default(0); // Mức lương cơ bản theo vị trí
            $table->decimal('competency_salary', 15, 2)->nullable()->default(0); // Lương năng lực cá nhân (có điều kiện)
            $table->decimal('performance_salary', 15, 2)->nullable()->default(0); // Lương hiệu quả công việc (có điều kiện)
            $table->decimal('position_income', 15, 2)->nullable()->default(0); // Thu nhập theo vị trí
            $table->decimal('social_insurance_salary', 15, 2)->nullable()->default(0);
            $table->json('json_params')->nullable();
            $table->string('status')->nullable()->default('active'); // Mức lương dùng để đóng BHXH
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
        Schema::dropIfExists('salary_payment');
    }
}
