<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PatientProfileController extends Controller
{
    public function getProfile()
    {
        $user = auth()->user();
        $profile = PatientProfile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile);
    }

    public function editProfile(Request $request)
    {
        $user = auth()->user();
        $profile = PatientProfile::where('user_id', $user->id)->first();

        $validator = Validator::make($request->all(), [
            'date_of_birth' => 'date',
            'gender' => 'string|in:male,female,other',
            'blood_type' => 'string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'height' => 'numeric',
            'weight' => 'numeric',
            'allergies' => 'string|nullable',
            'medical_history' => 'string|nullable',
            'contact_number' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($profile) {
            $profile->update($request->all());
        } else {
            $profile = PatientProfile::create(array_merge(
                ['user_id' => $user->id],
                $request->all()
            ));
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:current_password'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function getPatients(Request $request)
    {
        $patients = User::where('role', 'patient')
            ->with('patientProfile')
            ->get();

        return response()->json($patients);
    }

    public function addPatient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'date',
            'gender' => 'string|in:male,female,other'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient'
        ]);

        $profileData = $request->only([
            'date_of_birth', 'gender', 'blood_type', 'height', 
            'weight', 'allergies', 'medical_history', 'contact_number'
        ]);

        $profile = PatientProfile::create(array_merge(
            ['user_id' => $user->id],
            $profileData
        ));

        return response()->json([
            'message' => 'Patient added successfully',
            'user' => $user,
            'profile' => $profile
        ], 201);
    }

    public function editPatient(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'date_of_birth' => 'date',
            'gender' => 'string|in:male,female,other',
            'blood_type' => 'string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'height' => 'numeric',
            'weight' => 'numeric',
            'allergies' => 'string|nullable',
            'medical_history' => 'string|nullable',
            'contact_number' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($id);
        if (!$user || $user->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        $user->save();

        $profile = PatientProfile::where('user_id', $id)->first();
        if ($profile) {
            $profile->update($request->except(['name', 'email']));
        } else {
            $profile = PatientProfile::create(array_merge(
                ['user_id' => $id],
                $request->except(['name', 'email'])
            ));
        }

        return response()->json([
            'message' => 'Patient updated successfully',
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function deletePatient($id)
    {
        $user = User::find($id);
        if (!$user || $user->role !== 'patient') {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $profile = PatientProfile::where('user_id', $id)->first();
        if ($profile) {
            $profile->delete();
        }

        $user->delete();

        return response()->json(['message' => 'Patient deleted successfully']);
    }
}