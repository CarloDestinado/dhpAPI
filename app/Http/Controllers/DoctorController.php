<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function getDoctors()
    {
        $doctors = User::where('role', 'doctor')
            ->with('doctor')
            ->get();

        return response()->json($doctors);
    }

    public function addDoctor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'specialization' => 'required|string',
            'license_number' => 'required|string|unique:doctors',
            'years_of_experience' => 'integer|min:0',
            'hospital_affiliation' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor'
        ]);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'license_number' => $request->license_number,
            'years_of_experience' => $request->years_of_experience,
            'hospital_affiliation' => $request->hospital_affiliation
        ]);

        return response()->json([
            'message' => 'Doctor added successfully',
            'user' => $user,
            'doctor' => $doctor
        ], 201);
    }

    public function editDoctor(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'specialization' => 'string',
            'license_number' => 'string|unique:doctors,license_number,' . $id . ',user_id',
            'years_of_experience' => 'integer|min:0',
            'hospital_affiliation' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($id);
        if (!$user || $user->role !== 'doctor') {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        $user->save();

        $doctor = Doctor::where('user_id', $id)->first();
        if ($doctor) {
            $doctor->update($request->except(['name', 'email']));
        } else {
            $doctor = Doctor::create(array_merge(
                ['user_id' => $id],
                $request->except(['name', 'email'])
            ));
        }

        return response()->json([
            'message' => 'Doctor updated successfully',
            'user' => $user,
            'doctor' => $doctor
        ]);
    }

    public function deleteDoctor($id)
    {
        $user = User::find($id);
        if (!$user || $user->role !== 'doctor') {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor = Doctor::where('user_id', $id)->first();
        if ($doctor) {
            $doctor->delete();
        }

        $user->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}