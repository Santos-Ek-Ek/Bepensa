<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CFDI extends Model
{
    use HasFactory;

    protected $table = "cfdi";

    protected $fillable = [
        "folio",
        "nombre",
        "activo"
    ];
}
