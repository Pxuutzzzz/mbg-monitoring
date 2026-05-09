<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sppgs', function (Blueprint $table) {
            $table->decimal('lat', 10, 6)->nullable()->after('location');
            $table->decimal('lng', 10, 6)->nullable()->after('lat');
        });
    }

    public function down(): void
    {
        Schema::table('sppgs', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng']);
        });
    }
};
