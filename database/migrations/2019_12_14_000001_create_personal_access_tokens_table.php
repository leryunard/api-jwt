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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'personal_access_tokens',
            'auditable_id' => 1,
            'new_values' => [
                'tokenable' => 'morphs',
                'name' => 'string',
                'token' => 'string',
                'abilities' => 'text',
                'last_used_at' => 'timestamp',
                'expires_at' => 'timestamp',
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
        Schema::dropIfExists('personal_access_tokens');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'personal_access_tokens',
            'auditable_id' => 1,
            'new_values' => [
                'tokenable' => 'morphs',
                'name' => 'string',
                'token' => 'string',
                'abilities' => 'text',
                'last_used_at' => 'timestamp',
                'expires_at' => 'timestamp',
                'created_at' => 'timestamp',
                'updated_at' => 'timestamp',
            ],
            'event' => 'dropped',
        ]);
        $schemaAudit->save();
    }
};
