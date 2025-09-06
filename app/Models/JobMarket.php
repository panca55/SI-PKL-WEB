<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobMarket extends Model
{
    use HasFactory, Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }
    protected $fillable = [
        'corporation_id',
        'judul',
        'slug',
        'deskripsi',
        'persyaratan',
        'jenis_pekerjaan',
        'lokasi',
        'rentang_gaji',
        'batas_pengiriman',
        'contact_email',
        'foto',
        'status',
    ];

    const WORKS = ['Full-time', 'Part-time', 'Magang'];

    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }
}
