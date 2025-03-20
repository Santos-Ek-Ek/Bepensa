<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturacionProducto extends Model
{
    use HasFactory;

    protected $table = 'facturacion_producto';

    protected $fillable = [
        'facturacion_id',
        'producto_id',
        'precio',
        'cantidad',
        'subtotal',
        'activo'
    ];
}
