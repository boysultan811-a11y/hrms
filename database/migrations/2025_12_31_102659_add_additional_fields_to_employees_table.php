<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('serial_number')->nullable()->after('id');
            $table->string('national_id')->nullable()->after('name');
            $table->text('address')->nullable()->after('national_id');
            $table->enum('gender', ['ذكر', 'أنثى'])->nullable()->after('address');
            $table->enum('marital_status', ['أعزب', 'متزوج', 'مطلق', 'أرمل'])->nullable()->after('gender');
            $table->string('qualification')->nullable()->after('marital_status');
            $table->string('job_address')->nullable()->after('position');
            $table->decimal('salary', 10, 2)->nullable()->after('job_address');
            $table->string('leave_category')->nullable()->after('salary');
            $table->string('work_schedule')->nullable()->after('leave_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'serial_number',
                'national_id',
                'address',
                'gender',
                'marital_status',
                'qualification',
                'job_address',
                'salary',
                'leave_category',
                'work_schedule',
            ]);
        });
    }
};
