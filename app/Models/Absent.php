<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'tanggal',
        'keterangan',
        'deskripsi',
        'photo'
    ];

    const DESC = [
        'HADIR' => 'HADIR',
        'IZIN' => 'IZIN',
        'SAKIT' => 'SAKIT',
        'ALPHA' => 'ALPHA',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
