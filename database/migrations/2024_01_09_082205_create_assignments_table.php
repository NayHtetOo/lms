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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_section_id')->constrained()->onDelete('cascade');
            $table->integer('mark')->nullable();
            $table->string('assignment_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**http://127.0.0.1:8000/admin/course-sections
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
