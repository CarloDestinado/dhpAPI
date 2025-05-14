<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diagnosis_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Preliminary, Confirmed, Ruled Out, etc.
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('diagnosis_statuses')->insert([
            ['name' => 'Preliminary', 'description' => 'Initial diagnosis requiring confirmation'],
            ['name' => 'Confirmed', 'description' => 'Diagnosis has been confirmed'],
            ['name' => 'Ruled Out', 'description' => 'Diagnosis has been ruled out'],
            ['name' => 'Chronic', 'description' => 'Chronic condition'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('diagnosis_statuses');
    }
};