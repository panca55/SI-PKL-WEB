<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public $fillable = [
        'student_id',
        'corporation_id',
        'komentar',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }
}
