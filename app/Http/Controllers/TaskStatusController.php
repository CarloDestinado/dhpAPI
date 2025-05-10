<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    public function getTaskStatuses() {
        $taskStatuses = TaskStatus::get();

        return response()->json(['task_statuses' => $taskStatuses]);
    }

    public function addTaskStatus(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $taskStatus = TaskStatus::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Status added successfully!', 'task_status' => $taskStatus]);
    }

    public function editTaskStatus(Request $request, $id) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $taskStatus = TaskStatus::find($id);

        if(!$taskStatus) {
            return response()->json(['message' => 'Status not found.'], 404);
        }

        $taskStatus->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Status successfully updated!', 'task_status' => $taskStatus]);
    }

    public function deleteTaskStatus($id) {
        $taskStatus = TaskStatus::find($id);

        if(!$taskStatus) {
            return response()->json(['message' => 'Status not found.'], 404);
        }

        $taskStatus->delete();

        return response()->json(['message' => 'Status successfully deleted!']);
    }
}
