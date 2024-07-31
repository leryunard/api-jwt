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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'role_user',
            'auditable_id' => 1,
            'new_values' => [
                'user_id' => 'foreignId',
                'role_id' => 'foreignId',
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
        Schema::dropIfExists('role_user');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'role_user',
            'auditable_id' => 1,
            'new_values' => [
                'user_id' => 'foreignId',
                'role_id' => 'foreignId',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
    }
};
