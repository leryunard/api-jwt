<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Proveedor extends Model implements AuditableContract
{
    use HasFactory, Auditable;
    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'celular', 'telefono', 'empresa', 'email', 'direccion'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static $rules = [
        'nombre' => 'required|string|max:255|unique:proveedores,nombre,$id,id',
        'celular' => 'required|string|max:50',
        'telefono' => 'nullable|string|max:50',
        'empresa' => 'required|string|max:255',
        'email' => 'nullable|string|email:rfc,dns|max:50|unique:proveedores,email',
        'direccion' => 'required|string|max:255',
    ];

    public static $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string' => 'El nombre debe ser una cadena de texto.',
        'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
        'nombre.unique' => 'El nombre ya está en uso.',
        'celular.required' => 'El celular es obligatorio.',
        'celular.string' => 'El celular debe ser una cadena de texto.',
        'celular.max' => 'El celular no puede exceder los 50 caracteres.',
        'telefono.string' => 'El telefono debe ser una cadena de texto.',
        'telefono.max' => 'El telefono no puede exceder los 50 caracteres.',
        'empresa.required' => 'La empresa es obligatoria.',
        'empresa.string' => 'La empresa debe ser una cadena de texto.',
        'empresa.max' => 'La empresa no puede exceder los 255 caracteres.',
        'email.string' => 'El email debe ser una cadena de texto.',
        'email.max' => 'El email no puede exceder los 50 caracteres.',
        'email.unique' => 'El correo electrónico ya está en uso.',
        'direccion.required' => 'La dirección es obligatoria.',
        'direccion.string' => 'La dirección debe ser una cadena de texto.',
        'direccion.max' => 'La dirección no puede exceder los 255 caracteres.',
        'email.email' => 'El campo de correo electrónico debe ser una dirección de correo electrónico válida.',
    ];

    public static function rules($id = null)
    {
        $rules = self::$rules;

        // Ajustar las reglas de unicidad correctamente usando el formato adecuado
        $rules['nombre'] = $id ? "required|string|max:255|unique:proveedores,nombre,$id,id" : 'required|string|max:255|unique:proveedores,nombre';

        $rules['email'] = $id ? "nullable|string|email:rfc,dns|max:50|unique:proveedores,email,$id,id" : 'nullable|string|email:rfc,dns|unique:proveedores,email';

        return $rules;
    }
}
