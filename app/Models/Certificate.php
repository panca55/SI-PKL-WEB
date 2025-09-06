<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    public $fillable = [
        'internship_id',
        'nama',
        'category',
        'score',
        'predikat',
        'nama_pimpinan',
        'file',
    ];

    const CATEGORY = [
        'UMUM' => 'UMUM',
        'KOMPETENSI UTAMA' => 'KOMPETENSI UTAMA',
        'KOMPETENSI PENUNJANG' => 'KOMPETENSI PENUNJANG'
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
