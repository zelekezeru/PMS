<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSummariesTable extends Migration
{
    public function up()
    {
        Schema::create('task_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->integer('all_tasks')->nullable()->default(0);
            $table->integer('pending_tasks')->nullable()->default(0);
            $table->integer('progress_tasks')->nullable()->default(0);
            $table->integer('completed_tasks')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_summaries');
    }
}
