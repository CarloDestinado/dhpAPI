<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'status_id',
        'test_name',
        'test_date',
        'test_description'
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
        return $this->belongsTo(TestStatus::class);
    }

    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}