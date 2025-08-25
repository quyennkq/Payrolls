<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('admins')->onDelete('cascade'); // Liên kết nhân viên
            $table->dateTime('check_in')->nullable()->nullable(); // Giờ vào làm
            $table->dateTime('check_out')->nullable()->nullable(); // Giờ tan làm
            $table->decimal('work_hours', 5, 2)->nullable()->default(0); // Số giờ làm trong ngày
            $table->integer('standard_working_days')->nullable()->default(0); // Ngày công chuẩn trong kỳ
            $table->integer('probation_days')->nullable()->default(0); // Số ngày công thử việc
            $table->integer('official_days')->nullable()->default(0); // Số ngày công chính thức
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
        Schema::dropIfExists('attendance');
    }
}
