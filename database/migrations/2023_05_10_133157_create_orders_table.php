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
            $table->string('currency',3)->index();
            $table->float('rate',12,6,true);
            $table->float('surcharge_pct',4,1,true);
            $table->unsignedBigInteger('surcharge');
            $table->unsignedBigInteger('purchased');
            $table->unsignedBigInteger('paid');
            $table->float('discount_pct',4,1,true);
            $table->unsignedBigInteger('discount');
            $table->string('action',10)->nullable();
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
