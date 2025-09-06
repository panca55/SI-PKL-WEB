<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'category',
        'tanggal',
        'judul',
        'bentuk_kegiatan',
        'penugasan_pekerjaan',
        'mulai',
        'selesai',
        'petugas',
        'isi',
        // 'komentar_instruktur',
        // 'komentar_guru',
        'foto_kegiatan',
        'keterangan',
        'penilaian',
    ];

    const ASSIGNMENT = [
        'DITUGASKAN' => 'DITUGASKAN',
        'INISIATIF' => 'INISIATIF',
    ];

    const ACTIVITY = [
        'MANDIRI' => 'MANDIRI',
        'BIMBINGAN' => 'BIMBINGAN',
    ];

    const CATEGORY = [
        'KOMPETENSI' => 'KOMPETENSI',
        'LAINNYA' => 'LAINNYA',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
    public function note()
    {
        return $this->hasMany(Note::class);
    }
}
