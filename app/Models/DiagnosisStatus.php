<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }
}