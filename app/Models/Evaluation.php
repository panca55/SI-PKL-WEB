<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'internship_id',
        'evaluation_date_id',
        'monitoring',
        'sertfikat',
        'logbook',
        'presentasi',
        'nilai_akhir'
    ];

    public function evaluationDate()
    {
        return $this->belongsTo(EvaluationDate::class);
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    // Setter untuk menghitung nilai akhir
    public function setFinalScoreAttribute()
    {
        $this->attributes['nilai_akhir'] = ($this->monitoring + $this->sertifikat + $this->logbook + $this->presentasi) / 4;
    }
}
