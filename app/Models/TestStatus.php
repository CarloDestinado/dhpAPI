<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function medicalTests()
    {
        return $this->hasMany(MedicalTest::class);
    }
}