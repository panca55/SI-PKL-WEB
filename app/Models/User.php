<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'is_active',
        'password',
    ];

    const ROLES = [
        'ADMIN' => 'ADMIN',
        'SISWA' => 'SISWA',
        'GURU' => 'GURU',
        'PERUSAHAAN' => 'PERUSAHAAN',
        'INSTRUKTUR' => 'INSTRUKTUR',
        'WAKAHUMAS' => 'WAKAHUMAS',
        'WAKAKURIKULUM' => 'WAKAKURIKULUM',
        'KEPSEK' => 'KEPSEK',
        'WAKASEK' => 'WAKASEK',
        'DAPODIK' => 'DAPODIK',
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    public function corporation()
    {
        return $this->hasOne(Corporation::class);
    }
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
