<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Clientes extends Model implements AuditableContract
{
    use HasFactory,Auditable;
    protected $table = 'clientes';
    protected $fillable = ['id', 'nombre', 'nit', 'celular', 'email'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public static $rules = [
        'nombre' => 'required|string|unique:clientes,nombre|max:255',
        'nit' => 'required|string|max:255',
        'celular' => 'required|string|max:255',
        'email' => 'required|string|email:rfc,dns|max:255|unique:clientes,email',
    ];
    
    public static $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string' => 'El nombre debe ser una cadena de texto.',
        'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
        'nombre.unique' => 'El nombre ya está en uso.',
        'nit.required' => 'El nit es obligatorio.',
        'nit.string' => 'El nit debe ser una cadena de texto.',
        'nit.max' => 'El nit no puede exceder los 255 caracteres.',
        'celular.required' => 'El celular es obligatorio.',
        'celular.string' => 'El celular debe ser una cadena de texto.',
        'celular.max' => 'El celular no puede exceder los 255 caracteres.',
        'email.required' => 'El email es obligatorio.',
        'email.string' => 'El email debe ser una cadena de texto.',
        'email.max' => 'El email no puede exceder los 255 caracteres.',
        'email.unique' => 'El correo electrónico ya está en uso.',
    ];
    
}
