<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TeamMemberStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_member_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $teamMemberStatuses = [
            ['name' => 'Available'],
            ['name' => 'Unavailable'],
        ];

        foreach($teamMemberStatuses as $teamMemberStatus) {
            TeamMemberStatus::create($teamMemberStatus);    
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_member_statuses');
    }
};
