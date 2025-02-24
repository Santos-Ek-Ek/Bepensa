<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $with = ['tipos'];
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'id_tipo'
    ];

    public function tipos(){
        return $this->belongsTo(Tipo::class,'id_tipo', 'id');
    }
}
