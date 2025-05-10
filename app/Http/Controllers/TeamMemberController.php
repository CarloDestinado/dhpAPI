<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TeamMember;

class TeamMemberController extends Controller
{
    public function getTeamMembers() {
        $teamMembers = TeamMember::with('team', 'user', 'role', 'teamMemberStatus')->get();

        return response()->json(['team_members' => $teamMembers]);
    }

    public function addTeamMember(Request $request) {
        $teamMembers = $request->all();

        if(isset($teamMembers[0])) {
            $createdTeamMembers = [];

            foreach($teamMembers as $teamData) {
                $validator = Validator::make($teamData,[
                    'team_id' => ['required', 'exists:teams,id'],
                    'user_id' => ['required', 'exists:users,id'],
                    'role_id' => ['required', 'exists:roles,id'],
                    'status_id' => ['required', 'exists:team_member_statuses,id'],
                ]);

                if($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $teamMember = TeamMember::create([
                    'team_id' => $teamData['team_id'],
                    'user_id' => $teamData['user_id'],
                    'role_id' => $teamData['role_id'],
                    'status_id' => $teamData['status_id'],
                ]);

                $createdTeamMembers[] = $teamMember;
            }

            return response()->json(['message' => 'Team Members Successfully Added!', 'team_members' => $createdTeamMembers]);
        } else {
            $request->validate([
                'team_id' => ['required', 'exists:teams,id'],
                'user_id' => ['required', 'exists:users,id'],
                'role_id' => ['required', 'exists:roles,id'],
                'status_id' => ['required', 'exists:team_member_statuses,id'],
            ]);
    
            $teamMember = TeamMember::create([
                'team_id' => $request->team_id,
                'user_id' => $request->user_id,
                'role_id' => $request->role_id,
                'status_id' => $request->status_id,
            ]);
    
            return response()->json(['message' => 'Team member added successfully!', 'team_member' => $teamMember]);
        }
    }

    public function addMember(Request $request, $id) {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $teamMember = TeamMember::find($id);

        if(!$teamMember) {
            return response()->json(['message' => 'Team member not found.'], 404);
        }

        $teamMember->update([
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Team member successfully assigned!', 'team_member' => $teamMember]);
    }

    public function editTeamMember(Request $request, $id) {
        $request->validate([
            'team_id' => ['nullable', 'exists:teams,id'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'status_id' => ['nullable', 'exists:team_member_statuses,id'],
        ]);

        $teamMember = TeamMember::find($id);

        if(!$teamMember) {
            return response()->json(['message' => 'Team member not found.'], 404);
        }

        $teamMember->update([
            'team_id' => $request->team_id,
            'role_id' => $request->role_id,
            'status_id' => $request->status_id,
        ]);

        return response()->json(['message' => 'Team member successfully edited!', 'team_member' => $teamMember]);
    }

    public function deleteTeamMember($id) {
        $teamMember = TeamMember::find($id);

        if(!$teamMember) {
            return response()->json(['message' => 'Team member not found.'], 404);
        }

        $teamMember->delete();

        return response()->json(['message' => 'Team member successfully deleted!']);
    }
}
