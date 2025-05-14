<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorStatus;

class DoctorStatusController extends Controller
{
    public function getDoctorStatuses()
    {
        $statuses = DoctorStatus::all();
        return response()->json($statuses);
    }
}