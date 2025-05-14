<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ordered, In Progress, Completed, Cancelled
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('test_statuses')->insert([
            ['name' => 'Ordered', 'description' => 'Test has been ordered'],
            ['name' => 'In Progress', 'description' => 'Test is being processed'],
            ['name' => 'Completed', 'description' => 'Test has been completed'],
            ['name' => 'Cancelled', 'description' => 'Test was cancelled'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('test_statuses');
    }
};