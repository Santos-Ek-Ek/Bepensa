<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';
    protected $with = ['retornables','noretornables','vacios'];
    protected $primarykey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'paletas',
        'saldos_c_tarimas',
        'saldos_s_tarimas',
        'total',
        'id_tipo'
    ];
    public function retornables(){
        return $this->belongsTo(Producto::class,'id_producto', 'id');}

    public function noretornables(){
            return $this->belongsTo(Producto::class,'id_producto', 'id');}

    public function vacios(){
                return $this->belongsTo(Producto::class,'id_producto', 'id');}
    public function tipo()
        {
            return $this->belongsTo(Tipo::class, 'id_tipo');
         }
}
