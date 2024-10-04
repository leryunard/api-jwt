<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
class Almacen extends Model implements AuditableContract 
{
    use HasFactory,Auditable;
    protected $table = 'almacen';
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'stock', 'stock_minimo', 'stock_maximo', 'precio_compra', 'precio_venta', 'fecha_ingreso', 'imagen', 'id_usuario', 'id_categoria'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static $rules = [
        'nombre' => 'required|string|min:2|max:255',
        'descripcion' => 'required|string|min:2',
        'stock' => 'required|integer',
        'stock_minimo' => 'required|integer',
        'stock_maximo' => 'required|integer',
        'precio_compra' => 'required|string|min:2|max:255',
        'precio_venta' => 'required|string|min:2|max:255',
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'id_categoria' => 'required|integer',
    ];
    
    public static $messages = [
        'nombre.required' => 'El campo nombre es obligatorio.',
        'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
        'nombre.min' => 'El campo nombre debe tener al menos 2 caracteres.',
        'nombre.max' => 'El campo nombre no puede tener más de 255 caracteres.',
        'descripcion.required' => 'El campo descripción es obligatorio.',
        'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
        'descripcion.min' => 'El campo descripción debe tener al menos 2 caracteres.',
        'descripcion.max' => 'El campo descripción no puede tener más de 255 caracteres.',
        'stock.required' => 'El campo stock es obligatorio.',
        'stock.integer' => 'El campo stock debe ser un número entero.',
        'stock_minimo.required' => 'El campo stock mínimo es obligatorio.',
        'stock_minimo.integer' => 'El campo stock mínimo debe ser un número entero.',
        'stock_maximo.required' => 'El campo stock máximo es obligatorio.',
        'stock_maximo.integer' => 'El campo stock máximo debe ser un número entero.',
        'precio_compra.required' => 'El campo precio de compra es obligatorio.',
        'precio_compra.string' => 'El campo precio de compra debe ser una cadena de texto.',
        'precio_compra.min' => 'El campo precio de compra debe tener al menos 2 caracteres.',
        'precio_compra.max' => 'El campo precio de compra no puede tener más de 255 caracteres.',
        'precio_venta.required' => 'El campo precio de venta es obligatorio.',
        'precio_venta.string' => 'El campo precio de venta debe ser una cadena de texto.',
        'precio_venta.min' => 'El campo precio de venta debe tener al menos 2 caracteres.',
        'precio_venta.max' => 'El campo precio de venta no puede tener más de 255 caracteres.',
        'imagen.required' => 'El campo imagen es obligatorio.',
        'imagen.image' => 'El campo imagen debe ser una imagen.',
        'imagen.mimes' => 'El campo imagen debe ser un archivo de tipo: jpeg, png, jpg, gif, svg.',
        'imagen.max' => 'El campo imagen no puede ser mayor que 2048 kilobytes.',
        'id_categoria.required' => 'El campo categoría es obligatorio.',
        'id_categoria.integer' => 'El campo categoría debe ser un número entero.',
    ];
    public function categoria()
    {
        return $this->belongsTo(Category::class, 'id_categoria');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}