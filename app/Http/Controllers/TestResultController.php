<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestResult;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TestResultController extends Controller
{
    public function getTestResults()
    {
        $user = auth()->user();
        $results = TestResult::with(['test', 'doctor.user', 'patient.user']);

        if ($user->role === 'patient') {
            $results = $results->where('patient_id', $user->id);
        } elseif ($user->role === 'doctor') {
            $results = $results->where('doctor_id', $user->id);
        }

        return response()->json($results->get());
    }

    public function addTestResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|exists:medical_tests,id',
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'result_date' => 'required|date',
            'result_summary' => 'required|string',
            'detailed_report' => 'string|nullable',
            'recommendations' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $result = TestResult::create($request->all());

        // Update test status to completed
        $test = MedicalTest::find($request->test_id);
        if ($test) {
            $test->status_id = 4; // Completed status
            $test->save();
        }

        return response()->json([
            'message' => 'Test result added successfully',
            'result' => $result
        ], 201);
    }

    public function editTestResult(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'exists:medical_tests,id',
            'patient_id' => 'exists:users,id',
            'doctor_id' => 'exists:users,id',
            'result_date' => 'date',
            'result_summary' => 'string',
            'detailed_report' => 'string|nullable',
            'recommendations' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $result = TestResult::find($id);
        if (!$result) {
            return response()->json(['message' => 'Test result not found'], 404);
        }

        $result->update($request->all());

        return response()->json([
            'message' => 'Test result updated successfully',
            'result' => $result
        ]);
    }

    public function deleteTestResult($id)
    {
        $result = TestResult::find($id);
        if (!$result) {
            return response()->json(['message' => 'Test result not found'], 404);
        }

        $result->delete();

        return response()->json(['message' => 'Test result deleted successfully']);
    }

    public function uploadTestResult(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'result_file' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $result = TestResult::find($id);
        if (!$result) {
            return response()->json(['message' => 'Test result not found'], 404);
        }

        if ($request->hasFile('result_file')) {
            $path = $request->file('result_file')->store('test_results');
            $result->file_path = $path;
            $result->save();

            return response()->json([
                'message' => 'Test result file uploaded successfully',
                'result' => $result
            ]);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }
}