<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'hp',
        'golongan',
        'bidang_studi',
        'pendidikan_terakhir',
        'jabatan',
        'foto'
    ];

    const GENDERS = [
        'PRIA' => 'PRIA',
        'WANITA' => 'WANITA',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function internship()
    {
        return $this->hasMany(Internship::class);
    }
}
