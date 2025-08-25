<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_balance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('admins')->onDelete('cascade'); // Liên kết nhân viên
            $table->integer('year')->nullable()->default(0); // Số ngày nghỉ
            $table->integer('month')->nullable()->default(0); // Số ngày nghỉ
            $table->integer('total_leave')->nullable()->default(0); // Số ngày nghỉ
            $table->integer('used_leave')->nullable()->default(0); // Số ngày nghỉ đã sử dụng
            $table->integer('remaining_leave')->nullable()->default(0); // Số ngày nghỉ còn lại
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
        Schema::dropIfExists('leave_balance');
    }
}
