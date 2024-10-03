<?php

use App\Models\SchemaAudit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('celular', 50);
            $table->string('telefono', 50)->nullable();
            $table->string('empresa', 255);
            $table->string('email', 50)->nullable();
            $table->string('direccion', 255);
            $table->timestamps();
        });

        $schemaAudit = SchemaAudit::create([
            'auditable_type' => 'proveedores',
            'auditable_id' => 1,
            'new_values' => [
                'nombre' => 'string',
                'celular' => 'string',
                'telefono' => 'string',
                'empresa' => 'string',
                'email' => 'string',
                'direccion' => 'string',
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
        $schemaAudit = SchemaAudit::create([
            'auditable_type' => 'proveedores',
            'auditable_id' => 1,
            'new_values' => [
                'nombre' => 'string',
                'celular' => 'string',
                'telefono' => 'string',
                'empresa' => 'string',
                'email' => 'string',
                'direccion' => 'string',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
        Schema::dropIfExists('proveedores');
    }
};
