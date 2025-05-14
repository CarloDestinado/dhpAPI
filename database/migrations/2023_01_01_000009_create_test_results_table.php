<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('medical_tests')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('result_date');
            $table->text('result_summary');
            $table->text('detailed_report')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('file_path')->nullable(); // For storing PDF/image results
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_results');
    }
};