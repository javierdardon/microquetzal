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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('paymentMethod')->after('payment');
            $table->string('paymentType')->after('paymentMethod');
            $table->string('card')->nullable()->after('paymentType');
            $table->string('dues')->nullable()->after('card');
            $table->float('duesQuantity')->nullable()->after('dues');
            $table->string('shipping')->after('shipping_date');
            $table->float('total_shipping')->after('shipping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('paymentMethod');
            $table->dropColumn('paymentType',);
            $table->dropColumn('card');
            $table->dropColumn('dues');
            $table->dropColumn('duesQuantity');
            $table->dropColumn('shipping',);
            $table->dropColumn('total_shipping');
        });
    }
};
