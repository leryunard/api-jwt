<?php

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
        Schema::create('schema_audits', function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type');
            $table->string('auditable_id')->nullable();
            $table->json('new_values')->nullable();
            $table->string('event');
            $table->timestamp('performed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schema_audits');
    }
};
