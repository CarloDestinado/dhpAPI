<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'patient_id',
        'doctor_id',
        'result_date',
        'result_summary',
        'detailed_report',
        'recommendations',
        'file_path'
    ];

    public function test()
    {
        return $this->belongsTo(MedicalTest::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}