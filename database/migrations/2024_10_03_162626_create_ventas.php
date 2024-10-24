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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id(); 
            $table->integer('total_pagado');
            $table->unsignedBigInteger('num_venta'); // Aseguramos que sea el mismo tipo
            $table->foreign('num_venta')->references('num_venta')->on('carrito')->onDelete('cascade');
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->timestamps();
        });


        $schemaAudit = new SchemaAudit ([
            'auditable_type' => 'ventas',
            'auditable_id' => 1,
            'new_values' => [
                'id_venta' => 'id',
                'id_cliente' => 'integer',
                'total_pagado' => 'integer',
                'num_venta' => 'foreignId',
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
            'auditable_type' => 'ventas',
            'auditable_id' => 1,
            'new_values' => [
                'id_venta' => 'id',
                'id_cliente' => 'integer',
                'total_pagado' => 'integer',
                'num_venta' => 'foreignId',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'deleted',
        ]);
        $schemaAudit->save();
        Schema::dropIfExists('ventas');
    }
};
