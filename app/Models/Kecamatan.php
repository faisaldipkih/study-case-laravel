<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $fillable = [
        "code_kab",
        "code_kec",
        "name_kec"
    ];
    public $incrementing = false;
}
