<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalTeam;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Validator;

class MedicalTeamController extends Controller
{
    public function getMedicalTeams()
    {
        $teams = MedicalTeam::with(['members.user', 'leader.user'])->get();
        return response()->json($teams);
    }

    public function addMedicalTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string|nullable',
            'leader_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $team = MedicalTeam::create($request->all());

        return response()->json([
            'message' => 'Medical team created successfully',
            'team' => $team
        ], 201);
    }

    public function editMedicalTeam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string|nullable',
            'leader_id' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $team = MedicalTeam::find($id);
        if (!$team) {
            return response()->json(['message' => 'Medical team not found'], 404);
        }

        $team->update($request->all());

        return response()->json([
            'message' => 'Medical team updated successfully',
            'team' => $team
        ]);
    }

    public function deleteMedicalTeam($id)
    {
        $team = MedicalTeam::find($id);
        if (!$team) {
            return response()->json(['message' => 'Medical team not found'], 404);
        }

        $team->delete();

        return response()->json(['message' => 'Medical team deleted successfully']);
    }

    public function assignToTeam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $team = MedicalTeam::find($id);
        if (!$team) {
            return response()->json(['message' => 'Medical team not found'], 404);
        }

        $team->patient_id = $request->patient_id;
        $team->save();

        return response()->json([
            'message' => 'Patient assigned to team successfully',
            'team' => $team
        ]);
    }

    public function getTeamMembers()
    {
        $members = TeamMember::with(['user', 'team', 'status'])->get();
        return response()->json($members);
    }

    public function addTeamMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|exists:medical_teams,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string',
            'status_id' => 'required|exists:team_member_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $member = TeamMember::create($request->all());

        return response()->json([
            'message' => 'Team member added successfully',
            'member' => $member
        ], 201);
    }

    public function editTeamMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'exists:medical_teams,id',
            'user_id' => 'exists:users,id',
            'role' => 'string',
            'status_id' => 'exists:team_member_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['message' => 'Team member not found'], 404);
        }

        $member->update($request->all());

        return response()->json([
            'message' => 'Team member updated successfully',
            'member' => $member
        ]);
    }

    public function deleteTeamMember($id)
    {
        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['message' => 'Team member not found'], 404);
        }

        $member->delete();

        return response()->json(['message' => 'Team member deleted successfully']);
    }
}