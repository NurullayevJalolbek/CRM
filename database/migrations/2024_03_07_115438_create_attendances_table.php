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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->index();
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();
            $table->foreignId('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            $table->date('attendance_date');
            $table->integer('created_by')->nullable();
            $table->boolean('status'); // 0 for absent, 1 for present
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
