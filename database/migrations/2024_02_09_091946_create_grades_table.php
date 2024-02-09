<?php

use GuzzleHttp\Promise\Create;
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
        /*
         A => 80 - 100
         B => 80 - 60
         C => 60 - 40
         D => 40 - 20
        */
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
