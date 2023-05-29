<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function journal_entry()
    {
        return $this->hasMany(JournalEntry::class);
    }
}
