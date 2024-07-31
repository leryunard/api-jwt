<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SchemaAudit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::beginTransaction();

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });

            $schemaAudit = new SchemaAudit([
                'auditable_type' => 'users',
                'auditable_id' => 1,
                'new_values' => [
                    'id' => 'bigint',
                    'name' => 'string',
                    'email' => 'string',
                    'email_verified_at' => 'timestamp',
                    'password' => 'string',
                    'remember_token' => 'string',
                    'timestamps' => 'timestamps',
                ],
                'event' => 'created',
                'performed_at' => now(),
            ]);
            $schemaAudit->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception here
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        $schemaAudit = new SchemaAudit([
            'auditable_type' => 'schema',
            'auditable_id' => 'users',
            'new_values' => [
                'id' => 'bigint',
                'name' => 'string',
                'email' => 'string',
                'email_verified_at' => 'timestamp',
                'password' => 'string',
                'remember_token' => 'string',
                'timestamps' => 'timestamps',
            ],
            'event' => 'dropped',
            'performed_at' => now(),
        ]);
        $schemaAudit->save();
    }
};
