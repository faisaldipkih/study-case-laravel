<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $fillable = [
        "code_prov",
        "name_prov"
    ];
    public $incrementing = false;
}
