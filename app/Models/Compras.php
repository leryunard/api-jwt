<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Compras extends Model implements AuditableContract
{
    use HasFactory, Auditable;
    protected $table = 'compras';
   
    protected $fillable = ['numero', 'fecha', 'comprobante', 'precio', 'cantidad', 'id_almacen', 'id_proveedor', 'id_usuario'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static $rules = [
        'numero' => 'required|integer|unique:compras,numero',
        'fecha' => 'required|date',
        'comprobante' => 'required|string|max:255',
        'precio' => 'required|numeric|between:0,9999.99',
        'cantidad' => 'required|integer',
        'id_almacen' => 'required|exists:almacen,id',
        'id_proveedor' => 'required|exists:proveedores,id',
    ];

    public static $messages = [
        'numero.required' => 'El número es obligatorio.',
        'numero.integer' => 'El número debe ser un número entero.',
        'numero.unique' => 'El número ya está en uso.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha debe ser una fecha válida.',
        'comprobante.required' => 'El comprobante es obligatorio.',
        'comprobante.string' => 'El comprobante debe ser una cadena de texto.',
        'comprobante.max' => 'El comprobante no puede exceder los 255 caracteres.',
        'precio.required' => 'El precio es obligatorio.',
        'precio.numeric' => 'El precio debe ser un número.',
        'precio.between' => 'El precio debe estar entre 0 y 9999.99.',
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'id_almacen.required' => 'El almacén es obligatorio.',
        'id_almacen.exists' => 'El almacén no existe.',
        'id_proveedor.required' => 'El proveedor es obligatorio.',
        'id_proveedor.exists' => 'El proveedor no existe.',
        'id_usuario.exists' => 'El usuario no existe.',
    ];

    public static function rules($id = null)
    {
        $rules = self::$rules;

        // Ajustar las reglas de unicidad correctamente usando el formato adecuado
        $rules['numero'] = $id ? "required|integer|unique:compras,numero,$id,id" : 'required|integer|unique:compras,numero';

        return $rules;
    }
    
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    
}
