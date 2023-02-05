<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nim';
    protected $table = 'mahasiswa';
    protected $fillable = ['nim', 'nama', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'no_telepon', 'foto', 'status'];
}
