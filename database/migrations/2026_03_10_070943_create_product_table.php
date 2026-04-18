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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('name',1000);
            $table->string('slug',1000);
            $table->float('price_buy');
            $table->float('price_sale')->nullable();
            $table->string('image',1000);
            $table->integer('qty')->unsigned();
            $table->mediumText('detail');
            $table->text('description')->nullable();
            $table->timestamp('created_at');
            $table->integer('created_by')->unsigned()->default(1);
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->tinyInteger('status')->unsigned()->default(2);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
