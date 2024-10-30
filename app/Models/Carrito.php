<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Carrito extends Model implements AuditableContract
{
    use HasFactory, Auditable;
    protected $table = 'carrito';

    protected $fillable = [
        'cantidad',
        'num_venta',
        'id_almacen',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static $rules = [
        'cantidad' => 'required|integer',
        'num_venta' => 'required|string|max:255',
        'id_almacen' => 'required|integer',
    ];

    public static $messages = [
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'num_venta.required' => 'El num_venta es obligatorio.',
        'num_venta.string' => 'El num_venta debe ser una cadena de texto.',
        'num_venta.max' => 'El num_venta no puede exceder los 255 caracteres.',
        'id_almacen.required' => 'El producto es obligatorio.',
        'id_almacen.integer' => 'El producto debe ser un número entero.',
    ];

    public static function rules($id = null)
    {
        $rules = self::$rules;

        // Ajustar las reglas de unicidad correctamente usando el formato adecuado
        $rules['num_venta'] = $id ? "required|string|max:255|unique:carrito,num_venta,$id,id" : 'required|string|max:255|unique:carrito,num_venta';

        return $rules;
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'num_venta', 'num_venta');
    }
}
