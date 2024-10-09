<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Category extends Model implements AuditableContract
{
    // php artisan make:model Category
    use HasFactory,Auditable;
    protected $table = 'categoria';
    protected $fillable = ['nombre'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static $rules = [
        'nombre' => 'required|string|max:255|unique:categoria,nombre',
    ];

    public static $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.string' => 'El nombre debe ser una cadena de texto.',
        'nombre.max' => 'El nombre no puede exceder los 255 caracteres.',
        'nombre.unique' => 'El nombre ya está en uso.',
    ];
}
