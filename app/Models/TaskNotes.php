<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class TaskNotes extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'task_notes';

    protected $fillable = [
        'task_id', 'subject', 'notes'
    ];

    public function tasks()
    {
        return $this->belongsTo(Task::class);
    }

    public function notes_attachments()
    {
        return $this->hasMany(NotesAttachment::class);
    }
}
