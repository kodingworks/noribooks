<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'journal_entry' => 'array'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
