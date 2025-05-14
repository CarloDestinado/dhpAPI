<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'license_number',
        'years_of_experience',
        'hospital_affiliation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'doctor_id', 'user_id');
    }

    public function orderedTests()
    {
        return $this->hasMany(MedicalTest::class, 'doctor_id', 'user_id');
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class, 'doctor_id', 'user_id');
    }

    public function prescribedTreatments()
    {
        return $this->hasMany(Treatment::class, 'doctor_id', 'user_id');
    }

    public function ledTeams()
    {
        return $this->hasMany(MedicalTeam::class, 'leader_id', 'user_id');
    }

    public function teamMemberships()
    {
        return $this->hasMany(TeamMember::class, 'user_id', 'user_id');
    }
}