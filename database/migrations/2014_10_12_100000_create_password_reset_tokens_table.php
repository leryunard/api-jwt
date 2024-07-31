<?php

use App\Models\SchemaAudit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'password_reset_tokens',
            'auditable_id' => 1,
            'new_values' => [
                'email' => 'string',
                'token' => 'string',
                'created_at' => 'timestamp',
            ],
            'event' => 'created',
            'performed_at' => now(),
        ]);
        $schemaAudit->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'schema',
            'auditable_id' => 'password_reset_tokens',
            'new_values' => [
                'user' => auth()->user(),
                'email' => 'string',
                'token' => 'string',
                'created_at' => 'timestamp',
            ],
            'event' => 'dropped',
            'performed_at' => now(),
        ]);
        $schemaAudit->save();
    }
};
