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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->text('job_description');
            $table->string('department')->nullable();
            $table->enum('status', ['open', 'closed', 'on_hold'])->default('open');
            $table->date('posted_date');
            $table->date('closing_date')->nullable();
            $table->integer('applicants_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
