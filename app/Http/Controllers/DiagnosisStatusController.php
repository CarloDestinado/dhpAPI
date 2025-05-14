<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosisStatus;

class DiagnosisStatusController extends Controller
{
    public function getDiagnosisStatuses()
    {
        $statuses = DiagnosisStatus::all();
        return response()->json($statuses);
    }
}