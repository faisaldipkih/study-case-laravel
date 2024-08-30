<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningNasabah extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "works_id",
        "user_id",
        "nama_lengkap",
        "tempat_lahir",
        "tgl_lahir",
        "jenis_kelamin",
        "alamat",
        "nominal_setor",
        "status",
    ];
}
