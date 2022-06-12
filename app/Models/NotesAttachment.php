<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class NotesAttachment extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'notes_attachments';

    protected $fillable = [
        'notes_id', 'title', 'path'
    ];

    public function task_notes_attach()
    {
        return $this->belongsTo(TaskNotes::class);
    }
}
