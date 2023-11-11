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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('images');
            $table->decimal('price');
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->text('description')->nullable();
            $table->string('warranty');
            $table->json('details')->nullable();
            $table->integer('quantity');
            $table->boolean('visacuotas');
            $table->boolean('featured');
            $table->string('condition');
            $table->boolean('shipping');
            $table->boolean('sale');
            $table->integer('percentage');
            $table->decimal('sale_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
