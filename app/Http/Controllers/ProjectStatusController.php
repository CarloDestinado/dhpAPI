<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;

class ProjectStatusController extends Controller
{
    public function getProjectStatuses() {
        $projectStatuses = ProjectStatus::get();

        return response()->json(['project_statuses' => $projectStatuses]);
    }

    public function addProjectStatus(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $projectStatus = ProjectStatus::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Status added successfully!', 'project_status' => $projectStatus]);
    }

    public function editProjectStatus(Request $request, $id) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $projectStatus = ProjectStatus::find($id);

        if(!$projectStatus) {
            return response()->json(['message' => 'Status not found.'], 404);
        }

        $projectStatus->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Status successfully updated!', 'project_status' => $projectStatus]);
    }

    public function deleteProjectStatus($id) {
        $projectStatus = ProjectStatus::find($id);

        if(!$projectStatus) {
            return response()->json(['message' => 'Status not found.'], 404);
        }

        $projectStatus->delete();

        return response()->json(['message' => 'Status successfully deleted!']);
    }
}
