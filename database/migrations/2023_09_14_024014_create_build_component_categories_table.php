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
        Schema::create('build_component_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpu')->nullable()->references('id')->on('categories');
            $table->foreignId('cooler')->nullable()->references('id')->on('categories');
            $table->foreignId('ram')->nullable()->references('id')->on('categories');
            $table->foreignId('gpu')->nullable()->references('id')->on('categories');
            $table->foreignId('psu')->nullable()->references('id')->on('categories');
            $table->foreignId('mobo')->nullable()->references('id')->on('categories');
            $table->foreignId('case')->nullable()->references('id')->on('categories');
            $table->foreignId('rom')->nullable()->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_component_categories');
    }
};
