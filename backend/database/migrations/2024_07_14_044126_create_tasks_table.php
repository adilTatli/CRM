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
            $table->string('work_order');
            $table->string('customer_name');
            $table->string('street');
            $table->string('city');
            $table->string('zip');
            $table->text('authorization')->nullable();
            $table->foreignId('insurance_id')->constrained()->onDelete('restrict');
            $table->foreignId('status_id')->constrained('task_statuses')->onDelete('restrict');
            $table->timestamps();
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
