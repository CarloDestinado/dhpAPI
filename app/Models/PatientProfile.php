<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'blood_type',
        'height',
        'weight',
        'allergies',
        'medical_history',
        'contact_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'patient_id', 'user_id');
    }

    public function medicalTests()
    {
        return $this->hasMany(MedicalTest::class, 'patient_id', 'user_id');
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'patient_id', 'user_id');
    }

    public function assignedTeam()
    {
        return $this->hasOne(MedicalTeam::class, 'patient_id', 'user_id');
    }
}