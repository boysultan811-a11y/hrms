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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('contract_type'); // دائم, مؤقت, تدريب
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('salary', 10, 2);
            $table->text('terms')->nullable();
            $table->enum('status', ['active', 'expired', 'terminated'])->default('active');
            $table->string('document_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
