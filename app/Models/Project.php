<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'description',
        'date_created',
        'due_date',
        'user_id',
        'status_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function projectStatus() {
        return $this->belongsTo(ProjectStatus::class);
    }
}
