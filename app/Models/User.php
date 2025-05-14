<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class);
    }

    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class);
    }

    public function diagnosesAsPatient()
    {
        return $this->hasMany(Diagnosis::class, 'patient_id');
    }

    public function diagnosesAsDoctor()
    {
        return $this->hasMany(Diagnosis::class, 'doctor_id');
    }

    public function medicalTestsAsPatient()
    {
        return $this->hasMany(MedicalTest::class, 'patient_id');
    }

    public function medicalTestsAsDoctor()
    {
        return $this->hasMany(MedicalTest::class, 'doctor_id');
    }

    public function testResultsAsPatient()
    {
        return $this->hasMany(TestResult::class, 'patient_id');
    }

    public function testResultsAsDoctor()
    {
        return $this->hasMany(TestResult::class, 'doctor_id');
    }

    public function treatmentsAsPatient()
    {
        return $this->hasMany(Treatment::class, 'patient_id');
    }

    public function treatmentsAsDoctor()
    {
        return $this->hasMany(Treatment::class, 'doctor_id');
    }

    public function ledTeams()
    {
        return $this->hasMany(MedicalTeam::class, 'leader_id');
    }

    public function teamMemberships()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}