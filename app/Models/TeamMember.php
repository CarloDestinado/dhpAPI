<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'role',
        'status_id'
    ];

    public function team()
    {
        return $this->belongsTo(MedicalTeam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(TeamMemberStatus::class);
    }
}