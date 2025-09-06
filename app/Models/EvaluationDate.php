<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date'
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
