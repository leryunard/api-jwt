<?php

use App\Models\SchemaAudit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'roles',
            'auditable_id' => 1,
            'new_values' => [
                'name' => 'string',
                'estado' => 'boolean',
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
        Schema::dropIfExists('roles');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'roles',
            'auditable_id' => 1,
            'new_values' => [
                'name' => 'string',
                'estado' => 'boolean',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
    }
};
