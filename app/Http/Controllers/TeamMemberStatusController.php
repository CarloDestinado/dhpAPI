<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMemberStatus;

class TeamMemberStatusController extends Controller
{
    public function getTeamMemberStatuses()
    {
        $statuses = TeamMemberStatus::all();
        return response()->json($statuses);
    }
}