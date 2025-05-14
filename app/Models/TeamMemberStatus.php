<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMemberStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }
}