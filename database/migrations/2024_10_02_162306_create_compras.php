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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->date('fecha');
            $table->string('comprobante', 255);
            $table->decimal('precio',4,2);
            $table->integer('cantidad');
            $table->foreignId('id_almacen')->constrained('almacen');
            $table->foreignId('id_proveedor')->constrained('proveedores');
            $table->foreignId('id_usuario')->constrained('users');
            $table->timestamps();
        });
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'compras',
            'auditable_id' => 1,
            'new_values' => [
                'numero' => 'integer',
                'fecha' => 'date',
                'comprobante' => 'string',
                'precio' => 'decimal',
                'cantidad' => 'integer',
                'id_almacen' => 'foreignId',
                'id_proveedor' => 'foreignId',
                'id_usuario' => 'foreignId',
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
            'auditable_type' => 'compras',
            'auditable_id' => 1,
            'new_values' => [
                'numero' => 'integer',
                'fecha' => 'date',
                'comprobante' => 'string',
                'precio' => 'decimal',
                'cantidad' => 'integer',
                'id_almacen' => 'foreignId',
                'id_proveedor' => 'foreignId',
                'id_usuario' => 'foreignId',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
        Schema::dropIfExists('compras');
    }
};
