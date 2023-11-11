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
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('images');
            $table->decimal('price');
            $table->foreignId('cpu_id')->nullable()->constrained('products', 'id');
            $table->string('cpu_name')->nullable();
            $table->text('cpu_link')->nullable();
            $table->foreignId('cooler_id')->nullable()->constrained('products', 'id');
            $table->string('cooler_name')->nullable();
            $table->text('cooler_link')->nullable();
            $table->foreignId('ram_id')->nullable()->constrained('products', 'id');
            $table->string('ram_name')->nullable();
            $table->text('ram_link')->nullable();
            $table->foreignId('gpu_id')->nullable()->constrained('products', 'id');
            $table->string('gpu_name')->nullable();
            $table->text('gpu_link')->nullable();
            $table->foreignId('psu_id')->nullable()->constrained('products', 'id');
            $table->string('psu_name')->nullable();
            $table->text('psu_link')->nullable();
            $table->foreignId('mobo_id')->nullable()->constrained('products', 'id');
            $table->string('mobo_name')->nullable();
            $table->text('mobo_link')->nullable();
            $table->foreignId('case_id')->nullable()->constrained('products', 'id');
            $table->string('case_name')->nullable();
            $table->text('case_link')->nullable();
            $table->foreignId('rom_id')->nullable()->constrained('products', 'id');
            $table->string('rom_name')->nullable();
            $table->text('rom_link')->nullable();
            $table->text('description')->nullable();
            $table->string('gama');
            $table->string('warranty');
            $table->json('details')->nullable();
            $table->integer('quantity');
            $table->boolean('visacuotas');
            $table->boolean('shipping');
            $table->boolean('featured');
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
        Schema::dropIfExists('builds');
    }
};
