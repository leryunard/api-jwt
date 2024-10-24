<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Ventas extends Model implements AuditableContract
{
    use HasFactory, Auditable;
    protected $table = 'ventas';
    
    protected $fillable = [
        'id_cliente',
        'total_pagado',
        'num_venta',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

   public static $rules = [
        'id_cliente' => 'required|integer',
        'total_pagado' => 'required|numeric',
        'num_venta' => 'required|string|max:255',
    ];

    public static $messages = [
        'id_cliente.required' => 'El cliente es obligatorio.',
        'id_cliente.integer' => 'El cliente debe ser un número entero.',
        'total_pagado.required' => 'El total pagado es obligatorio.',
        'total_pagado.numeric' => 'El total pagado debe ser un número.',
        'num_venta.required' => 'El número de venta es obligatorio.',
        'num_venta.string' => 'El número de venta debe ser una cadena de texto.',
        'num_venta.max' => 'El número de venta no puede exceder los 255 caracteres.',
    ];

    public static function rules($id = null)
    {
        $rules = self::$rules;

        // Ajustar las reglas de unicidad correctamente usando el formato adecuado
        $rules['num_venta'] = $id ? "required|string|max:255|unique:ventas,num_venta,$id,id" : 'required|string|max:255|unique:ventas,num_venta';

        return $rules;
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }

    public function carrito()
    {
        return $this->hasOne(Carrito::class, 'num_venta', 'num_venta');
    }

    
}
