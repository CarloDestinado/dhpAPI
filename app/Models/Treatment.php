<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'diagnosis_id',
        'treatment_name',
        'start_date',
        'end_date',
        'description',
        'dosage',
        'frequency',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}