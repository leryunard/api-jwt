<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemaAudit extends Model
{
    use HasFactory;
    protected $table = 'schema_audits';
    protected $fillable = [
        'user_id',
        'auditable_type',
        'auditable_id',
        'new_values',
        'event',
        'performed_at',
    ];

    protected $casts = [
        'new_values' => 'array',
    ];
}
