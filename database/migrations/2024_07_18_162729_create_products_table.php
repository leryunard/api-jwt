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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->timestamps();
        });

        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'products',
            'auditable_id' => 1,
            'new_values' => [
                'name' => 'string',
                'description' => 'text',
                'price' => 'decimal',
                'category_id' => 'foreignId',
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
        Schema::dropIfExists('products');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'products',
            'auditable_id' => 1,
            'new_values' => [
                'name' => 'string',
                'description' => 'text',
                'price' => 'decimal',
                'category_id' => 'foreignId',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
    }
};
