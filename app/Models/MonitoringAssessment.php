<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'nama',
        'softskill',
        'norma',
        'teknis',
        'pemahaman',
        'catatan',
        'score',
        'deskripsi_softskill',
        'deskripsi_norma',
        'deskripsi_teknis',
        'deskripsi_pemahaman',
        'deskripsi_catatan',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
