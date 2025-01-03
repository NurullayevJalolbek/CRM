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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->index();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            $table->foreignId('group_id')->index();
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->index();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->integer('paid_amount');
            $table->string('remark')->nullable();
            $table->integer('created_by');
            $table->boolean('payment_status')->default(0); 
            $table->string('payment_month'); // Store month and year only (e.g., 'MM-YYYY') 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
