<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mayor_id',
        'nisn',
        'nama',
        'konsentrasi',
        'tahun_masuk',
        'jenis_kelamin',
        'status_pkl',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_siswa',
        'alamat_ortu',
        'hp_siswa',
        'hp_ortu',
        'foto',
    ];

    const GENDERS = [
        'PRIA' => 'PRIA',
        'WANITA' => 'WANITA',
    ];

    const STATUS = [
        'BELUM PKL' => 'BELUM PKL',
        'SEDANG PKL' => 'SEDANG PKL',
        'SUDAH PKL' => 'SUDAH PKL',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mayor()
    {
        return $this->belongsTo(Mayor::class);
    }
    public function internship()
    {
        return $this->hasOne(Internship::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
