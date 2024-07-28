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
        Schema::create('received_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->decimal('payment', 12, 4);
            $table->enum('payment_status', ['check', 'cash', 'credit card', 'eft', 'warranty', 'other']);
            $table->string('pay_doc')->nullable();
            $table->date('date_received');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_payments');
    }
};
