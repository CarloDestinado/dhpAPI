<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('team_member_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Active, Inactive, On Leave
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('team_member_statuses')->insert([
            ['name' => 'Active', 'description' => 'Member is active on the team'],
            ['name' => 'Inactive', 'description' => 'Member is not currently active'],
            ['name' => 'On Leave', 'description' => 'Member is temporarily unavailable'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('team_member_statuses');
    }
};