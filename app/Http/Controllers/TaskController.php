<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function getTasks() {
        $tasks = Task::with('user', 'teamMember', 'project', 'taskStatus')->get();

        return response()->json(['tasks' => $tasks]);
    }

    public function addTask(Request $request) {
        $id = Auth::id();
        $tasks = $request->all();

        if(isset($tasks[0])) {
            $createdTasks = [];

            foreach($tasks as $taskData) {
                $validator = Validator::make($taskData, [
                    'task_name' => ['required', 'string', 'max:255'],
                    'description' => ['required', 'string', 'max:255'],
                    'date_created' => ['date'],
                    'due_date' => ['required', 'date'],
                    'user_id' => ['exists:users,id'],
                    'project_id' => ['required', 'exists:projects,id'],
                    'status_id' => ['required', 'exists:project_statuses,id'],
                ]);

                if($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $task = Task::create([
                    'task_name' => $taskData['task_name'],
                    'description' => $taskData['description'],
                    'date_created' => now()->toDateString(),
                    'due_date' => $taskData['due_date'],
                    'user_id' => $id,
                    'project_id' => $taskData['project_id'],
                    'status_id' => $taskData['status_id'],
                ]);

                $createdTasks[] = $task;
            }

            return response()->json(['message' => 'Tasks Created Successfully!', 'tasks' => $createdTasks]);
        } else {
            $request->validate([
                'task_name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'date_created' => ['date'],
                'due_date' => ['required', 'date'],
                'user_id' => ['exists:users,id'],
                'project_id' => ['required', 'exists:projects,id'],
                'status_id' => ['required', 'exists:project_statuses,id'],
            ]);
    
            $task = Task::create([
                'task_name' => $request->task_name,
                'description' => $request->description,
                'date_created' => now()->toDateString(),
                'due_date' => $request->due_date,
                'user_id' => $id,
                'project_id' => $request->project_id,
                'status_id' => $request->status_id,
            ]);
    
            return response()->json(['message' => 'Task added successfully!', 'task' => $task]);
        }
    }

    public function assignTask(Request $request, $id) {
        $request->validate([
            'team_member_id' => ['required', 'exists:team_members,id'],
        ]);

        $task = Task::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'team_member_id' => $request->team_member_id,
        ]);

        return response()->json(['message' => 'Task assigned successfully!', 'task' => $task]);
    }

    public function replaceTask(Request $request, $id) {
        $request->validate([
            'team_member_id' => ['required', 'exists:team_members,id'],
        ]);

        $task = Task::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'team_member_id' => $request->team_member_id,
        ]);

        return response()->json(['message' => 'Task replaced successfully!', 'task' => $task]);
    }

    public function removeTask($id) {
        $task = Task::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'team_member_id' => null,
        ]);

        return response()->json(['message' => 'Task removed successfully!', 'task' => $task]);
    }

    public function editTask(Request $request, $id) {
        $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'team_member_id' => ['nullable', 'exists:team_members,id'],
            'status_id' => ['required', 'exists:project_statuses,id'],
        ]);

        $task = Task::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'team_member_id' => $request->team_member_id,
            'status_id' => $request->status_id,
        ]);

        return response()->json(['message' => 'Task updated successfully!', 'task' => $task]);
    }

    public function deleteTask($id) {
        $task = Task::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!']);
    }

    public function completeTask($id) {
        $task = Task::find($id);

        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $task->update([
            'task_status' => 3,
        ]);

        return response()->json(['message' => 'Task completed!', 'task' => $task]);
    }
}
