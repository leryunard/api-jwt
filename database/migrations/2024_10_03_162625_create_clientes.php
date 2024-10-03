<?php

use App\Models\SchemaAudit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('nit', 255);
            $table->string('celular', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->timestamps();
        });
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'clientes',
            'auditable_id' => 1,
            'new_values' => [
                'id_cliente' => 'id',
                'nombre' => 'string',
                'nit' => 'string',
                'celular' => 'string',
                'email' => 'string',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'created',
        ]);
        $schemaAudit->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'clientes',
            'auditable_id' => 1,
            'new_values' => [
                'id_cliente' => 'id',
                'nombre' => 'string',
                'nit' => 'string',
                'celular' => 'string',
                'email' => 'string',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'deleted',
        ]);
        $schemaAudit->save();
        Schema::dropIfExists('clientes');
    }
};
