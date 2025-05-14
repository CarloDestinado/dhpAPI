<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    public function getDiagnoses()
    {
        $user = auth()->user();
        $diagnoses = Diagnosis::with(['doctor.user', 'patient.user', 'status']);

        if ($user->role === 'patient') {
            $diagnoses = $diagnoses->where('patient_id', $user->id);
        } elseif ($user->role === 'doctor') {
            $diagnoses = $diagnoses->where('doctor_id', $user->id);
        }

        return response()->json($diagnoses->get());
    }

    public function addDiagnosis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis_date' => 'required|date',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'string|nullable',
            'notes' => 'string|nullable',
            'status_id' => 'required|exists:diagnosis_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $diagnosis = Diagnosis::create($request->all());

        return response()->json([
            'message' => 'Diagnosis added successfully',
            'diagnosis' => $diagnosis
        ], 201);
    }

    public function editDiagnosis(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'exists:users,id',
            'doctor_id' => 'exists:users,id',
            'diagnosis_date' => 'date',
            'symptoms' => 'string',
            'diagnosis' => 'string',
            'treatment_plan' => 'string|nullable',
            'notes' => 'string|nullable',
            'status_id' => 'exists:diagnosis_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $diagnosis = Diagnosis::find($id);
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        $diagnosis->update($request->all());

        return response()->json([
            'message' => 'Diagnosis updated successfully',
            'diagnosis' => $diagnosis
        ]);
    }

    public function deleteDiagnosis($id)
    {
        $diagnosis = Diagnosis::find($id);
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        $diagnosis->delete();

        return response()->json(['message' => 'Diagnosis deleted successfully']);
    }

    public function assignDiagnosis(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $diagnosis = Diagnosis::find($id);
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        $diagnosis->doctor_id = $request->doctor_id;
        $diagnosis->save();

        return response()->json([
            'message' => 'Diagnosis assigned successfully',
            'diagnosis' => $diagnosis
        ]);
    }

    public function updateDiagnosisStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:diagnosis_statuses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $diagnosis = Diagnosis::find($id);
        if (!$diagnosis) {
            return response()->json(['message' => 'Diagnosis not found'], 404);
        }

        $diagnosis->status_id = $request->status_id;
        $diagnosis->save();

        return response()->json([
            'message' => 'Diagnosis status updated successfully',
            'diagnosis' => $diagnosis
        ]);
    }
}