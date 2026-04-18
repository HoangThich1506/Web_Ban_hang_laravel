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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('email',255)->unique();
            $table->string('phone',255)->unique();
            $table->string('username',255);
            $table->string('password',255);
            $table->string('address',255)->nullable();
            $table->string('image',255)->nullable();
            $table->enum('roles',['admin','user'])->default('user');
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
        Schema::dropIfExists('user');
    }
};
