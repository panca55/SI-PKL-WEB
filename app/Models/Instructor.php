<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'corporation_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'hp',
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
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }
    public function internship()
    {
        return $this->hasMany(Internship::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
