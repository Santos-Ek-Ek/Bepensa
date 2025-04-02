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
        'total',
        'forma_pago',
        'activo'
    ];

    // Relación con Cliente
    public function cliente()
    {
            return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // traer productos
    public function productos()
    {
        return $this->hasMany(FacturacionProducto::class, 'facturacion_id')->where('activo', 1);
    }
}
