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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان التقرير
            $table->string('type'); // نوع التقرير: موظفين, حضور, رواتب, أداء
            $table->date('start_date')->nullable(); // تاريخ البداية
            $table->date('end_date')->nullable(); // تاريخ النهاية
            $table->text('description')->nullable(); // وصف التقرير
            $table->json('data')->nullable(); // بيانات التقرير (JSON)
            $table->string('file_path')->nullable(); // مسار ملف التقرير (PDF/Excel)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
