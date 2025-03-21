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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->onDelete('cascade');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('budget', 255)->nullable();
            $table->string('barriers', 255)->nullable();
            $table->string('comunication', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->boolean('is_subtask')->default(false);
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('starting_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
