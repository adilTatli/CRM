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
        Schema::create('task_billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->decimal('labor_cost', 12, 4)->nullable();
            $table->decimal('parts_retails', 12, 4)->nullable();
            $table->decimal('parts_cost', 12, 4)->nullable();
            $table->decimal('other_cost', 12, 4)->nullable();
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('tax_amount', 5, 2)->nullable();
            $table->decimal('total_cost', 12, 4)->nullable();
            $table->decimal('unpaid_amount', 12, 4)->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('billed_job_note')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('appointment_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_billings');
    }
};
