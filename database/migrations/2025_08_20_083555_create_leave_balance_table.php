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
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade'); // Liên kết nhân viên
            $table->integer('year')->default(0); // Số ngày nghỉ
            $table->integer('month')->default(0); // Số ngày nghỉ
            $table->integer('total_leave')->default(0); // Số ngày nghỉ
            $table->integer('used_leave')->default(0); // Số ngày nghỉ đã sử dụng
            $table->integer('remaining_leave')->default(0); // Số ngày nghỉ còn lại
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
