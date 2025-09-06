<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'logbook_id',
        'note_type',
        'catatan',
        'penilaian',
    ];

    const GRADE = [
        'SUDAH BAGUS' => 'SUDAH BAGUS',
        'PERBAIKI' => 'PERBAIKI',
    ];

    public function logbook()
    {
        return $this->belongsTo(Logbook::class);
    }
}
