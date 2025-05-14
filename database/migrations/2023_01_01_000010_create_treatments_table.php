<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('diagnosis_id')->constrained('diagnoses')->onDelete('cascade');
            $table->string('treatment_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description');
            $table->string('dosage')->nullable();
            $table->string('frequency')->nullable();
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('treatments');
    }
};