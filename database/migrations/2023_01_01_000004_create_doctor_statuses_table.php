<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctor_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Active, On Leave, Retired, etc.
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('doctor_statuses')->insert([
            ['name' => 'Active', 'description' => 'Doctor is active and available'],
            ['name' => 'On Leave', 'description' => 'Doctor is temporarily unavailable'],
            ['name' => 'Retired', 'description' => 'Doctor has retired from practice'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('doctor_statuses');
    }
};