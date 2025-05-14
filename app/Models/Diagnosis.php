<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'status_id',
        'diagnosis_date',
        'symptoms',
        'diagnosis',
        'treatment_plan',
        'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function status()
    {
        return $this->belongsTo(DiagnosisStatus::class);
    }

    public function medicalTests()
    {
        return $this->hasMany(MedicalTest::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}