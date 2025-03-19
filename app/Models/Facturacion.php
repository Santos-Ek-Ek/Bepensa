<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    use HasFactory;

    protected $table = "facturaciones";
    protected $fillable = [
        'cliente_id',
        'cfdi_id',
        'codigo',
        'forma_pago',
        'activo'
    ];
}
