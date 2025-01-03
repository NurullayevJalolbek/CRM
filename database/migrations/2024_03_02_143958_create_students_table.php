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
            $table->string('name');
            $table->string('number');
            $table->string('parent_name')->nullable();
            $table->string('parent_number')->nullable();
            $table->date('started_date')->nullable();
            $table->date('birthday')->nullable();
            $table->foreignId('subject_id')->nullable()->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreignId('social_id')->nullable()->index();
            $table->foreign('social_id')->references('id')->on('social_links')->onDelete('cascade');
            $table->enum('status', ['active', 'archive', 'passive']);
            $table->boolean('payment_status')->default(false);
            $table->text('notes')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }



    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });
    }
};
