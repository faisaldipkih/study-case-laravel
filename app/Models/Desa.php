<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $fillable = [
        "code_desa",
        "code_kec",
        "name_desa"
    ];
    public $incrementing = false;
}
