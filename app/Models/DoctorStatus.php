<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function doctors()
    {
        return $this->hasManyThrough(
            Doctor::class,
            User::class,
            'status_id',
            'user_id',
            'id',
            'id'
        )->where('role', 'doctor');
    }
}