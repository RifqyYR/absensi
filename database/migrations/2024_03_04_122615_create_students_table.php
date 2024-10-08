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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('parent_id');
            $table->string('name');
            $table->string('nis');
            $table->string('nisn')->unique();
            $table->integer('generation');
            $table->string('born_place');
            $table->date('born_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('address');
            $table->integer('violation_points');
            $table->string('class');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('student_parents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
