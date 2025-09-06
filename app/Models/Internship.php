<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'corporation_id',
        'instructor_id',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function absents()
    {
        return $this->hasMany(Absent::class);
    }

    public function logbook()
    {
        return $this->hasMany(Logbook::class);
    }

    public function assessment()
    {
        return $this->hasMany(MonitoringAssessment::class);
    }

    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
