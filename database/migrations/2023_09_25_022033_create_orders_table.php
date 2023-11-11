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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['En proceso', 'En revisión', 'Pagado', 'Enviado', 'Entregado', 'Cancelado'])->default('En proceso');
            $table->json('products');
            $table->float('total');
            $table->integer('quantity');
            $table->string('invoice')->nullable();
            $table->string('guide')->nullable();
            $table->string('service')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('phone');
            $table->string('second_phone')->nullable();
            $table->string('email');
            $table->string('nit');
            $table->string('department');
            $table->string('municipality');
            $table->string('address');
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
