<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->date('rental_start_date');
            $table->date('rental_end_date');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('deposit_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('rental_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id');
            $table->string('product_name');
            $table->decimal('rental_price', 12, 2)->default(0);
            $table->decimal('deposit_price', 12, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_order_details');
        Schema::dropIfExists('rental_orders');
    }
};
