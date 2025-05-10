<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function getProfile() {
        $user = Auth::user();

        return response()->json(['Profile:' => $user]);
    }

    public function editProfile(Request $request) {
        $id = Auth::id();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:13'],
        ]);

        $user = User::find($id);

        if(!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
        
        return response()->json(['message' => 'Profile successfully updated!', 'user' => $user]);
    }

    public function changePassword(Request $request) {
        $id = Auth::id();

        $request->validate([
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $user = User::find($id);

        if(!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password changed successfully!']);
    }
}
