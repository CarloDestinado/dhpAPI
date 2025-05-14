<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Active, Inactive, Deceased, etc.
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('patient_statuses')->insert([
            ['name' => 'Active', 'description' => 'Patient is active in the system'],
            ['name' => 'Inactive', 'description' => 'Patient is not currently active'],
            ['name' => 'Deceased', 'description' => 'Patient has passed away'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('patient_statuses');
    }
};