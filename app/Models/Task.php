<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'description',
        'date_created',
        'due_date',
        'user_id',
        'team_member_id',
        'project_id',
        'status_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function teamMember() {
        return $this->belongsTo(TeamMember::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
    
    public function taskStatus() {
        return $this->belongsTo(TaskStatus::class);
    }
}
