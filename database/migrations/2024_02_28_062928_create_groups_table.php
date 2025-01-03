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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->date('started_date');
            $table->foreignId('subject_id')->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreignId('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete(); 
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
