<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $fillable = [
        "code_kab",
        "code_prov",
        "name_kab"
    ];
    public $incrementing = false;
}
