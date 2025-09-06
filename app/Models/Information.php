<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'isi',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];
}
