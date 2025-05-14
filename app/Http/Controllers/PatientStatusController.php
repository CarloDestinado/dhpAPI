<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientStatus;

class PatientStatusController extends Controller
{
    public function getPatientStatuses()
    {
        $statuses = PatientStatus::all();
        return response()->json($statuses);
    }
}