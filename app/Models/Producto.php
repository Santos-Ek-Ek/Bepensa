<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $with = ['categorias'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'codigo',
        'nombre',
        'descripcion'
    ];


    public function categorias(){
        return $this->belongsTo(Categoria::class,'id_categoria', 'id');
    }
}
