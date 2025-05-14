<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'patient_id'
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }
}