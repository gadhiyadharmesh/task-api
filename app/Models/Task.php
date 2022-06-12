<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'task';

    protected $fillable = [
        'subject', 'description', 'start_date', 'end_date', 'status', 'priority'
    ];

    public function task_notes()
    {
        return $this->hasMany(TaskNotes::class);
    }

}
