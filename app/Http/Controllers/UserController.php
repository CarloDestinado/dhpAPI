<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUsers() {
        $users = User::with('role', 'userStatus')->get();

        return response()->json(['users' => $users]);
    }

    public function addUser(Request $request) {
        $users = $request->all();

        if(isset($users[0])) {
            $createdUsers = [];

            foreach($users as $userData) {
                $validator = Validator::make($userData, [
                    'first_name' => ['required', 'string', 'max:255'],
                    'middle_name' => ['nullable', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255', 'unique:users'],
                    'phone_number' => ['required', 'string', 'max:255'],
                    'username' => ['required', 'string', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8'],
                    'confirm_password' => ['required', 'same:password'],
                    'role_id' => ['required', 'exists:roles,id'],
                    'status_id' => ['required', 'exists:user_statuses,id'],
                ]);

                if($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $user = User::create([
                    'first_name' => $userData['first_name'],
                    'middle_name' => $userData['middle_name'],
                    'last_name' => $userData['last_name'],
                    'email' => $userData['email'],
                    'phone_number' => $userData['phone_number'],
                    'username' => $userData['username'],
                    'password' => Hash::make($userData['password']),
                    'role_id' => 1,
                    'status_id' => 1,
                ]);

                $createdUsers[] = $user;
            }

            return response()->json(['message' => 'Users Created Successsfully!', 'users', $createdUsers]);
        } else {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'role_id' => ['required', 'exists:roles,id'],
                'status_id' => ['required', 'exists:user_statuses,id'],
            ]);

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'status_id' => $request->status_id,
            ]);

            return response()->json(['message' => 'User Successfully Created!', 'user' => $user]);
        }
    }

    public function editUser(Request $request, $id) {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:13'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'role_id' => ['required', 'exists:roles,id'],
            'status_id' => ['required', 'exists:user_statuses,id'],
        ]);

        $user = User::find($id);

        if(!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'status' => $request->status_id,
        ]);

        return response()->json(['message' => 'User successfully edited!', 'user' => $user]);
    }

    public function deleteUser($id) {
        $user = User::find($id);

        if(!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User successfully deleted!']);
    }
}
