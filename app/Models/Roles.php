<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Roles extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'estado' => 'boolean',
    ];
    public static $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
    ];

    public static $messages = [
        'name.required' => 'El campo nombre es obligatorio.',
        'name.string' => 'El campo nombre debe ser una cadena de texto.',
        'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
        'name.unique' => 'El nombre del rol ya existe.',
    ];
}
