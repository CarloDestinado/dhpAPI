<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DiagnosisStatusController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalTestController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\PatientStatusController;
use App\Http\Controllers\DoctorStatusController;
use App\Http\Controllers\MedicalTeamController;
use App\Http\Controllers\TeamMemberStatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Health Diagnosis Profile API Routes
|
*/

// Public routes
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::put('/reset-password/{id}', [AuthenticationController::class, 'resetPassword']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function() {

    // Authentication
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Patient Profile
    Route::get('/get-profile', [PatientProfileController::class, 'getProfile']);
    Route::put('/edit-profile', [PatientProfileController::class, 'editProfile']);
    Route::put('/change-password', [PatientProfileController::class, 'changePassword']);

    // Patients (for doctors/admins)
    Route::get('/get-patients', [PatientProfileController::class, 'getPatients']);
    Route::post('/add-patient', [PatientProfileController::class, 'addPatient']);
    Route::put('/edit-patient/{id}', [PatientProfileController::class, 'editPatient']);
    Route::delete('/delete-patient/{id}', [PatientProfileController::class, 'deletePatient']);

    // Doctors
    Route::get('/get-doctors', [DoctorController::class, 'getDoctors']);
    Route::post('/add-doctor', [DoctorController::class, 'addDoctor']);
    Route::put('/edit-doctor/{id}', [DoctorController::class, 'editDoctor']);
    Route::delete('/delete-doctor/{id}', [DoctorController::class, 'deleteDoctor']);

    // Diagnosis
    Route::get('/get-diagnoses', [DiagnosisController::class, 'getDiagnoses']);
    Route::post('/add-diagnosis', [DiagnosisController::class, 'addDiagnosis']);
    Route::put('/edit-diagnosis/{id}', [DiagnosisController::class, 'editDiagnosis']);
    Route::delete('/delete-diagnosis/{id}', [DiagnosisController::class, 'deleteDiagnosis']);
    Route::put('/assign-diagnosis/{id}', [DiagnosisController::class, 'assignDiagnosis']);
    Route::put('/update-diagnosis-status/{id}', [DiagnosisController::class, 'updateDiagnosisStatus']);

    // Medical Tests
    Route::get('/get-medical-tests', [MedicalTestController::class, 'getMedicalTests']);
    Route::post('/add-medical-test', [MedicalTestController::class, 'addMedicalTest']);
    Route::put('/edit-medical-test/{id}', [MedicalTestController::class, 'editMedicalTest']);
    Route::delete('/delete-medical-test/{id}', [MedicalTestController::class, 'deleteMedicalTest']);
    Route::put('/order-test/{id}', [MedicalTestController::class, 'orderTest']);
    Route::put('/cancel-test/{id}', [MedicalTestController::class, 'cancelTest']);

    // Test Results
    Route::get('/get-test-results', [TestResultController::class, 'getTestResults']);
    Route::post('/add-test-result', [TestResultController::class, 'addTestResult']);
    Route::put('/edit-test-result/{id}', [TestResultController::class, 'editTestResult']);
    Route::delete('/delete-test-result/{id}', [TestResultController::class, 'deleteTestResult']);
    Route::put('/upload-test-result/{id}', [TestResultController::class, 'uploadTestResult']);

    // Treatments
    Route::get('/get-treatments', [TreatmentController::class, 'getTreatments']);
    Route::post('/add-treatment', [TreatmentController::class, 'addTreatment']);
    Route::put('/edit-treatment/{id}', [TreatmentController::class, 'editTreatment']);
    Route::delete('/delete-treatment/{id}', [TreatmentController::class, 'deleteTreatment']);
    Route::put('/prescribe-treatment/{id}', [TreatmentController::class, 'prescribeTreatment']);
    Route::put('/complete-treatment/{id}', [TreatmentController::class, 'completeTreatment']);

    // Medical Teams
    Route::get('/get-medical-teams', [MedicalTeamController::class, 'getMedicalTeams']);
    Route::post('/add-medical-team', [MedicalTeamController::class, 'addMedicalTeam']);
    Route::put('/edit-medical-team/{id}', [MedicalTeamController::class, 'editMedicalTeam']);
    Route::delete('/delete-medical-team/{id}', [MedicalTeamController::class, 'deleteMedicalTeam']);
    Route::put('/assign-to-team/{id}', [MedicalTeamController::class, 'assignToTeam']);

    // Team Members
    Route::get('/get-team-members', [MedicalTeamController::class, 'getTeamMembers']);
    Route::post('/add-team-member', [MedicalTeamController::class, 'addTeamMember']);
    Route::put('/edit-team-member/{id}', [MedicalTeamController::class, 'editTeamMember']);
    Route::delete('/delete-team-member/{id}', [MedicalTeamController::class, 'deleteTeamMember']);

    // Status Controllers
    Route::get('/get-patient-statuses', [PatientStatusController::class, 'getPatientStatuses']);
    Route::get('/get-doctor-statuses', [DoctorStatusController::class, 'getDoctorStatuses']);
    Route::get('/get-diagnosis-statuses', [DiagnosisStatusController::class, 'getDiagnosisStatuses']);
    Route::get('/get-team-member-statuses', [TeamMemberStatusController::class, 'getTeamMemberStatuses']);
});