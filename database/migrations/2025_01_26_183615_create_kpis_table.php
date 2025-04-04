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
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->nullable()->default(null)->onDelete('cascade');
            $table->foreignId('target_id')->nullable()->default(null)->onDelete('cascade');
            $table->string('name', 255);
            $table->decimal('value', 10, 2)->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('status', 50)->nullable()->default('Created');
            $table->boolean('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
