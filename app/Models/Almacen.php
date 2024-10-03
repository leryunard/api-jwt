<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacen';
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'stock', 'stock_minimo', 'stock_maximo', 'precio_compra', 'precio_venta', 'fecha_ingreso', 'imagen', 'id_usuario', 'id_categoria'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
}