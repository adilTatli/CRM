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
        Schema::create('appliance_lists', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('model_number');
            $table->string('brand');
            $table->date('dop')->nullable();
            $table->text('appl_note')->nullable();
            $table->foreignId('appliance_id')->constrained()->onDelete('restrict');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appliance_lists');
    }
};
