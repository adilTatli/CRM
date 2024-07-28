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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_number_id')->constrained()->onDelete('restrict');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('appliance_id')->constrained()->onDelete('restrict');
            $table->foreignId('distributor_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('status_id')->constrained('part_statuses')->onDelete('restrict');
            $table->integer('qnt');
            $table->float('dealer_price');
            $table->float('retail_price');
            $table->string('distributor_name')->nullable();
            $table->text('part_description')->nullable();
            $table->string('distributor_invoice')->nullable();
            $table->date('eta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
