<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalTest;
use Illuminate\Support\Facades\Validator;

class MedicalTestController extends Controller
{
    public function getMedicalTests()
    {
        $user = auth()->user();
        $tests = MedicalTest::with(['doctor.user', 'patient.user', 'status']);

        if ($user->role === 'patient') {
            $tests = $tests->where('patient_id', $user->id);
        } elseif ($user->role === 'doctor') {
            $tests = $tests->where('doctor_id', $user->id);
        }

        return response()->json($tests->get());
    }

    public function addMedicalTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'test_name' => 'required|string',
            'test_date' => 'required|date',
            'test_description' => 'string|nullable',
            'status_id' => 'required|exists:test_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $test = MedicalTest::create($request->all());

        return response()->json([
            'message' => 'Medical test added successfully',
            'test' => $test
        ], 201);
    }

    public function editMedicalTest(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'exists:users,id',
            'doctor_id' => 'exists:users,id',
            'test_name' => 'string',
            'test_date' => 'date',
            'test_description' => 'string|nullable',
            'status_id' => 'exists:test_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $test = MedicalTest::find($id);
        if (!$test) {
            return response()->json(['message' => 'Medical test not found'], 404);
        }

        $test->update($request->all());

        return response()->json([
            'message' => 'Medical test updated successfully',
            'test' => $test
        ]);
    }

    public function deleteMedicalTest($id)
    {
        $test = MedicalTest::find($id);
        if (!$test) {
            return response()->json(['message' => 'Medical test not found'], 404);
        }

        $test->delete();

        return response()->json(['message' => 'Medical test deleted successfully']);
    }

    public function orderTest(Request $request, $id)
    {
        $test = MedicalTest::find($id);
        if (!$test) {
            return response()->json(['message' => 'Medical test not found'], 404);
        }

        $test->status_id = 2; // Ordered status
        $test->save();

        return response()->json([
            'message' => 'Test ordered successfully',
            'test' => $test
        ]);
    }

    public function cancelTest(Request $request, $id)
    {
        $test = MedicalTest::find($id);
        if (!$test) {
            return response()->json(['message' => 'Medical test not found'], 404);
        }

        $test->status_id = 5; // Cancelled status
        $test->save();

        return response()->json([
            'message' => 'Test cancelled successfully',
            'test' => $test
        ]);
    }
}