<?php

use App\Models\SchemaAudit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan make:migration create_products_table --create=products
     */
    public function up(): void
    {
        Schema::create('almacen', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 255)->nullable();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->integer('stock');
            $table->integer('stock_minimo')->nullable();
            $table->integer('stock_maximo')->nullable();
            $table->string('precio_compra', 255);
            $table->string('precio_venta', 255);
            $table->date('fecha_ingreso');
            $table->text('imagen')->nullable();
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_categoria')->constrained('categoria');
            $table->timestamps();
        });
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'almacen',
            'auditable_id' => 1,
            'new_values' => [
                'id_producto' => 'id',
                'codigo' => 'string',
                'nombre' => 'string',
                'descripcion' => 'text',
                'stock' => 'integer',
                'stock_minimo' => 'integer',
                'stock_maximo' => 'integer',
                'precio_compra' => 'string',
                'precio_venta' => 'string',
                'fecha_ingreso' => 'date',
                'imagen' => 'text',
                'id_usuario' => 'foreignId',
                'id_categoria' => 'foreignId',
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
        Schema::dropIfExists('almacen');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'almacen',
            'auditable_id' => 1,
            'new_values' => [
                'id_producto' => 'id',
                'codigo' => 'string',
                'nombre' => 'string',
                'descripcion' => 'text',
                'stock' => 'integer',
                'stock_minimo' => 'integer',
                'stock_maximo' => 'integer',
                'precio_compra' => 'string',
                'precio_venta' => 'string',
                'fecha_ingreso' => 'date',
                'imagen' => 'text',
                'id_usuario' => 'foreignId',
                'id_categoria' => 'foreignId',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
    }
};
