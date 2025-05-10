<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMemberStatus;

class TeamMemberStatusController extends Controller
{
    public function getTeamMemberStatuses() {
        $teamMemberStatuses = TeamMemberStatus::get();

        return response()->json(['team_member_statuses' => $teamMemberStatuses]);
    }

    public function addTeamMemberStatus(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $teamMemberStatus = TeamMemberStatus::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Status added successfully!', 'team_member_status' => $teamMemberStatus]);
    }

    public function editTeamMemberStatus(Request $request, $id) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $teamMemberStatus = TeamMemberStatus::find($id);

        if(!$teamMemberStatus) {
            return response()->json(['message' => 'Status not found.'], 404);
        }

        $teamMemberStatus->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Status successfully updated!', 'team_member_status' => $teamMemberStatus]);
    }

    public function deleteTeamMemberStatus($id) {
        $teamMemberStatus = TeamMemberStatus::find($id);

        if(!$teamMemberStatus) {
            return response()->json(['message' => 'Status not found.'], 404);
        }

        $teamMemberStatus->delete();

        return response()->json(['message' => 'Status successfully deleted!']);
    }
}
