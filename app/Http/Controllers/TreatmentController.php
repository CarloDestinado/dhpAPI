<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use Illuminate\Support\Facades\Validator;

class TreatmentController extends Controller
{
    public function getTreatments()
    {
        $user = auth()->user();
        $treatments = Treatment::with(['doctor.user', 'patient.user', 'diagnosis']);

        if ($user->role === 'patient') {
            $treatments = $treatments->where('patient_id', $user->id);
        } elseif ($user->role === 'doctor') {
            $treatments = $treatments->where('doctor_id', $user->id);
        }

        return response()->json($treatments->get());
    }

    public function addTreatment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'treatment_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'date|nullable',
            'description' => 'required|string',
            'dosage' => 'string|nullable',
            'frequency' => 'string|nullable',
            'status' => 'string|in:planned,ongoing,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $treatment = Treatment::create($request->all());

        return response()->json([
            'message' => 'Treatment added successfully',
            'treatment' => $treatment
        ], 201);
    }

    public function editTreatment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'exists:users,id',
            'doctor_id' => 'exists:users,id',
            'diagnosis_id' => 'exists:diagnoses,id',
            'treatment_name' => 'string',
            'start_date' => 'date',
            'end_date' => 'date|nullable',
            'description' => 'string',
            'dosage' => 'string|nullable',
            'frequency' => 'string|nullable',
            'status' => 'string|in:planned,ongoing,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }

        $treatment->update($request->all());

        return response()->json([
            'message' => 'Treatment updated successfully',
            'treatment' => $treatment
        ]);
    }

    public function deleteTreatment($id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }

        $treatment->delete();

        return response()->json(['message' => 'Treatment deleted successfully']);
    }

    public function prescribeTreatment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dosage' => 'required|string',
            'frequency' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }

        $treatment->dosage = $request->dosage;
        $treatment->frequency = $request->frequency;
        $treatment->status = 'ongoing';
        $treatment->save();

        return response()->json([
            'message' => 'Treatment prescribed successfully',
            'treatment' => $treatment
        ]);
    }

    public function completeTreatment(Request $request, $id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }

        $treatment->status = 'completed';
        $treatment->end_date = now();
        $treatment->save();

        return response()->json([
            'message' => 'Treatment marked as completed',
            'treatment' => $treatment
        ]);
    }
}