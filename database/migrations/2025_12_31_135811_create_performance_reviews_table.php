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
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('review_date');
            $table->string('review_period'); // سنوي, ربع سنوي, شهري
            $table->json('kpis')->nullable(); // مؤشرات الأداء
            $table->integer('overall_rating')->default(0); // من 1 إلى 10
            $table->text('manager_notes')->nullable();
            $table->text('employee_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
