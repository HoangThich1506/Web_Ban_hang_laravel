<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('banner', 'image')) {
            Schema::table('banner', function (Blueprint $table) {
                $table->string('image', 1000)->nullable()->after('description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('banner', 'image')) {
            Schema::table('banner', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
