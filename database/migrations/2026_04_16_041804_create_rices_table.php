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
        Schema::create('rices', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Rice name (Jasmine, Brown, Dinorado)
            $table->decimal('price_per_kg', 8, 2); // Price per kilogram
            $table->integer('stock_quantity'); // Stock quantity
            $table->text('description')->nullable(); // Description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rices');
    }
};
