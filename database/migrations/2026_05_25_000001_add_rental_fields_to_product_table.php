<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->decimal('rental_price', 12, 2)->default(0);
            $table->decimal('deposit_price', 12, 2)->default(0);
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('occasion')->nullable();
            $table->string('style')->nullable();
            $table->integer('rental_days')->default(3);
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn([
                'rental_price',
                'deposit_price',
                'size',
                'color',
                'occasion',
                'style',
                'rental_days',
            ]);
        });
    }
};
