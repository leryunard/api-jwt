<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';
    protected $fillable = [
        'num_compra',
        'fecha_compra',
        'comprobante',
        'precio_compra',
        'cantidad',
        'id_almacen',
        'id_proveedor',
        'id_usuario',
    ];

}
