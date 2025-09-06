<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corporation extends Model
{
    use HasFactory, Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    protected $fillable = [
        'user_id',
        'nama',
        'slug',
        'alamat',
        'quota',
        'mulai_hari_kerja',
        'akhir_hari_kerja',
        'jam_mulai',
        'jam_berakhir',
        'hp',
        'deskripsi',
        'email_perusahaan',
        'website',
        'instagram',
        'tiktok',
        'logo',
        'foto',
    ];

    const DAYS = [
        'Senin' => 'Senin',
        'Selasa' => 'Selasa',
        'Rabu' => 'Rabu',
        'Kamis' => 'Kamis',
        'Jumat' => 'Jumat',
        'Sabtu' => 'Sabtu',
        'Minggu' => 'Minggu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function instructor()
    {
        return $this->hasMany(Instructor::class);
    }
    public function jobmarket()
    {
        return $this->hasMany(JobMarket::class);
    }
    public function internship()
    {
        return $this->hasMany(Internship::class);
    }
    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
