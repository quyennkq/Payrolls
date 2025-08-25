<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('admins')->onDelete('cascade'); // Liên kết nhân viên
            $table->date('leave_date_start')->nullable(); // Ngày bắt đầu nghỉ
            $table->date('leave_date_end')->nullable(); // Ngày kết thúc
            $table->string('leave_type')->nullable(); // Loại nghỉ (ví dụ: có lương, không lương)
            $table->text('reason')->nullable()->nullable(); // Lý do nghỉ
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái
            $table->json('json_params')->nullable();

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
        Schema::dropIfExists('leave_request');
    }
}
