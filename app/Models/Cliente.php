<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre_tienda",
        "propietario",
        "cod_cte",
        "rfc",
        "direccion",
        "activo"
    ];

    // Relación con Facturacion
    public function facturaciones()
    {
        return $this->hasMany(Facturacion::class, 'cliente_id');
    }
}
