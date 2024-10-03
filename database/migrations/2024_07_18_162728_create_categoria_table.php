<?php

use App\Models\SchemaAudit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     * php artisan make:migration create_categories_table --create=categories
     */
    public function up(): void
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->timestamps();
        });

        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'categoria',
            'auditable_id' => 1,
            'new_values' => [
                'name' => 'string',
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
        Schema::dropIfExists('categoria');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'categoria',
            'auditable_id' => 1,
            'new_values' => [
                'name' => 'string',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
    }
};
